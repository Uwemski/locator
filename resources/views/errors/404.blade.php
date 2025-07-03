<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
    <title>Page not found</title>

    <style>

        body{
            text-align: center;
            font-family: "Arial", sans-serif;
        
            overflow-y: hidden;
        }

        img{
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container-fluid d-flex justify-content-center">
        <div class="row mx-auto mt-5">
            <div class="col-md-10 text-center">
                <h1>Error 404: Page not found</h1>
            </div>
            <div class="col-md-9">
                <a href="/home" class="btn btn-primary mb-5">Home</a>
            </div>
            

            {{-- <img src="{{asset('img/404(3).png')}}" alt="error-page" class="img-fluid">--}}
        </div>
    </div>
    
</body>
</html>