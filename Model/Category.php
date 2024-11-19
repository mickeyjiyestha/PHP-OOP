<?php

require(__DIR__ . '/../Config/init.php');

class Category extends Model
{
    /**
     * Constructor that calls the parent constructor and sets the table name for this class.
     * $this->tableName is refers to the table name in the database which will be used by this model.
     * $this->setTableName is a method from the parent class that sets the table name.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTableName('categories');
    }

    /**
     * Method  to get all Categorys from the database and return the result as an associative array.
     */
    public function getAllCategories()
    {
        $sql = "SELECT * FROM categories WHERE isDeleted = 0";
    
    $stmt = $this->db->getInstance()->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    
    


    public function getCategoryById($id)
    {
        // Mengambil data kategori berdasarkan id
        $database = new Database();
        $result = $database->selectData('categories', $id);
        return $result->fetch(PDO::FETCH_ASSOC); // Mengembalikan hasil sebagai array asosiasi
    }
    

    public function createCategory($data)
    {
        $fillable = [
            'category_name' => $data['category_name'],
        ];

        

        var_dump($fillable);

        $db = new Database();
        $result = $db->insertData('categories', $fillable);
    
        return $result;
    }

    public function updateCategory($id, $data)
    {
        $fillable = [
            'category_name' => $data['category_name'],
        ];
    
        // Build the SQL UPDATE query
        $setPart = [];
        foreach ($fillable as $key => $value) {
            $setPart[] = "$key = :$key";
        }
    
        $setPart = implode(", ", $setPart);
        $sql = "UPDATE categories SET $setPart WHERE id = :id";
        echo $sql;
    
        // Prepare and execute the statement
        $stmt = $this->db->getInstance()->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    
        foreach ($fillable as $key => $value) {
            $stmt->bindValue(":$key", $value, PDO::PARAM_STR);
        }
    
        // Execute and return the result
        return $stmt->execute();
    }

    public function deleteCategory($id)
    {
        $database = new Database();
        $database->deleteRecord('categories', $id);
    }

    public function restoreCategory($id)
    {
        return $this->db->restoreRecord($this->tableName);
    }
}