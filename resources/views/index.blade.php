<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Parish Locator | Home Page</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="{{asset('style.css')}}" />
  <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}" type="image/x-icon"/>

  <style>
    nav {
      font-family: Montserrat, sans-serif;
      
      font-size: 16px;
      font-weight: 700;
      text-transform: uppercase;
      /* #fad03b */
    }
    
    a:hover {
      color: #fcb900;
    }
  </style>
</head>
<body>

  <!-- SOCIAL NAVBAR -->
  @include('partials.navbar1')
  <!-- MAIN NAVBAR -->
  @include('partials.navbar2') 

  <!-- HEADER SECTION -->
  <header id="mainHeader" class="p-5 text-center text-light bg-secondary text-dark mb-5">
    <h1 class="mt-5">Welcome to RCCG Parish Locator</h1>
    <p class="lead text-dark">Find a parish near you with ease and convenience.</p>
    <a href="{{route('superPower')}}" class="btn btn-primary">Find a Parish</a>
  </header>

  <!-- BOOTSTRAP JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
