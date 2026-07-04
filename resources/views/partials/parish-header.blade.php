<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parish Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        body {
            background-color: #f4faf2;
            overflow-x: hidden;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #61bb43;
            color: white;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #4fa234;
        }
        .header {
            background-color: #a5d894;
            color: #2e5337;
        }
        @media (max-width: 768px) {
            .sidebar {
                position: absolute;
                z-index: 1000;
                width: 70%;
                display: none;
            }
            .sidebar.show {
                display: block;
            }
        }

        .bg-green-custom {
            background-color: #61bb43;
            color: #fff;
        }

        #map { height: 400px; }
        input { width: 100%; padding: 8px; margin-top: 10px; }

    </style>
</head>