<?php
   use App\Models\User;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="dash.css">
    <title>All Users</title>
    <style>
        .info {
            font-size: 1.5rem;
            text-align: left;
        }
    
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px;height: 100vh;">
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="" class="nav-link active" aria-current="page">
                            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#waste"></use></svg>
                            View Users
                            </a>
                        </li>
                        <li>
                            <a href="/admin/viewParishes" class="nav-link text-white">
                            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#grid"></use></svg>
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
                                <button class="btn btn-danger">Log Out</button>
                            </form>
                        </li>
                        
                    
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <h2>Welcome to your dashboard <?php //it will be sexy if you can echo the customer's fullname on his dahsboard ?></h2>
                
                <table class="table table-hover" border="1">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Date Joined</th>
                            <th>
                                <form action="">
                                    <button class="btn btn-warning">Action</button>
                                </form>
                                
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $serialNo = 1    
                        ?>

        
                        @foreach (User::all() as $user)
                            <tr>
                                <td><?php echo $serialNo++?></td>
                                <td><?php echo $user->name?></td>
                                <td><?php echo $user->email?></td>
                                <td><?php echo $user->phone?></td>
                                <td><?php echo $user->created_at?></td>
                                <td>
                                    <form action="{{route('users.destroy', $user->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
   

    </div>

</body>
</html>