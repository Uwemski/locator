<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Parish Locator | Home Page</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="{{asset('style.css')}}" />
  <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}" type="image/x-icon"/>
</head>
<body>

  <!-- SOCIAL NAVBAR -->
  @include('partials.navbar1')
  <!-- MAIN NAVBAR -->
  @include('partials.navbar2') 

  <!-- HEADER SECTION -->
  <header id="mainHeader" class="p-5 text-center text-light bg-secondary text-dark">
    <h1 class="mt-5">Welcome to RCCG Parish Locator</h1>
    <p class="lead text-dark">Find a parish near you with ease and convenience.</p>
    <a href="{{route('superPower')}}" class="btn btn-primary">Find a Parish</a>
  </header>

  <!-- BOOTSTRAP JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
