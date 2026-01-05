<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error <?= esc($code) ?></title>
</head>
<body>
    <h1> Error <?= esc($code) ?></h1>
    <p><?= esc($message) ?></p>
    <a href="/dashboard">kembali</a>
</body>
</html>