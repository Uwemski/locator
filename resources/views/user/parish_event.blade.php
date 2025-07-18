<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <title>Parish Event</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body{
            padding: 2rem;
            margin: 1rem;
        }
    </style>
</head>
<body>
    <table border='1' class="table table-hover">
        <thead>
            <tr>
                <th>S/N</th>
                <th>Event name</th>
                <th>Description</th>
                <th>Event date</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $serialNo= 1;    
            ?>
            @foreach ($event as $e)
            <tr>
                <td>{{$serialNo}}</td>
                <td>{{$e->title}}</td>
                <td>{{$e->description}}</td>
                <td>{{$e->event_date}}</td>
            </tr>
            <?php $serialNo++?>
            @endforeach
        </tbody>
    </table>
    <a href="/map/parish" class="btn btn-primary">Previous page</a>
</body>
</html>