<div id="sidebar" class="sidebar p-3">
        <h4 class="mb-4">RCCG Parish</h4>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link {{request()->routeIs('update_profile') ? 'bg-warning text-dark' : '.bg-green-custom'}}" href="{{route('update_profile')}}">Edit Profile</a></li>
            <li class="nav-item {{request()->routeIs('manage_location') ? 'bg-warning text-dark': '.bg-green-custom'}}"><a class="nav-link" href="{{route('manage_location')}}">Manage Location</a></li>
            <li class="nav-item"><a class="nav-link" href="/parish/service">Service Schedule</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('service.show')}}">Manage services</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('events')}}">Events</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('event.show')}}">Manage events</a></li>
            <li class="nav-item">
                <form action="/parish/logout" method="post">
                    @csrf
                    <button class="bg bg-danger">Logout</button>
                </form>
                <!--<a class="nav-link" href="#">Logout</a></li>-->
        </ul>
    </div>