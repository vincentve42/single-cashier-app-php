<?php 

class Transaction{
    public string $created_at;
    public string $updated_at;
    public int $amount;
    public $itemId = array();

    public function __construct()
    {

    }
    public function __destruct()
    {

    }
    public function save($database)
    {
    
    }
}
?>