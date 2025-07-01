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
                            <a href="{{route('admin.suspended')}}" class="nav-link text-white">
                            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#grid"></use></svg>
                            Suspended Parishes
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
                <h2 class="mt-4">All Suspended Parishes</h2>
                
                <table border='1' class='table table-hover'>
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Parish name</th>
                            <th>Parish email</th>
                            <th>Parish status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suspended as $sus)
                            <?php $serialNo = 1 ?>
                            <tr>
                                <td>{{$serialNo++}}</td>
                                <td>{{$sus->name}}</td>
                                <td>{{$sus->email}}</td>
                                <td>{{$sus->status}}</td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>