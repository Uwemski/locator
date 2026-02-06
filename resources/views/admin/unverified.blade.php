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
                            <?php $serialNo = 1 ?>
                            @foreach ($parishes  as $p )
                                <tr>
                                    <td>{{ $serialNo }}</td>
                                    <td>{{$p->name}}</td>
                                    <td>{{$p->address}}</td>
                                    <td>{{$p->email}}</td>
                                    <td>{{$p->state}}</td>
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
    
    </div>
</x-admin-layout>

