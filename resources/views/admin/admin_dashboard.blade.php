<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="dash.css">
    <title>Document</title>
    <style>
        .info {
            font-size: 1.5rem;
            text-align: left;
        }
    
    </style>
</head>
<body>
    <div class="container-fluid">

   
    <!-- <div class="container"> -->
        <!-- <div class="row">
            <div class="col-md-3 mt-4 mb-3"><a href="products.php" class=>View products</a></div>
        </div>
        <div class="row">
            <div class="col-md-3 mb-3"><a href="customers.php">View Customers</a></div>
        </div>
        <div class="row">
            <div class="col-md-3 mb-3"><a href="waste.php">View Wastes</a></div>
        </div> -->
        
        <div class="row">
            <div class="col-md-3">
                <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px;height: 100vh;">
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="{{route('admin.all_users')}}" class="nav-link active" aria-current="page">
                            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#users"></use></svg>
                            View Users
                            </a>
                        </li>
                        <li>
                            <a href="{{route('admin.all_parish')}}" class="nav-link text-white">
                            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#parishes"></use></svg>
                            View Parish
                            </a>
                        </li>
                        <li>
                            <a href="{{route('admin.active_parish')}}" class="nav-link text-white">
                            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#grid"></use></svg>
                            Verifed Parishes
                            </a>
                        </li>
                         <li>
                            <a href="{{route('admin.unverified')}}" class="nav-link text-white">
                            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#grid"></use></svg>
                            Un-verifed Parishes
                            </a>
                        </li>
                        <li>
                            <form action="/adminLogout" method="post">
                                <!--I keep forgetting to put csrf, nna ehn!-->
                                @csrf
                                <button class="btn btn-danger ml-3">Log Out</button>
                            </form>
                        </li>
                        
                    
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <h2 class="mt-4">Welcome to your dashboard <?php //it will be sexy if you can echo the customer's fullname on his dahsboard ?></h2>
                {{-- @foreach ($parishes as $parish)
                    
                @endforeach --}}

                <div class="d-flex d-flex-row justify-content-center">
                    <div class="card mt-5 bg-success mx-1" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Number Of Registerd Parishes</h5>
                            <p class="card-text text-center" style="font-size: 3rem">{{$parishes}}</p>
                            {{-- <a href="#" class="card-link">Card link</a>
                            <a href="#" class="card-link">Another link</a> --}}
                        </div>
                    </div>

                    <div class="card mt-5 bg-primary mx-1" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Number Of Registerd Users</h5>
                            <p class="card-text text-center" style="font-size: 3rem">{{$users}}</p>
                            {{-- <a href="#" class="card-link">Card link</a>
                            <a href="#" class="card-link">Another link</a> --}}
                        </div>
                    </div>

                    <div class="card mt-5 bg-warning mx-1" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Number Of Verified Parishes</h5>
                            <p class="card-text text-center" style="font-size: 3rem">{{$verifiedParish}}</p>
                            {{-- <a href="#" class="card-link">Card link</a>
                            <a href="#" class="card-link">Another link</a> --}}
                        </div>
                    </div>
                </div>
                


                @if(session('error'))
                    <div class="alert alert-danger">{{session('error')}}</div>
                @endif
                
                @if ($errors->any())
                    @foreach ($errors->all() as $err )
                        <div class="alert-warning">{{$err}}</div>
                    @endforeach
                @endif
                <div class="col-md-5 info pt-3">
                    <form action="/admin/search" method="GET">
                        @csrf
                        <label>Enter name of parish</label>
                        <input type='text' name='name' id='name' required placeholder='Enter name of parish here' class='form-control mt-2' value={{old('name')}}>
                        @error('name')
                            <small class="alert alert-warning">{{$message}}</small>
                        @enderror

                        <button class='btn btn-primary mt-2'>Search</button>
                    </form>
                </div>
   
                
            </div>
        </div>
    </div>
</body>
</html>