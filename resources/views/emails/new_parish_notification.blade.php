<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>A new Parish registered</title>
</head>
<body>
    <h2>A new Parish registered</h2>
    <p>Hello Admin,</p>
    <p>Details of the new user:</p>
    <ul>
        <li><strong>Name:</strong> {{$parish->name}}</li>
        <li><strong>Email:</strong> {{$parish->email}}</li>
        <li><strong>created:</strong> {{$parish->created_at}}</li>
    </ul>

    <p>Please review their details if necessary</p>
</body>
</html>