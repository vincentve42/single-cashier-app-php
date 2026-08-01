<?php
function checkAuth(){
    if(isset($_SESSION['user']))
    {
        return 1;
    }
    return 0;
}

?>