<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Admin Login</title>
</head>
<body>
    
    <div class="container-fluid">
        <div class="row mt-5">
            
            @if ($errors->any())
                {{-- //loop over the error --}}
                @foreach ($errors->all() as $err)
                    <small style="color: red">{{$err}}</small>
                @endforeach
            @endif
            <form action="/admin/login" method="post">
                @csrf
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email here" class="form-control" required value="{{old('email')}}">
                    @error('email')
                        <small style="color:red">{{$message}}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="pass">Password</label>
                    <input type="password" name="password" id="pass" class="form-control" placeholder="Enter your password" required>
                    @error('password')
                        <small style='color: red'>{{$message}}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Log In</button>
            </form>
        </div>
    </div>
    <script>
        let x = document.querySelector('form')

        //instead of repeating this for the 3 login pages I have. There should be a way to use one for all three
        x.addEventListener('submit', function(e){
            e.preventDefault();

            let em = document.getElementById('email').value.trim();
            let pwd = document.getElementById('password').value.trim();

            if (!em || !pwd) ? alert("Error, All fields are required") : alert("Logging in..."), x.submit();
        })
    </script>
</body>
</html>