<?php
$token = bin2hex(random_bytes(24));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Token Test</title>
</head>
<body>
    <h1>
        <?php
        echo $token
        ?>
    </h1>
</body>
</html>