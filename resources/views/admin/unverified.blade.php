
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>All Parish</title>
</head>
<body>
    <!--Upon parish registration, admin should be able to view it from here-->

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
                <h2>Welcome to your dashboard <?php //it will be sexy if you can echo the customer's fullname on his dahsboard ?></h2>
                
                <div class="col-md-5 info pt-3">
                    <table border="1" class="table table-hover"> 
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Parish Name</th>
                        <th>Parish Location</th>
                        <th>Parish Email</th>
                        <th>Date Registered</th>
                        <th>Status</th>
                        {{-- <th>Action</th> --}}
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $serialNo = 1 ?>
                    @foreach ($unverified  as $p )
                        <tr>
                            <td>{{ $serialNo }}</td>
                            <td>{{$p->name}}</td>
                            <td>{{$p->address}}</td>
                            <td>{{$p->email}}</td>
                            <td>{{$p->created_at->format('Y-m-d')}}</td>
                            <td>{{$p->status}}</td>
                            <td>
                                <form action="{{route('parish.update', $p->id)}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="form-select">
                                        <option value="pending" {{$p->status == 'pending' ? 'selected': ''}}>Pending</option>
                                        <option value="verified" {{$p->status == 'verify' ? 'selected': '' }}>Verify</option>
                                        <option value="suspended" {{$p->status == 'suspended' ? 'selected': ''}}>Suspend</option>
                                    </select>
                                    <button class="btn btn-success">Verify</button>
                                </form>
                            </td>
                        </tr>

                        
                        <?php $serialNo++ ?>
                    @endforeach
                </tbody>



            </table>
                </div>
                
            </div>
        </div>
    {{-- <div class="container">
        <div class="row mt-4">
            
        </div>
    </div> --}}
    
</body>
</html>