<!-- resources/views/visitors-search.blade.php -->
<!DOCTYPE html>
<html>
<head>
  <title>Search Results</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon" />
</head>
<body class="bg-gray-50 min-h-screen">

  {{-- SOCIAL NAVBAR--}}
  @include('partials.navbar1')
  <!-- MAIN NAVBAR -->
  @include('partials.navbar2')

  <div class="max-w-5xl mx-auto px-4 sm:px-6 py-4 sm:py-6">

    @if(session('error'))
      <div class="mb-4 rounded-md bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 text-sm sm:text-base">
        {{ session('error') }}
      </div>
    @endif

    <h2 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4">
      Search Results ({{ $parishes->count() }})
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      @foreach ($parishes as $parish)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 flex flex-col justify-between">
          <div>
            <h3 class="font-semibold text-gray-900 text-lg">{{ $parish->name }}</h3>

            @if($parish->address)
              <p class="text-sm text-gray-600 mt-1">{{ $parish->address }}</p>
            @endif

            <p class="text-sm text-gray-500 mt-1">
              {{ $parish->city }}{{ $parish->city && $parish->state ? ',' : '' }} {{ $parish->state }}
            </p>
          </div>

          <a
            href="https://www.google.com/maps/dir/?api=1&destination={{ $parish->latitude }},{{ $parish->longitude }}"
            target="_blank"
            class="mt-4 w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 transition"
          >
            📍 Get Directions
          </a>
        </div>
      @endforeach
    </div>

  </div>

</body>
</html>