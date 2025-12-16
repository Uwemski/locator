
<x-admin-layout>


    <div class="row mt-4">
        <div class="">
            <form action="{{route('admin.search')}} " method="GET">
                @csrf
                <div class="mb-3">
                    <input type="hidden" name="status" value="verified" class="form-control">
                </div>
                <div class="mb-3">
                    <input type="text" name="search" class="form-control">
                </div>
                <button class="btn btn-primary">Search</button>
            </form>
        </div>

        <table border=1 class="table table-hover"> 
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Parish Name</th>
                    <th>Parish Location</th>
                    <th>Parish Email</th>
                    <th>Date Registered</th>
                    <th>Status</th>
                    <th>Action</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $serialNo = 1 ?>
                @foreach ($parishes  as $p)            
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
                                <option value="pending" {{$p->status == 'pending'? 'selected': ''}}>Pending</option>
                                <option value="verified" {{$p->status == 'verified'? 'selected': ''}}>Verify</option>
                                <option value="suspended" {{$p->status == 'suspended'? 'selected': ''}}>Suspended</option>
                            </select>
                            <button type="submit" class="btn btn-success mt-1">update</button>
                        </form>
                        </td>
                        <td>
                            <form action="{{route('parish.destroy', $p->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                </tr>
                <?php $serialNo++ ?>
                @endforeach
            </tbody>
        </table>
            {{$parishes->links()}}
    </div>
</x-admin-layout>