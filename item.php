<?php

require __DIR__ . "/./autoloader/load.php";

// Account Auth

if(!checkAuth())
{
    header('Location: login.php');
    return;
}

// Admin Auth

if($_SESSION['user']->getAdmin() == 0)
{
    header('Location: index.php');
    return;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item</title>
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
            <?php 
            
            if(isset($_SESSION['user']))
            {
                if($_SESSION['user']->getAdmin() == 1)
                {
                    echo '<li><a href="transaction.php">Transaksi</a></li>';
                    echo '<li><a href="item.php">Barang</a></li>';
                    echo '<li><a href="account.php">Akun</a></li>';
                }
            }
            else
            {
                header('Location : login.php');
            }
            ?>
            <li><a class="logout" href="logout.php">Logout</a></li>
        </ul>
    </nav>
</body>
</html>