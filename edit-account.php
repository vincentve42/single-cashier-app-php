<?php
require __DIR__ . "/./autoloader/load.php";

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

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(isset($_POST['edit']))
    {
        if(strlen($_POST['username']) > 0)
        {
            $stmt = $database->prepare("SELECT * FROM account WHERE name=?");
            $stmt->bind_param("s", $_POST['username']);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $username, $password,$isAdmin, $created_at, $updated_at);
            if($stmt->num_rows() > 0)
            {
                $stmt->fetch();
                if(intval($_POST['id']) == $id)
                {
                    $_SESSION['edit_error'] = "";
                }
                else
                {
                    $_SESSION['edit_error'] = 'Username '. $_POST['username'] .' telah ada';
                    $stmt->close();

                    header('Location: account.php');

                    return;
                }
            
            }
            
            $stmt->close();
            $tempPassword = "";
            if(strlen($_POST['password']) > 0)
            {
                $tempPassword = $_POST['password'];
            }

            $stmt = $database->prepare("SELECT * FROM account where id=?");

            $stmt->bind_param("d",$_POST["id"]);

            $stmt->execute();

            $stmt->store_result();

            $stmt->bind_result($id, $username, $password, $isAdmin, $created_at, $updated_at);

            $stmt->fetch();

            $stmt->close();

            $isDiff = 0;
            if(strlen($_POST['username'] > 0) && strcmp($_POST['username'], $password) != 0)
            {
                $isDiff = 1;
            }
            if(strlen($tempPassword > 0) && strcmp($tempPassword, $password) != 0)
            {
                $isDiff = 1;
            }
            if($_POST['isadmin'] != $isAdmin)
            {
                $isDiff = 1;
            }
            if($isDiff == 0)
            {
                $_SESSION['edit_error'] = "Tidak ada yang diubah";
                header("Location: account.php");
                
                return;
            }
            if($isDiff == 1)
            {
                $stmt->prepare("UPDATE account SET name=?, password=?, admin=?, updated_at=? WHERE id=?");
               
                if(strlen($tempPassword) > 0)
                {
                    $postpassword = $_POST['password'];
                }
                if(strlen($tempPassword) <= 0)
                {
                    $postpassword = $password;
                }
                $updated = getCurrentDate();
                $stmt->bind_param("ssdsd", $_POST["username"], $postpassword, $_POST['isadmin'], $updated, $_POST['id']);
                $_SESSION['edit_error'] = '';
                
                $stmt->execute();

                $stmt->close();

                header('Location: account.php');

                return;
            }
        }
        else
        {
            echo "jalan";
            $stmt = $database->prepare("SELECT * FROM account where id=?");

            $stmt->bind_param("d",$_POST["id"]);

            $stmt->execute();

            $stmt->store_result();

            $stmt->bind_result($id, $username, $password, $isAdmin, $created_at, $updated_at);

            $stmt->fetch();
            $stmt->close();
            $temppassword = "";
            $isDiff = 0;

            if(strlen($_POST['password'] > 0) & strcmp($password,$_POST['password'] ) != 0)
            {
                $isDiff = 1;
            }
            if($_POST['isadmin'] != $isAdmin)
            {
                $isDiff = 1;
            }
            if($isDiff == 0)
            {
                
                $_SESSION['edit_error'] = "Tidak ada yang diubah";
                header("Location: account.php");
                
                return;
            }
            
            if($isDiff == 1)
            {
                if(strlen($_POST['password'] ) <= 0)
                {
                    $temppassword = $password;
                }
                if(strlen($_POST['password']) > 0)
                {
                    $temppassword = $_POST['password'];
                }
                $updated = getCurrentDate();
                $stmt = $database->prepare("UPDATE account SET name=?, password=?, admin=?, updated_at=? WHERE id=?");
                $stmt->bind_param("ssdsd", $username, $temppassword, $_POST['isadmin'], $updated, $_POST['id']);
                $_SESSION['edit_error'] = "";
                $stmt->execute();
                $stmt->close();
                header("Location: account.php");
                return;
            }
            
        }
    }
    if(isset($_POST['delete']))
    {
        $stmt = $database->prepare("SELECT * FROM account WHERE id=?");
        $stmt->bind_param("d", $_POST['id']);
        $stmt->execute();
        $stmt->store_result();
        
        if($stmt->num_rows() == 0)
        {
             $_SESSION['edit_error'] = "Akun " .$_POST['id']. " tidak ada" ;
             header('Location: account.php');
             $stmt->close();
             return;
        }
        $stmt->close();
        $stmt = $database->prepare("DELETE FROM account WHERE id=?");
        $stmt->bind_param("d", $_POST['id']);
        $stmt->execute();
        $stmt->close();
        $_SESSION['edit_error'] = '';
        header('Location: account.php');
        return 1;
    }
}
?>