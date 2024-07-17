<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?= $user['name'] ?></h2>
    <img src="/uploads/<?= $user['profile_picture'] ?>" alt="Profile Picture" width="100"><br>
    <nav>
        <ul>
            <li><a href="/dashboard">Dashboard</a></li>
            <li><a href="/profile">Profile</a></li>
            <li><a href="/search">Search</a></li>
        </ul>
    </nav>
</body>
</html>
