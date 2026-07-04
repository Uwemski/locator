<x-client>
        <div class="d-flex">

            <!-- Main Content -->
            <div class="flex-grow-1">
                <nav class="navbar navbar-expand-lg header px-3">
                    <button class="btn btn-outline-dark d-md-none" onclick="toggleSidebar()">☰</button>
                    <span class="ms-3 fw-bold">Welcome, Parish Admin</span>
                </nav>

                @if(session('success'))
                        <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-warning">{{session('error')}}</div>
                    @endif                        
                    @if ($errors->any())
                        @foreach ($errors->all() as $err)
                            <div class="alert alert-warning">{{$err}}</div>
                        @endforeach
                    @endif
                <div class="container mt-4">
                    <!-- Mobile -->
                    <div class="space-y-4 md:hidden">
                        @foreach($services as $service)
                            <div class="rounded-lg border bg-white p-4 shadow">
                                <div class="flex justify-between">
                                    <span class="font-semibold">#{{ $loop->iteration }}</span>
                                </div>

                                <div class="mt-3 space-y-2">
                                    <p><span class="font-semibold">Service:</span> {{ $service->name }}</p>
                                    <p><span class="font-semibold">Day:</span> {{ $service->day }}</p>
                                    <p><span class="font-semibold">Time:</span> {{ $service->time }}</p>
                                </div>

                                <form action="{{ route('service.delete', $service->id) }}" method="POST" class="mt-4">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        onclick="return verifyDelete()"
                                        class="w-full rounded-md bg-red-600 py-2 text-white hover:bg-red-700"
                                    >
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>

                    <!-- Desktop -->
                    <div class="hidden md:block overflow-x-auto rounded-lg shadow-md">
                        <!-- Put the table here -->
                        <table border='1' class='table table-striped'>
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    {{--<th>Parish name</th>--}}
                                                    <th class="px-8 py-4"> Service Name</th>
                                                    <th class="px-8 py-4">Day</th>
                                                    <th class="px-8 py-4">Time</th>
                                                    <th class="px-8 py-4">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($services as $service)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td class="px-8 py-4">{{$service->name}}</td>
                                                        <td class="px-8 py-4">{{$service->day}}</td>
                                                        <td class="px-8 py-4">{{$service->time}}</td>
                                                        <td class="px-8 py-4">
                                                            <form action="{{route('service.delete', $service->id)}}" method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button  onclick="verifyDelete()" class="btn btn-danger">Delete</button>
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</x-client>