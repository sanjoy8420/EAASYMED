<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
   @include('admin.css')
  </head>
  <body>
    <div class="container-scroller">
     
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar')
      <!-- partial -->
      
        <!-- partial:partials/_navbar.html -->
        @include('admin.navbar')
       
        <div class="container-fluid page-body-wrapper">

        <div align="center" style="padding-top:70px;">
            <table>
                <tr style="background-color:orange;" align="center">
                    <th style="padding:10px; font-size: 20px; color:white;">Customer Name</th>
                    <th style="padding:10px; font-size: 20px; color:white;">Email</th>
                    <th style="padding:10px; font-size: 20px; color:white;">Phone</th>
                    <th style="padding:10px; font-size: 20px; color:white;">Doctor Name</th>
                    <th style="padding:10px; font-size: 20px; color:white;">Date</th>
                    <th style="padding:10px; font-size: 20px; color:white;">Message</th>
                    <th style="padding:10px; font-size: 20px; color:white;"> Status</th>
                    <th style="padding:10px; font-size: 20px; color:white;"> Approved</th>
                    <th style="padding:10px; font-size: 20px; color:white;"> Cancel</th>
                </tr>

                @foreach($data as $appoint)
                <tr align="center" style="background-color:pink;" >
                    <td style=" color:black;">{{$appoint->name}}</td>
                    <td style=" color:black;">{{$appoint->email}}</td>
                    <td style=" color:black;">{{$appoint->phone}}</td>
                    <td style=" color:black;"> {{ $appoint->doctor ? $appoint->doctor->name : 'N/A' }}</td>
                    <td style=" color:black;">{{$appoint->date}}</td>
                    <td style=" color:black;">{{$appoint->message}}</td>
                    <td style=" color:black;">{{$appoint->status}}</td>
                    <td>
                        <a class="btn btn-success" href="{{url('approved',$appoint->id)}}">Approved</a>
                    </td>
                    <td>
                        <a class="btn btn-danger" href="{{url('canceled',$appoint->id)}}">Canceled</a>
                    </td>
                </tr>

                @endforeach

            </table>
        </div>





         </div>





    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
       @include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>