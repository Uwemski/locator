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
                        <th>Action</th>
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
                    </tr>
                    <?php $serialNo++?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>

    //what is this doing here?

    // function toggleSidebar() {
    //     const sidebar = document.getElementById('sidebar');
    //     sidebar.classList.toggle('show');
    // }

    // let form = querySelector('form');
    
    // form.addEventListener('submit', function(e){
    //     e.preventDefault(e);

    //     alert("Are you sure you want to logout?");

    // })
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
