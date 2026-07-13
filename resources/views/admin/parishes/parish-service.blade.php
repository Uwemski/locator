<x-admin-layout>

    <div class="row">
        <div class="col-md-9">
            @if(session('error'))
                <p>{{session('error')}}</p>
            @endif
            <div class="mt-4">
                <table border=1 class="table table-hover"> 
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Parish Name</th>
                            <th>Service name</th>
                            <th>Service Day</th>
                            <th>Service Time</th>
                            <th>Date Registered</th>    
                            <th>Action</th>        
                        </tr>
                    </thead>
                    <tbody>
                        <?php $serialNo = 1 ?>
                        
                        @foreach ($service  as $s)                            
                        <tr>
                            <td>{{ $serialNo }}</td>
                            <td>{{$parish->name}}</td>
                            <td>{{$s->name}}</td>
                            <td>{{$s->day}}</td>
                            <td>{{$s->time}}</td>
                            <td>{{$s->created_at->format('Y-m-d')}}</td>
                            <td>
                                <form action="" method="POST">
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
            </div>
        </div>
    </div>
</x-admin-layout>