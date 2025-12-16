<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fa;
        }

        /* SIDEBAR */
        .sidebar {
            height: 100vh;
            background: #212529;
            color: #fff;
            position: fixed;
            width: 250px;
            transition: all 0.3s ease;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #adb5bd;
            text-decoration: none;
            font-size: 15px;
        }

        .sidebar a:hover {
            background: #343a40;
            color: #fff;
        }

        .sidebar .active {
            background: #0d6efd;
            color: #fff;
        }

        /* PAGE CONTENT */
        .content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        /* MOBILE SIDEBAR */
        @media (max-width: 768px) {
            .sidebar {
                left: -250px;
            }
            .sidebar.active {
                left: 0;
            }
            .content {
                margin-left: 0;
            }
        }

        /* NAVBAR */
        .top-nav {
            background: #fff;
            padding: 12px 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.08);
        }

        .menu-btn {
            font-size: 22px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <h4 class="text-center py-3">ADMIN PANEL</h4>

        <a href="{{route('adminDashboard')}}">
            Dashboard
        </a>

        <a href="{{route('admin.all_users')}}">
            View Users
        </a>
        <a href="{{route('admin.all_parish')}}">
            View Parish
        </a>
        <a href="{{route('admin.active_parish')}}">
            Verified Parish
        </a>

        <a href="{{route('admin.unverified')}}">
            Un-verified Parish
        </a>

        <a href="{{route('admin.suspended')}}">
            Suspended
        </a>

        <form id="logout-form" action="{{route('admin.logout')}}" method="POST">
            @csrf
            <button>Log-out</button>
        </form>
    </div>

    <!-- CONTENT AREA -->
    <div class="content">
        <div class="top-nav d-flex align-items-center justify-content-between">
            <span class="menu-btn" onclick="toggleSidebar()">&#9776;</span>
            <h5 class="m-0">{{ $pageTitle ?? 'Dashboard' }}</h5>
        </div>

        <div class="mt-4">
            {{ $slot }}
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("active");
        }
    </script>

</body>
</html>
