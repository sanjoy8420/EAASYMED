<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <meta name="copyright" content="MACode ID, https://macodeid.com/">

  <title>Easy Med - Medical Center HTML5 Template</title>

  <link rel="stylesheet" href="../assets/css/maicons.css">

  <link rel="stylesheet" href="../assets/css/bootstrap.css">

  <link rel="stylesheet" href="../assets/vendor/owl-carousel/css/owl.carousel.css">

  <link rel="stylesheet" href="../assets/vendor/animate/animate.css">

  <link rel="stylesheet" href="../assets/css/theme.css">


  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <script src="https://checkout.razorpay.com/v1/checkout.js"> </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

 

</head>

<body>

  <!-- Back to top button -->
  <div class="back-to-top"></div>

  <header>
    <div class="topbar">
      <div class="container">
        <div class="row">
          <div class="col-sm-8 text-sm">
            <div class="site-info">
              <a href="#"><span class="mai-call text-primary"></span> +00 123 4455 6666</a>
              <span class="divider">|</span>
              <a href="#"><span class="mai-mail text-primary"></span> mail@example.com</a>
            </div>
          </div>
          <div class="col-sm-4 text-right text-sm">
            <div class="social-mini-button">
              <a href="#"><span class="mai-logo-facebook-f"></span></a>
              <a href="#"><span class="mai-logo-twitter"></span></a>
              <a href="#"><span class="mai-logo-dribbble"></span></a>
              <a href="#"><span class="mai-logo-instagram"></span></a>
            </div>
          </div>
        </div> <!-- .row -->
      </div> <!-- .container -->
    </div> <!-- .topbar -->

    <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
      <div class="container">
        <a class="navbar-brand" href="{{url('/')}}"><span class="text-primary">Easy</span>-Med</a>

      

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupport" aria-controls="navbarSupport" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupport">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="{{url('/')}}">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('/myappointment')}}">About Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('/myappointment')}}">Doctors</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('/myappointment')}}">News</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('/myappointment')}}">Contact</a>
            </li>
            @if(Route::has('login'))
            @auth
            <li class="nav-item">
              <a class="nav-link" style="background-color:greenyellow; color:white;" href="{{url('myappointment')}}">My Appointment</a>
            </li>
            <x-app-layout>
  
            </x-app-layout>


            @else
            <li class="nav-item">
              <a class="btn btn-primary ml-lg-3" href="{{route('login')}}">Login</a>
            </li>
            <li class="nav-item">
              <a class="btn btn-primary ml-lg-3" href="{{route('register')}}">Register</a>
            </li>

            @endauth
            @endif

          </ul>
        </div> <!-- .navbar-collapse -->
      </div> <!-- .container -->
    </nav>
  </header>

