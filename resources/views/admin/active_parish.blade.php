<x-admin-layout>

    <div class="row">
        <div class="col-md-9">
            <h2>Welcome to your dashboard <?php //it will be sexy if you can echo the customer's fullname on his dahsboard ?></h2>
                
            <div class="col-md-5 info pt-3">
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
                            <td><a href="{{route('service.find', $p->id)}}">View service</a></td>
                        </tr>
                                
                        <?php $serialNo++ ?>
                        @endforeach
                    </tbody>

                </table>
            </div>
            <!--error: it seems paginate does not work with search or I'm doing something -->
            {{$parishes->links()}}
        </div>
    </div>

</x-admin-layout>