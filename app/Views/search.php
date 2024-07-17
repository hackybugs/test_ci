<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
</head>
<body>
    <h2>Search</h2>
    <form action="/search" method="post">
        <label for="query">Search for:</label>
        <input type="text" name="query" required><br>
        
        <button type="submit">Search</button>
    </form>
    
    <?php if (isset($results)): ?>
        <h3>Results:</h3>
        <?php foreach ($results as $result): ?>
            <img src="<?= $result['previewURL'] ?>" alt="Image"><br>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
