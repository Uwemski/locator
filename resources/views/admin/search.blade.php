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
                <div class="alert alert-danger mt-2">{{session('error')}}</div>
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
                    @foreach ($parishes  as $parish )                        
                        <tr>
                            <td>{{ $loop->iteration  }}</td>
                            <td>{{$parish->name}}</td>
                            <td>{{$parish->address}}</td>
                            <td>{{$parish->email}}</td>
                            <td>{{$parish->city}}</td>
                            <td>{{$parish->state}}</td>
                            <td>{{$parish->created_at->format('Y-m-d')}}</td>
                            <td>{{$parish->status}}</td>
                            {{-- <td>
                                <form 
                                    action="{{route('parish.update', $parish->id)}}" 
                                    class=""
                                    method="POST" >
                                    @csrf
                                    @method('PUT')
                                    <select 
                                        name="status" 
                                        class="form-select status-select" 
                                        data-id="{{ $parish->id }}"
                                        >
                                            <option value="pending" {{$parish->status == 'pending'? 'selected': ''}}>Pending</option>
                                            <option value="verified" {{$parish->status == 'verified'? 'selected': ''}}>Verify</option>
                                            <option value="suspended" {{$parish->status == 'suspended'? 'selected': ''}}>Suspended</option>
                                    </select>
                                    <button type="submit" class="btn btn-warning mt-1">update</button>
                                </form>
                            </td> --}}
                            <td>
                                {{-- <form action="{{route('parish.destroy', $parish->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Delete</button>
                                </form> --}}
                            </td>
                        </tr>                        
                    @endforeach
                </tbody>



            </table>
        </div>
    </div>
    <script>
        async function updateStatus(parishId) {
            try{
                const select = document.querySelector(`.status-select[data-id="${parishId}"]`);
                const status = select.value;
                const row = select.closest('tr'); // Get the parent row

                const response= await fetch(`/admin/${parishId}`, {
                    method: 'PUT',
                    headers: {
                        'content-type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({status})
                })

                const data = await response.json();
                if(data.success){
                    console.log(data);
                    if(data.status == 'verified'){
                        row.remove()
                    }else{}
                    Toastify({
                        text: "Status updated successfully",
                        duration: 3000,
                        gravity:"top",
                        position:"right",
                        backgroundColor: "green",

                    }).showToast();
                }else{
                    console.error(error)
                    alert('Error encountered, try again later');
                    Toastify({
                        text: "Error encountered,try again",
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "red"
                    }).showToast();
                }
            }catch(error){
                console.log('Error:', error);

                Toastify({
                    text: "Network error",
                    duration: 3000,
                    backgroundColor: "red",
                }).showToast();
            }
        }
    </script>
</body>
</html>