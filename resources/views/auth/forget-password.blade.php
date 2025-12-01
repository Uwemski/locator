<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
</head>
<body>
    <div class="row">
        <div class="col-md-5">
            <div class="col-md-3">
                <form action="{{route('auth.forget-password')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email">Enter your email</label>
                        <input type="email" name="email" id="email">
                    </div>
                    <button>Reset</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
    