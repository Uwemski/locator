<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <title>Document</title>
  <style>
    span{
      color: red
    }
    </style>
</head>
<body>
  <div class="container-fluid d-flex justify-content-center min-vh-80 align-items-center">
    <div class="col-md-6 col-lg-4  p-4 rounded shadow mt-5" >
     <div class="row text-center">
        <h2>User Registration</h2>
        <p>Fill out the form carefully for registration</p>
      </div>
      <div class="">
        <form action="/userRegProcess" method="post" class="p-2">
          @csrf
          <div class=" mb-3">
            <label for="fullName">Name<span>*</span></label>
            <input type="text" name="name" id="fullName" required placeholder="Enter your Full Name" class="form-control">
          </div>
          <div class="mb-3">
            <label for="">Email Address<span>*</span></label>
            <input type="email" name="email" id="email" required placeholder="Enter your Email" class="form-control">
          </div>
          <div class="mb-3">
            <label for="phone">Phone Number<span>*</span></label>
            <input type="text" name="phone" id="phone" required placeholder="Enter your Phone Number" class="form-control">
          </div>
          <div class="mb-3">
            <label for="password">Password<span>*</span></label>
            <input type="password" name="password" id="password" placeholder="Password must not be less than 8 characters" class="form-control">
          </div>
          <div class="mb-3">
            <label for="cpassword">Confirm Password<span>*</span></label>
            <input type="password" name="confirmPassword" id="cpwd" placeholder="Confirm password" class="form-control">
          </div>
          
          <p class="text-center"> <button class="btn btn-primary">Register</button></p>
        </form>
      </div>
      
    </div>
  </div>


  <script>
    //inasmuch as laravel performs validation, don't neglect the frontend
    //frontend form validation goes here 

  </script>
</body>
</html>