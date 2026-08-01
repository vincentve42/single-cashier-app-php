<?php 

class Item{
    public string $name;
    public int $price;
    public string $imagePath;
    public string $created_at;
    public string $updated_at;
    public function __construct(string $name, int $price, string $imagePath)
    {
        $this->name = $name;
        $this->price = $price;
        $this->imagePath = $imagePath;
    }
    public function __destruct()
    {

    }
    public function save($database)
    {
    
    }
}
?>