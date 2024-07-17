<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form action="/register" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?= old('name') ?>" required>
        <?php if(isset($validation) && $validation->hasError('name')): ?>
            <div class="error"><?= $validation->getError('name') ?></div>
        <?php endif; ?><br>
        
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= old('email') ?>" required>
        <?php if(isset($validation) && $validation->hasError('email')): ?>
            <div class="error"><?= $validation->getError('email') ?></div>
        <?php endif; ?><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <?php if(isset($validation) && $validation->hasError('password')): ?>
            <div class="error"><?= $validation->getError('password') ?></div>
        <?php endif; ?><br>
        
        <label for="profile_picture">Profile Picture:</label>
        <input type="file" name="profile_picture">
        <?php if(isset($validation) && $validation->hasError('profile_picture')): ?>
            <div class="error"><?= $validation->getError('profile_picture') ?></div>
        <?php endif; ?><br>
        
        <button type="submit">Register</button>
    </form>
</body>
</html>
