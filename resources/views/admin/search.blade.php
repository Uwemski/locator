<?php
    //use App\Models\Parish;
?>

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

    <div class="container mb-5">
        {{-- <pre>{{ print_r(session()->all(), true) }}</pre> command to check all in session--}}

        <div class="row mt-5">
            
            @if (session('error'))
                <div class="alert alert-danger">{{session('error')}}</div>
            @endif

            <table border="1" class="table table-hover"> 
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Email</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Date Registered</th>
                        <th>Status</th>
                        
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $serialNo = 1 ?>
                    @foreach ($parishes  as $p )
                        
                        <tr>
                            <td>{{ $serialNo }}</td>
                            <td>{{$p->name}}</td>
                            <td>{{$p->address}}</td>
                            <td>{{$p->email}}</td>
                            <td>{{$p->city}}</td>
                            <td>{{$p->state}}</td>
                            <td>{{$p->created_at->format('Y-m-d')}}</td>
                            <td>{{$p->status}}</td>
                            {{-- <td>
                                <form action="{{route('parish.update', $p->id)}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="form-select">
                                        <option value="pending" {{$p->status == 'pending'? 'selected': ''}}>Pending</option>
                                        <option value="verified" {{$p->status == 'verified'? 'selected': ''}}>Verify</option>
                                        <option value="suspended" {{$p->status == 'suspended'? 'selected': ''}}>Suspended</option>
                                    </select>
                                    <button type="submit" class="btn btn-warning mt-1">update</button>
                                </form>
                            </td> --}}
                            <td>
                                {{-- <form action="{{route('parish.destroy', $p->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Delete</button>
                                </form> --}}
                            </td>
                        </tr>

                        
                        <?php $serialNo++ ?>
                    @endforeach
                </tbody>



            </table>
        </div>
    </div>
</body>
</html>