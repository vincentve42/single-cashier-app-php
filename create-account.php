<?php 
require __DIR__ . "/./autoloader/load.php";

printf("Selamat datang di program kasir\n");

$username = readline("Masukan username : ");

$query = "SELECT * FROM account WHERE name='$username'";

$result = $database->query($query);

if($result->num_rows > 0)
{
    printf("Username %s telah terdaftar dalam database", $username);
    return 1;
}

$password = readline("Masukan password");
$query = "INSERT INTO account(name, password) VALUES('$username', $password)";

$result = $database->query($query);

if(!$result){
    printf("Error description: %s", $database->error);
}

?>