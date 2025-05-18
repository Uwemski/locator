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
                            <a href="{{route('allUsers')}}" class="nav-link active" aria-current="page">
                            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#users"></use></svg>
                            View Users
                            </a>
                        </li>
                        <li>
                            <a href="{{route('allParishes')}}" class="nav-link text-white">
                            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#parishes"></use></svg>
                            View Parish
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link text-white">
                            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#grid"></use></svg>
                            View Feedbacks
                            </a>
                        </li>
                        <li>
                            <form action="/adminLogout" method="post">
                                <!--I keep forgetting to put csrf, nna ehn!-->
                                @csrf
                                <button class="btn btn-danger">Log Out</button>
                            </form>
                        </li>
                        
                    
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <h2>Welcome to your dashboard <?php //it will be sexy if you can echo the customer's fullname on his dahsboard ?></h2>
                
                <div class="col-md-5 info pt-3">
                    <h4 >Name: Sule </h4>
                    <h4>Telephone: </h4>
                    <h4>Account:</h4>
                </div>
   

    </div>

</body>
</html>