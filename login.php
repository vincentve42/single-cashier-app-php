<?php

require __DIR__ . "/./autoloader/load.php";

// auth checker

if(checkAuth())
{
    header('Location: index.php');
}


?>

<!-- Todo Login system -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>
</head>
<body>
    <form class="login" action="login.php" method="post">
        <h2>Login</h2>
        <div>
            <input type="text" required name="username" id="" placeholder="Username">
        </div>
        <div class="input-divider">

            <input type="password" required name="password" id="" placeholder="Password">
        </div>
        <div>
            <p class="error">
                <?php 
                    if(isset($_SESSION["error"]))
                    {
                        echo $_SESSION["error"];
                    }
                ?>
            </p>
        </div>
        <div>
            <button type="submit">Login</button>
        </div>
    </form>
</body>
</html>
<?php 
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(strlen($_POST['username']) > 24)
    {
        if(isset($_SESSION['error']))
        {
            unset($_SESSION['error']);
        }
        $_SESSION['error'] = "Maksimal karakter username adalah 24 karakter";
        header('Location: login.php');
    }
    $stmt = $database->prepare("SELECT * FROM account WHERE name=? AND password=?");
    $stmt->bind_param("ss", $_POST['username'], $_POST['password']);
    $stmt->execute();

    $stmt->store_result();
    
    if($stmt->num_rows() == 0)
    {
        if(isset($_SESSION['error']))
        {
            unset($_SESSION['error']);
        }
        $_SESSION['error'] = "Akun " . $_POST['username']. " tidak cocok dalam data database kami";
        header('Location: login.php');
        $stmt->close();
    }
    else
    {
        $stmt->bind_result($id,$username, $password, $isAdmin);

        if(isset($isAdmin))
        {
            $isAdmin = 0;
        }
        if(isset($_SESSION['error']))
        {
            unset($_SESSION['error']);
        }
        $stmt->fetch();

        $_SESSION['user'] = new Account($username, $password, $isAdmin);

        $stmt->close();

        header('Location: index.php');
    }
}
?>