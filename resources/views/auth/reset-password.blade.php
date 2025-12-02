<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
</head>
<body>
    <div class="row">
        @if($errors->any())
            <ul>
            @foreach($errors->all() as $err)    
                <li>{{$err}}</li>
            @endforeach
            </ul>
        @endif
        <div class="col-md-5">
            <div class="col-md-3">
                <form action="{{route('auth.reset-password')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email">Enter your email</label>
                        <input type="email" name="email" id="email">
                    </div>
                    <div class="mb-3">
                        <label for="">Otp code</label>
                        <input type="text" name="otp">
                    </div>
                    <div class="mb-3">
                        <label>Enter your Password</label>
                        <input type="password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="email">Confirm Password</label>
                        <input type="password" name="password_confirmation">
                    </div>
                    
                    <button>Reset</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
    