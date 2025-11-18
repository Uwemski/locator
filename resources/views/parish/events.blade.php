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
            <form action="{{route('event.create')}}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="title">Event Title</label>
                    <input type="text" name="title" class="form-control" id="title" value="{{old('name')}}">
                    @error('title')
                        <small style="color:red">{{$message}}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="desc">Description</label>
                    <textarea name="description" id="desc" cols="20" rows="5" class="form-control">{{old('description')}}</textarea>
                    @error('description')
                        <small style="color:red">{{$message}}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="time">Event date</label>
                    <input type="text" name="event_date" class="form-control" value="{{old('event_date')}}" placeholder="Format: Y-m-d">
                    @error('event_date')
                        <small style="color:red">{{$message}}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="">Location (optional)</label>
                    <input type="text" name="location" id="location" class="form-control" value="{{old('location')}}">
                    @error('location')
                        <small style="color:red">{{$message}}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="">Picture</label>
                </div>
                <p class="text-center">
                    <button class="btn btn-primary">Create</button>
                </p>

            </form>
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
