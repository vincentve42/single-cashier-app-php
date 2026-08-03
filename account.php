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
    <title>Account</title>
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
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <content>
        <div class="account-content">
            <div class="table">
                <table>
                    <tr>
                        <th class="id">ID</th><th class="nama">Nama</th><th class="password">Pasword</th><th class="isAdmin">Admin</th><th class="isAdmin">Waktu dibuat</th><th class="isAdmin">Waktu terakhir diupdate</th>
                    </tr>
                    <?php 

                        $stmt = $database->prepare("SELECT * FROM account");
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($id, $username, $password, $isAdmin, $created_at, $update_at);

                       
                        while($stmt->fetch())
                        {
                            
                            if($isAdmin == 0)
                            {
                                $isAdminStr = "Pegawai";
                            }
                            if($isAdmin == 1)
                            {
                                $isAdminStr = "Admin";
                            }
                            if(!isset($isAdminStr))
                            {
                                $isAdminStr = "Pegawai";
                            }
                            echo '<tr>';
                            echo "<td>" . $id ."</td>";
                            echo "<td>" . $username ."</td>";
                            echo "<td>" . $password ."</td>";
                            echo "<td>" . $isAdminStr ."</td>";
                            echo "<td>" . $created_at ."</td>";
                            echo "<td>" . $update_at ."</td>";
                            echo '</tr>';
                        }
                    $stmt->close();
                    ?>
                </table>
            </div>
            <div class="manage">
                <form class="add" action="account.php" method="post">
                    <h2>Tambah Akun</h2>
                    <div>
                        <input class="nama" required name="username" type="text" placeholder="Nama">
                    </div>
                    <div>
                        <input class="nama" required name="password" type="text" placeholder="Password">
                    </div>
                    <div>
                        <select name="isadmin" id=""><option value="0">Pegawai</option><option value="1">Admin</option></select>
                    </div>
                    <div>
                        <p class="error">
                            <?php
                                if(isset($_SESSION['add_error']))
                                {
                                    echo $_SESSION['add_error'];
                                } 
                            ?>
                        </p>
                    </div>
                    <div>
                        <button type="submit">Create</button>
                    </div>
                </form> 
                <form class="edit" action="edit-account.php" method="post">
                    <h2>Edit Akun</h2>
                    <div>
                        <select name="id" id="">
                            <?php 
                               $stmt = $database->prepare("SELECT * FROM account");
                               $result = $stmt->execute();
                               if(!$result)
                                {
                                    die("Prepare failed: " . $database->error);
                                }
                               $stmt->store_result();
                               
                               $stmt->bind_result($id, $username,$password, $isadmin, $created_at, $update_at);
                               while($stmt->fetch())
                                {
                                    echo "<option name='id' value='" . $id ."'>". $username."</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div>
                        <input class="nama" name="username" type="text" placeholder="Nama">
                    </div>
                    <div>
                        <input class="nama" name="password" type="text" placeholder="Password">
                    </div>
                    <div>
                        <select name="isadmin" id=""><option value="0">Pegawai</option><option value="1">Admin</option></select>
                    </div>
                    <div>
                        <p class="error">
                            <?php 
                                if(isset($_SESSION['edit_error'] ))
                                {
                                    echo $_SESSION['edit_error'];
                                }
                            ?>
                        </p>
                    </div>
                    <div>
                        <button name="edit" class="create">Edit</button><button name="delete" class="delete">Delete</button>
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
    $stmt = $database->prepare("SELECT * FROM account WHERE name=?");
    $stmt->bind_param("s", $_POST['username']);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows() > 0)
    {
        $_SESSION['add_error'] = "Nama " . $_POST['username']. " telah terdapat dalam database";
        $stmt->close();
        header('Location: account.php');
        return;
    }
    $stmt->close();
    $date = getCurrentDate();
    $stmt = $database->prepare("INSERT INTO account(name, password, admin, created_at, updated_at) VALUES(?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $_POST['username'], $_POST['password'], $_POST['isadmin'], $date, $date);
    $stmt->execute();
    $_SESSION['add_error'] = "";
    header('Location: account.php');
    $stmt->close();
    return;
}

?>