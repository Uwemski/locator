<x-admin-layout>

    <div class="row">
        <div class="col-md-9">
                <h2 class="mt-4">All Suspended Parishes</h2>
                
                <div class="">
                        <form action="{{route('admin.search')}} " method="GET">
                            @csrf
                            <div class="mb-3">
                                <input type="hidden" name="status" value="suspended" class="form-control">
                            </div>
                            <div class="mb-3">
                                <input type="text" name="search" class="form-control">
                            </div>
                            <button class="btn btn-primary">Search</button>
                        </form>
                    </div>




                <table border='1' class='table table-hover'>
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Parish name</th>
                            <th>Parish email</th>
                            <th>State</th>
                            <th>Parish status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $serialNo = 1 ?>
                        @foreach ($parishes as $parish)
                            <tr>
                                <td>{{$serialNo++}}</td>
                                <td>{{$parish->name}}</td>
                                <td>{{$parish->email}}</td>
                                <td>{{$parish->state}}</td>
                                <td>{{$parish->status}}</td>
                            </tr>
                            <?php $serialNo ++ ?>
                        @endforeach    
                    </tbody>
                </table>
            </div>
    </div>

</x-admin-layout>