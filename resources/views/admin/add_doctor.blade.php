<!DOCTYPE html>
<html lang="en">
  <head>
    
 <style type="text/css">
    label
    {
         display: inline-block;
         width: 200px;
    }
 </style>


   @include('admin.css')
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  </head>
  <body>
    <div class="container-scroller">
     
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar')
      <!-- partial -->
      
        <!-- partial:partials/_navbar.html -->
        @include('admin.navbar')
    
        <div class="container-fluid page-body-wrapper">
           

         <div class="container" align="center" style="padding-top: 100px;">
        <script>
              @if(Session::has('message'))
              toastr.success("{{session('message')}}")
              @endif
        </script>
            <form action="{{url('upload_doctor')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="padding:15px;">
                    <label>Doctor Name</label>
                    <input type="text" style="color:black" name="name" placeholder="write the name" required="">
                </div>

                <div style="padding:15px;">
                    <label>Speciality</label>
                    <select name="Speciality" style="color: black; width: 200px;">
                        <option>--Select--</option>
                        <option value="skin">Skin</option>
                        <option value="heart">Heart</option>
                        <option value="eye">Eye</option>
                        <option value="nose">Nose</option>
                    </select>
                </div>

                <div style="padding:15px;">
                    <label>phone</label>
                    <input type="number" style="color:black" name="number" placeholder="write the number" required="">
                </div>

                <div style="padding:15px;">
                    <label>Room No</label>
                    <input type="text" style="color:black" name="room" placeholder="write the Room Number" required="">
                </div>

            
                <div style="padding:15px;">
                    <label>Doctor Image</label>
                    <input type="file" name="file" required="">
                </div>

                <div style="padding:15px;">                    
                    <input type="submit" class="btn btn-success">
                </div>



            </form>

         </div>
        



        </div>

    </div>

       @include('admin.script')
    <!-- End custom js for this page -->
   
  </body>
</html>