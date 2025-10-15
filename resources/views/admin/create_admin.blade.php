<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Create New Admin</title>
</head>
<body>
    
    <div class="container-fluid d-flex justtify-content-center align-items-center">
        <div class="row rounded mt-5 mx-auto w-90 shadow">
            <form action="/admin/create_admin" method="POST">
                @if($errors->any())
                    @foreach ($errors->all() as $err)
                        <p class="alert alert-danger">{{$err}}</p>
                    @endforeach
                @endif
                <!--CSRF is very important, try not to forget it-->
                @csrf
                <div class="mb-3">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name" required value="{{old('name')}}">
                    @error('name')
                        <small style="color:red">{{$message}}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placehoder="Kindly enter your email" required value="{{old('email')}}">
                    @error('email')
                        <small style="color: red">{{$message}}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="pass">Password</label>
                    <input type="password" name="password" id="pass" class="form-control" placeholder="Choose a strong password" required>
                    @error('password')
                        <small style="color: red">{{$message}}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="">Confirm Password</label>
                    <input type="password" name="confirmPassword" id="cpassword" placeholder="Re-enter your password">
                </div>
                <div class="mb-3">
                    <label for="role">Select Role</label>
                    <select name="role" id="role" class="form-select">
                        <option value="">Select Role</option>
                        <option value="superadmin">SUPERADMIN</option>
                        <option value="moderator">MODERATOR</option>
                    </select>
                </div>
                
                <p class="text-center"><button type="submit" class="btn btn-primary">Register</button></p>
            </form>
        </div>
    </div>


    <script>
        let x = document.querySelector('form')

        x.addEventListener('submit', function(e){
            e.preventDefault();
        
            let name = document.getElementById('name').value.trim();
            let email = document.getElementById('email').value.trim();
            let pass = document.getElementById('pass').value.trim();
            let cpass = document.getElementById('cpassword').value.trim();
            let role = document.getElementById('role').value;
        
            if(role === "" || !name || !email || !pass || !cpass){
                alert("All fields are required");
                if(pass !== cpass){
                    alert("Passwords do not match");
                }
            }else{
                // alert("Submission was completed successfully!");
                x.submit();
            }
        });

    </script>
</body>
</html>