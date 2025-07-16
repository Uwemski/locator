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
            <p>Create Services for your Parish: This helps for users and visitors  to know when service will hold</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{session('success')}}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-warning">{{session('error')}}</div>
        @endif

       <div class="col-md-9">
        @if($errors->any())
            @foreach ($errors as $err)
                <div class="alert alert-warning">{{$err}}</div>
            @endforeach
        @endif
            <form action="{{route('services.create')}}" method="post" class="p-3">
                @csrf {{-- I forgot this again. 30pushups--}}
                <div class="mb-3">
                    <label for="name">Service Name</label>
                    <input type="text" name="name" id="name" class="form-control" required placeholder="Digging deep, faith clinic" value="{{old('name')}}">
                    @error('name')
                        <small style='color:red'>{{$message}}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="time">Time</label>
                    <input type="text" name="time" id="time" class="form-control" required placeholder="Time..." value="{{old('time')}}">
                    @error('time')
                        <small style="color:red">{{$message}}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="day">Day</label>
                    <input type="text" name="day" id="day" class="form-control" required placeholder="Day of the week" value="{{old('day')}}">
                    @error('day')
                        <small style="color:red">{{$message}}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">Create</button>
            </form>
       </div>
    </div>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('show');
    }

    let form = querySelector('form');
    
    form.addEventListener('submit', function(e){
        e.preventDefault(e);

        alert("Are you sure you want to logout?");

    })
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
