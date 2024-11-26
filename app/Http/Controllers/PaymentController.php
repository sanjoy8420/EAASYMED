
<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use PDF;

class PaymentController extends Controller
{
    private $razorpayKeyId;
    private $razorpayKeySecret;

    public function __construct()
    {
        $this->razorpayKeyId = config('services.razorpay.key_id');
        $this->razorpayKeySecret = config('services.razorpay.key_secret');
    }

    /**
     * Initiate the payment process
     */
    public function initiatePayment(Request $request, $appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);

        // Razorpay API instance
        $api = new Api($this->razorpayKeyId, $this->razorpayKeySecret);

        // Create an order in Razorpay
        $orderData = [
            'receipt'         => 'Receipt#' . $appointment->id,
            'amount'          => $appointment->fee * 100, // amount in paisa
            'currency'        => 'INR',
        ];
        $razorpayOrder = $api->order->create($orderData);
        
        // Save transaction as pending
        $transaction = Transaction::create([
            'appointment_id' => $appointment->id,
            'user_id'        => auth()->id(),
            'transaction_id' => $razorpayOrder['id'],
            'status'         => 'pending',
            'amount'         => $appointment->fee,
        ]);

        return view('payment.checkout', [
            'orderId' => $razorpayOrder['id'],
            'amount' => $appointment->fee,
            'appointment' => $appointment,
        ]);
    }

    /**
     * Verify payment
     */
    public function verifyPayment(Request $request)
    {
        $signature = $request->razorpay_signature;
        $paymentId = $request->razorpay_payment_id;
        $orderId = $request->razorpay_order_id;

        $api = new Api($this->razorpayKeyId, $this->razorpayKeySecret);

        try {
            // Signature verification
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $orderId,
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature
            ]);

            // Update transaction status to successful
            $transaction = Transaction::where('transaction_id', $orderId)->first();
            $transaction->status = 'successful';
            $transaction->save();

            return redirect()->route('appointment.details', $transaction->appointment_id)
                ->with('success', 'Payment successful!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Payment verification failed!');
        }
    }

    /**
     * Download Invoice PDF
     */
    public function downloadInvoice($appointmentId)
    {
        $appointment = Appointment::with('doctor', 'user')->findOrFail($appointmentId);
        $transaction = Transaction::where('appointment_id', $appointmentId)->where('status', 'successful')->firstOrFail();

        $pdf = PDF::loadView('invoices.invoice', compact('appointment', 'transaction'));

        return $pdf->download('invoice_' . $appointment->id . '.pdf');
    }
}
