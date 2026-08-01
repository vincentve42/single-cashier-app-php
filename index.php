<?php

require __DIR__ . "/./autoloader/load.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>
</head>
<body>
    <nav>
        <header>
            Cashier
        </header>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="transaction.php">Transaksi</a></li>
            <li><a href="item.php">Barang</a></li>
            <li><a href="account.php">Akun</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</body>
</html>
<?php 

if(!checkAuth())
{
    header('Location: login.php');
}


?>