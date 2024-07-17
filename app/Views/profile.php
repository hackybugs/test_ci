<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <h2>Update Profile</h2>
    <form action="/profile" method="post" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?= $user['name'] ?>" required><br>
        
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= $user['email'] ?>" required><br>
        
        <label for="password">New Password:</label>
        <input type="password" name="password"><br>
        
        <label for="profile_picture">Profile Picture:</label>
        <input type="file" name="profile_picture"><br>
        
        <button type="submit">Update</button>
    </form>
</body>
</html>
