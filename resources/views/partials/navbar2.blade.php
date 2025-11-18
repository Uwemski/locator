  <nav class="navbar navbar-expand-lg bg-dark navbar-dark sticky-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="{{asset('img/logo_resized2.png')}}" alt="RCCG Logo" class="img-fluid" style="height: 50px;" />
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
        aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="mainNavbar">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
          <li class="nav-item">
            <a class=" nav-special nav-link {{ request()->is('home') ? 'bg-warning text-dark' : 'text-white' }}" href="{{ route('homepage') }}">
              Home
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-special nav-link {{ request()->routeIs('superPower') ? 'bg-warning text-dark' : 'text-white' }}" href="{{ route('superPower') }}">
              Find Parish
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-special nav-link" target="_blank" href="https://flatimes.com">
              Open Heaves
            </a>
          </li>
          <!-- Example of planned nav items -->
          <!-- 
          <li class="nav-item">
            <a class="nav-link" href="#">Events & Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->is('about') ? 'bg-warning text-dark' : 'text-white' }}" href="#">About Us</a>
          </li> 
          -->

          <li class="nav-item dropdown">
            <a class="nav-special nav-link dropdown-toggle text-white" href="#" id="registerDropdown" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              Register
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{ route('reg_test') }}">Register as Parish</a></li>
              <li><a class="dropdown-item" href="{{ route('userReg') }}">Register as User</a></li>
            </ul>
          </li>
        </ul>

      
       
      </div>
    </div>
  </nav>