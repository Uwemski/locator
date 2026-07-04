<x-admin-layout>

    <div class="row">
        <div class="col-md-9">
                <h2>Welcome to your dashboard <?php //it will be sexy if you can echo the customer's fullname on his dahsboard ?></h2>
                
                <div class="col-md-5 info pt-3">
                    <div class="">
                        <form action="{{route('admin.search')}} " method="GET">
                            @csrf
                            <div class="mb-3">
                                <input type="hidden" name="status" value="pending" class="form-control">
                            </div>
                            <div class="mb-3">
                                <input type="text" name="search" class="form-control" placeholder="search by name, city or state">
                            </div>
                            <button class="btn btn-primary">Search</button>
                        </form>
                    </div>


                    <table border="1" class="table table-hover"> 
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Parish Name</th>
                                <th>Parish Location</th>
                                <th>Parish Email</th>
                                <th>State</th>
                                <th>Date Registered</th>
                                <th>Status</th>
                                {{-- <th>Action</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($parishes  as $parish)
                                <tr data-id="{{ $parish->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{$parish->name}}</td>
                                    <td>{{$parish->address}}</td>
                                    <td>{{$parish->email}}</td>
                                    <td>{{$parish->state}}</td>
                                    <td>{{$parish->created_at->format('Y-m-d')}}</td>
                                    <td>{{$parish->status}}</td>
                                    <td>
                                        <form action="{{route('parish.update', $parish->id)}}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="form-select status-select" data-id="{{ $parish->id }}">
                                                <option value="pending" {{$parish->status == 'pending' ? 'selected': ''}}>Pending</option>
                                                <option value="verified" {{$parish->status == 'verify' ? 'selected': '' }}>Verify</option>
                                                <option value="suspended" {{$parish->status == 'suspended' ? 'selected': ''}}>Suspend</option>
                                            </select>
                                            <button 
                                                type="button"
                                                onclick="updateStatus({{$parish->id}})"
                                                class="btn btn-success">
                                                Update
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
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
</x-admin-layout>

