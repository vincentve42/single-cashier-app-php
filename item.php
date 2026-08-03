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
    <content>
        <div class="item-content">
            <div class="left-side">
                <h2>Barang</h2>
                <div class="table-wrap">
                <table>
                    
                    <tr>
                        <th class="id">ID</th><th class="nama-barang">Nama Barang</th><th class="foto">Foto Barang</th><th class="harga">Harga</th><th class="tanggal">Tanggal barang dibuat</th><th class="tanggal">Tanggal update</th>
                    </tr>
                </table>
            </div>
            </div>
            <div class="right-side">
                <form action="item.php" method="post" class="add">
                    <h2>Tambah Barang</h2>
                    <div>
                        <input name="nama" class="input-regular" type="text" placeholder="Nama Barang">
                    </div>
                     <div>
                        <input name="harga" class="input-regular" type="number" placeholder="Harga Barang">
                    </div>
                    <div>
                        <p for="">Foto Produk</p>
                        <input type="file" name="photo" class="file">
                    </div>
                    
                        <h5><?php
                            if(isset($_SESSION['add_item_error']))
                            {
                                echo $_SESSION['add_item_error'];
                            }
                        ?></h5>
                    
                    <div>
                        <button type="submit">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </content>
</body>
</html>
<?php 

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    print_r($_FILES);
    // if($_FILES['photo']['error'] == 4)
    // {
    //     $_SESSION['add_item_error'] = "File foto belum di upload";
    //     header('Location: item.php');
    //     return;
    // }
}

?>

