<?php 
require __DIR__ . "/./autoloader/load.php";

printf("Selamat datang di program kasir\n");

$username = readline("Masukan username : ");

$query = "SELECT * FROM account WHERE name='$username'";

$result = $database->query($query);

if(strlen($username) > 24)
{
    printf("Maksimal jumlah karakter untuk username adalah 24");
    return 1;
}
if($result->num_rows > 0)
{
    printf("Username %s telah terdaftar dalam database", $username);
    return 1;
}

$password = readline("Masukan password : ");
$date = getCurrentDate();
$query = "INSERT INTO account(name, password, admin, created_at, updated_at) VALUES('$username', '$password', '1', '$date', '$date')";

$result = $database->query($query);

if(!$result){
    printf("Error description: %s", $database->error);
}

?>