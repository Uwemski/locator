<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Parish Events</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Custom CSS -->
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      background-color: #f5f5f5;
      padding: 2rem 1rem;
    }

    .events-container {
      max-width: 900px;
      margin: auto;
    }

    .event-card {
      background-color: #fff;
      border-radius: 10px;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .event-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }

    .event-title {
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
      color: #003399; /* RCCG blue accent */
    }

    .event-date {
      font-size: 0.95rem;
      font-weight: 600;
      color: #61bb43; /* RCCG green accent */
      margin-bottom: 0.75rem;
    }

    .event-description {
      font-size: 1rem;
      color: #555;
    }

    .btn-back {
      display: block;
      width: max-content;
      margin: 2rem auto 0;
    }
  </style>
</head>
<body>

  <div class="events-container">
    <h2 class="text-center mb-4">Upcoming Events for {{ $parishName ?? 'This Parish' }}</h2>

    @forelse($event as $e)
      <div class="event-card">
        <div class="event-title">Theme: {{ $e->title }}</div>
        <div class="event-date">📅 {{ \Carbon\Carbon::parse($e->event_date)->format('D, M j, Y') }}</div>
        <div class="event-description">{{ $e->description }}</div>
      </div>
    @empty
      <p class="text-center text-muted">No upcoming events for this parish.</p>
    @endforelse

    <a href="{{ url('/map/parish') }}" class="btn btn-primary btn-back">← Back to Map</a>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