<div align="center" style="padding:70px;">

  <table>
    <tr style="background-color:orange;" align="center">
      <th style="padding:20px; font-size: 20px; color:white;">Patient Name </th>
        <th style="padding:20px; font-size: 20px; color:white;">Doctor Name </th>
        <th style="padding:20px; font-size: 20px; color:white;">Appointment Date&Time</th>
        <th style="padding:20px; font-size: 20px; color:white;"> Message</th>
        {{-- <th style="padding:20px; font-size: 20px; color:white;"> Status</th> --}}
        <th style="padding:20px; font-size: 20px; color:white;"> Cancel Appointment</th>
        <th style="padding:20px; font-size: 20px; color:white;"> Payment Status</th>
        <th style="padding:20px; font-size: 20px; color:white;"> Download Invoice</th>

    </tr>

    @foreach($appointments as $appointment)
    <tr align="center">
        <!-- Display Patient Name -->
        <td style="padding:10px;">{{ $appointment->name }}</td>
    
        <!-- Display Doctor's Name -->
        <td style="padding:10px;">
            {{ $appointment->doctor ? $appointment->doctor->name : 'N/A' }}
        </td>
    
        <td style="padding:10px;">{{ $appointment->date }} | {{ $appointment->time_slot}} </td>
        <td style="padding:10px;">{{ $appointment->message }}</td>
        {{-- <td style="padding:10px;">{{ $appointment->status }}</td> --}}
        <td>
          <button class="btn btn-danger" 
              style="padding: 5px 10px; font-size: 12px;" 
              onclick="confirmCancel('{{ $appointment->id }}')">
               Cancel
           </button>
         </td>

        <td style="padding:5px;">
          @if ($appointment->payment_status === 'Paid')
            <span class="text-success">Payment Successful</span>
          @else
            <button id="rzp-button{{ $appointment->id }}" class="btn btn-success"  style="padding: 5px 10px; font-size: 12px;"
                    onclick="makePayment('{{ $appointment->id }}')">
              Pay ₹500
            </button>
          @endif
        </td>
        <td>
          @if($appointment->payment_status === 'Paid')
              <a href="{{ route('invoice.download', $appointment->id) }}" class="btn btn-primary btn-sm">
                  Download Invoice
              </a>
          @else
              <span class="text-danger">Payment Pending</span>
          @endif
      </td>
        

    </tr>
    @endforeach
  </table>


</div>




<script src="../assets/js/jquery-3.5.1.min.js"></script>

<script src="../assets/js/bootstrap.bundle.min.js"></script>

<script src="../assets/vendor/owl-carousel/js/owl.carousel.min.js"></script>

<script src="../assets/vendor/wow/wow.min.js"></script>

<script src="../assets/js/theme.js"></script>
  
<script>
  function makePayment(appointmentId) {
    var options = {
        "key": "rzp_test_xw9xHtHhaVrfXY", // Replace with your Razorpay Key ID
        "amount": 50000, // Amount is in paise (₹500 = 50000 paise)
        "currency": "INR",
        "name": "Easy Med",
        "description": "Appointment Payment",
        "image": "https://example.com/logo.png", // Optional logo URL
        "handler": function (response) {
            // Send payment details to the server
            $.ajax({
                url: "/verify_payment", // Your Laravel route to handle payment verification
                type: "POST",
                data: {
                    razorpay_payment_id: response.razorpay_payment_id,
                    appointment_id: appointmentId,
                    _token: "{{ csrf_token() }}" // CSRF token for security
                },
                success: function (data) {
                    if (data.success) {
                        // Show SweetAlert success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Payment Successful!',
                            text: 'Thank you for your payment. Your appointment is confirmed.',
                            showConfirmButton: false,
                            timer: 4000
                        }).then(() => {
                            location.reload(); // Reload the page after alert
                        });
                    } else {
                        // Show SweetAlert error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Payment Verification Failed',
                            text: 'There was an issue verifying your payment. Please contact support.',
                        });
                    }
                },
                error: function () {
                    // Show SweetAlert error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Payment Failed',
                        text: 'Something went wrong. Please try again.',
                    });
                }
            });
        },
        "prefill": {
            "name": "{{ auth()->user()->name }}", // Pre-filled user name
            "email": "{{ auth()->user()->email }}" // Pre-filled user email
        },
        "theme": {
            "color": "#3399cc" // Customize Razorpay button color
        }
    };

    var rzp1 = new Razorpay(options);
    rzp1.open();
}

function confirmCancel(appointmentId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, cancel it!'
       }).then((result) => {
        if (result.isConfirmed) {
            // Redirect to the cancel appointment URL
            window.location.href = "{{ url('cancel_appoint') }}/" + appointmentId;

            // Optional success alert (triggered after page redirection)
            Swal.fire({
                title: 'Cancelled!',
                text: 'Your appointment has been cancelled.',
                icon: 'success',
                
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6',
                
               // confirmButtonColor: '#ffffff', // OK button text color
               
            });
        }
    });
}

</script>


</body>
</html>