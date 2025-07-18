<!--Header starts here-->

@include('partials.parish_header')
<!--Header ends here-->
    <body>
        <div class="d-flex">
            <!-- Sidebar -->
            @include('partials.parish_sidebar')
            <!--SIDEBAR ENDS HERE-->

            <!-- Main Content -->
            <div class="flex-grow-1">
                <nav class="navbar navbar-expand-lg header px-3">
                    <button class="btn btn-outline-dark d-md-none" onclick="toggleSidebar()">☰</button>
                    <span class="ms-3 fw-bold">Welcome, Parish Admin</span>
                </nav>

                <div class="container mt-4">
                    <!-- Dynamic content goes here -->
                    <h2 class="mb-3">Dashboard</h2>
                    <p>This is your parish dashboard. You can manage your profile, services, location and more.</p>

                    {{-- <h2>Select a location on the map</h2>
                    <div id="map"></div> --}}

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

                    <table border='1' class='table table-striped'>
                        <thead>
                            <tr>
                                <th>S/N</th>
                                {{--<th>Parish name</th>--}}
                                <th>Service Name</th>
                                <th>Service Day</th>
                                <th>Service Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $serialNo=1?>
                            @foreach ($services as $service)
                                <tr>
                                    <td>{{$serialNo}}</td>
                                    <td>{{$service->name}}</td>
                                    <td>{{$service->time}}</td>
                                    <td>{{$service->day}}</td>
                                    <td>
                                        <form action="{{route('service.delete', $service->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button  onclick="verifyDelete()" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php $serialNo++?>
                                {{--$serialNo++--}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>