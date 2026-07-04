<x-client>

    <div class="container mt-4">
            <!-- Dynamic content goes here -->
            <h2 class="mb-3">Dashboard</h2>
            <p>This is your parish dashboard. You can manage your profile, services, location and more.</p>
        </div>

        <!-- removed the image tag here. connect and use cloudinary -->

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
</x-client>

