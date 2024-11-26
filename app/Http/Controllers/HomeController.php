<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Appointment;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentInvoice;

class HomeController extends Controller
{
    public function redirect()
    {
        if(Auth::id())
        {
            if(Auth::user()->usertype=='0')
            {
                $doctor = doctor::all();
                return view('user.home',compact('doctor'));
            }
            else
            {
                return view('admin.home');
            }
        }

        else
        {
            return redirect()->back();
        }
    }

    public function index()
    {
        if(Auth::id())
        {
            return redirect('home');
        }
        else
        {
        $doctor = doctor::all();
        return view('user.home',compact('doctor'));
        }
    }

    
    
  public function getAvailableTimeSlots(Request $request)
  {
      try {
          $doctorId = $request->doctor_id;
          $date = $request->date;
  
          if (!$doctorId || !$date) {
              return response()->json(['error' => 'Missing doctor ID or date'], 400);
          }
  
          // Fetch bookings grouped by time slot
          $bookings = Appointment::where('doctor_id', $doctorId)
              ->where('date', $date)
              ->get()
              ->groupBy('time_slot');
  
          // Define time slots (could also be fetched from config or database)
          $timeSlots = [
              '9:00 AM - 10:00 AM',
              '10:00 AM - 11:00 AM',
              '11:00 AM - 12:00 PM',
              '2:00 PM - 3:00 PM',
              '3:00 PM - 4:00 PM'
          ];
  
          $availableSlots = [];
          $maxCapacity = 20; // Limit to 20 patients per slot
  
          // Calculate available slots
          foreach ($timeSlots as $slot) {
              $bookedCount = isset($bookings[$slot]) ? $bookings[$slot]->count() : 0;
              $available = $maxCapacity - $bookedCount;
  
              // Add only available slots to the response
              if ($available > 0) {
                  $availableSlots[] = [
                      'time_slot' => $slot,
                      'available' => $available,
                      'bookings' => $bookedCount
                  ];
              }
          }
  
          return response()->json($availableSlots);
      } catch (\Exception $e) {
          \Log::error('Error fetching time slots: ' . $e->getMessage());
          return response()->json(['error' => 'Something went wrong'], 500);
      }
  }
  
  public function appointment(Request $request)
 {
    $doctorId = $request->doctor;
    $date = $request->date;
    $timeSlot = $request->time_slot;

    // Check if the selected time slot is full (max 20 bookings)
    $existingBookings = Appointment::where('doctor_id', $doctorId)
        ->where('date', $date)
        ->where('time_slot', $timeSlot)
        ->count();

    if ($existingBookings >= 20) {
        return redirect()->back()->with('error', 'This time slot is fully booked. Please select another slot.');
    }

    // Save the appointment if the slot is available
    $data = new Appointment;
    $data->name = $request->name;
    $data->email = $request->email;
    $data->phone = $request->number;
    $data->doctor_id = $doctorId;
    $data->date = $date;
    $data->time_slot = $timeSlot;
    $data->message = $request->message;
    $data->status = 'In progress';

    if (Auth::id()) {
        $data->user_id = Auth::user()->id;
    }

    $data->save();

    session()->flash('status', 'success');
    session()->flash('message', 'Appointment booked successfully.');
    return redirect()->back();
    
 }




    public function myappointment()
    {
        if (Auth::id()) {
            if (Auth::user()->usertype == 0) {
                $userid = Auth::user()->id;
                // Eager load the doctor relationship
                $appointments = Appointment::where('user_id', $userid)->with('doctor')->get();
                return view('user.my_appointment', compact('appointments'));
            } else {
                return redirect('login');
            }
        } else {
            return redirect()->back();
        }
    } 


      public function cancel_appoint($id)
      {

        $data=appointment::find($id);
        $data->delete();
        return redirect()->back();
      }

      public function verifyPayment(Request $request)
    {
        // Retrieve payment details
        $paymentId = $request->input('razorpay_payment_id');
        $appointmentId = $request->input('appointment_id');

        // Update appointment's payment status
        $appointment = Appointment::find($appointmentId);
        if ($appointment) {
            $appointment->payment_status = 'Paid';
            $appointment->payment_id = $paymentId;
            $appointment->save();
            Mail::to($appointment->email)->send(new AppointmentInvoice($appointment));
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }



public function generateInvoice($id)
{
    // Retrieve the appointment
    $appointment = Appointment::findOrFail($id);

    // Ensure the payment status is "Paid"
    if ($appointment->payment_status !== 'Paid') {
        return redirect()->back()->with('error', 'Invoice can only be generated for paid appointments.');
    }

    $pdf = PDF::loadView('invoices.appointment', compact('appointment'));

    return $pdf->download('invoice_' . $appointment->id . '.pdf');
    // Send the email

    // return redirect()->back()->with('success', 'Invoice generated and emailed successfully.');
}

  

}
