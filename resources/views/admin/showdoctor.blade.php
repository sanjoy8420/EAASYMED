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
                    <th style="padding:10px; font-size: 20px; color:white;">Doctor Name</th>
                    <th style="padding:10px; font-size: 20px; color:white;">Phone</th>
                    <th style="padding:10px; font-size: 20px; color:white;">Speciality</th>                   
                    <th style="padding:10px; font-size: 20px; color:white;">Room No</th>
                    <th style="padding:10px; font-size: 20px; color:white;">Image</th>
                    <th style="padding:10px; font-size: 20px; color:white;">Delete</th>
                    <th style="padding:10px; font-size: 20px; color:white;">Update</th>

                </tr>
                @foreach($data as $doctor)
                <tr align="center" style="background-color:pink;">
                    <td>{{$doctor->name}}</td>
                    <td>{{$doctor->phone}}</td>
                    <td>{{$doctor->speciality}}</td>
                    <td>{{$doctor->room}}</td>
                    <td><img height="100" width="100" src="doctorimage/{{$doctor->image}}"></td>
                    <td>
                        <a onclick="return confirm('are you sure to delete this')" class="btn btn-danger" href="{{url('deletedoctor',$doctor->id)}}">Delete</a>
                    </td>
                    <td>
                        <a class="btn btn-primary" href="{{url('updatedoctor',$doctor->id)}}">Update</a>
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