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
