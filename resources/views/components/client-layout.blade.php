<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parish Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        body {
            background-color: #f4faf2;
            overflow-x: hidden;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #61bb43;
            color: white;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #4fa234;
        }
        .header {
            background-color: #a5d894;
            color: #2e5337;
        }
        @media (max-width: 768px) {
            .sidebar {
                position: absolute;
                z-index: 1000;
                width: 70%;
                display: none;
            }
            .sidebar.show {
                display: block;
            }
        }

        .bg-green-custom {
            background-color: #61bb43;
            color: #fff;
        }

        #map { height: 400px; }
        input { width: 100%; padding: 8px; margin-top: 10px; }

    </style>
</head>
<body>
    <div id="sidebar" class="sidebar p-3">
        <h4 class="mb-4">RCCG Parish</h4>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link {{request()->routeIs('update_profile') ? 'bg-warning text-dark' : '.bg-green-custom'}}" href="{{route('update_profile')}}">Edit Profile</a></li>
            <li class="nav-item {{request()->routeIs('manage_location') ? 'bg-warning text-dark': '.bg-green-custom'}}"><a class="nav-link" href="{{route('manage_location')}}">Manage Location</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('service.create.index')}}">Service Schedule</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('service.show')}}">Manage services</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('events')}}">Events</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('event.show')}}">Manage events</a></li>
            <li class="nav-item">
                <form action="/parish/logout" method="post">
                    @csrf
                    <button class="bg bg-danger">Logout</button>
                </form>
            </li>
                <!--<a class="nav-link" href="#">Logout</a></li>-->
        </ul>
    </div>

    <div class="d-flex">

        <!-- Main Content -->
        <div class="flex-grow-1">
            <nav class="navbar navbar-expand-lg header px-3">
                <button class="btn btn-outline-dark d-md-none" onclick="toggleSidebar()">☰</button>
                <span class="ms-3 fw-bold">Welcome, Parish Admin</span>
            </nav>
            
            <div class="mt-4">
                {{ $slot }}
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