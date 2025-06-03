<nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
    <div class="container-fluid bg-primary">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <a class="navbar-brand" href="#"><img src="img/logo_resized2.png" alt="" class="img-fluid rccgImageLogo mt-2"></a>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link {{request()->is('home') ? 'bg-warning text-dark' : 'bg-danger text-dark'}}" aria-current="page" href="{{route('homepage')}}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Find a Parish</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Events & Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link{{ request()->is('about') ? 'bg-warning text-dark' : 'bg-primary text-white'}}" href="#">About us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('userReg')}}">Register</a>
          </li>
        </ul>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>