<x-client-layout>

    <div class="flex-grow-1">
        <div class="container mt-4">
            <!-- Dynamic content goes here -->
            <h2 class="mb-3">Dashboard</h2>
            <p>Create and manage your events for your parish</p>
        </div>


        @if(session('success'))
            <div class="alert alert-success">{{session('success')}}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{session('error')}}</div>
        @endif

        @if($errors->any())
            @foreach ($errors->all() as $err)
                <div class="alert alert-warning">{{$err}}</div>
            @endforeach

        @endif
        <div class="p-4 mb-4">
            <table border='1' class="table table-hover">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Event name</th>
                        <th>Description</th>
                        <th>Event date</th>
                        <th>Location</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $serialNo= 1;    
                    ?>
                    @foreach ($events as $e)
                    <tr>
                        <td>{{$serialNo}}</td>
                        <td>{{$e->title}}</td>
                        <td>{{$e->description}}</td>
                        <td>{{$e->event_date}}</td>
                        <td>{{$e->location ?? "Church premises"}}</td>
                        <td>
                            <a href="{{route('events.edit', $e->id)}}">Edit</a>
                        </td>
                        <td>
                            <form action="{{route('event.remove', $e->id)}}" method='post'>
                                @csrf
                                @method('delete')
                                <button style='background-color: red'>Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php $serialNo++?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-client-layout>
