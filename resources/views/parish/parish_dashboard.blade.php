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

        <div class="card p-4 mb-4">
            <h4>Parish Details</h4>
            <p><strong>Pastor:</strong> {{ $parish->pastor_name ?? 'Not Provided' }}</p>
            <p><strong>Address:</strong> {{ $parish->address }}</p>
            <p><strong>City:</strong> {{ $parish->city }}</p>
            <p><strong>State:</strong> {{ $parish->state }}</p>
            <p><strong>Contact No:</strong> {{ $parish->contact_no ?? 'N/A' }}</p>
            <p><strong>Website:</strong> {{ $parish->website ?? 'N/A' }}</p>
            <p><strong>Status:</strong> 
                <span class="badge bg-{{ $parish->status === 'verified' ? 'success' : ($parish->status === 'pending' ? 'warning' : 'danger') }}">
                    {{ ucfirst($parish->status) }}
                </span>
            </p>
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
