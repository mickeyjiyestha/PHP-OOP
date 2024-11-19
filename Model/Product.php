    <?php

    require(__DIR__ . '/../Config/init.php');

    class Product extends Model
    {
        /**
         * Constructor that calls the parent constructor and sets the table name for this class.
         * $this->tableName is refers to the table name in the database which will be used by this model.
         * $this->setTableName is a method from the parent class that sets the table name.
         */
        public function __construct()
        {
            parent::__construct();
            $this->setTableName('products');
        }

        /**
         * Method  to get all products from the database and return the result as an associative array.
         */
        public function getAllProducts()
        {
            $sql = "
            SELECT p.id, p.product_name, c.category_name, p.price, p.stock
            FROM " . $this->tableName . " p
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.isDeleted = 0
            ";
        
            $stmt = $this->db->getInstance()->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        
        


        public function getProductById($id)
        {
            $database = new Database();
            $result = $database->selectData('products', $id);
            return $result->fetch(PDO::FETCH_ASSOC);
        }

        public function createProduct($data)
        {
            $fillable = [
                'product_name' => $data['product_name'],
                'category_id' => $data['category_id'],
                'price' => $data['price'],
                'stock' => $data['stock'],
                'isDeleted' => 0 
            ];

                $db = new Database();
        $result = $db->insertData('products', $fillable);

        // Return true if the insert was successful, otherwise false
        return $result;
        }

        public function updateProduct($id, $data)
        {
            try {
                $fillable = [
                    'product_name' => $data['product_name'],
                    'category_id' => $data['category_id'],
                    'price' => $data['price'],
                    'stock' => $data['stock'],
                ];
            
                $setPart = [];
                foreach ($fillable as $key => $value) {
                    $setPart[] = "$key = :$key";
                }
            
                $setPart = implode(", ", $setPart);
                $sql = "UPDATE products SET $setPart WHERE id = :id AND isDeleted = 0";
                
                $stmt = $this->db->getInstance()->prepare($sql);
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                foreach ($fillable as $key => $value) {
                    $stmt->bindValue(":$key", $value, PDO::PARAM_STR);
                }
            
                $result = $stmt->execute();
                return $result;
            } catch (Exception $e) {
                // Log error or display it
                echo "Error: " . $e->getMessage();
                return false;
            }
        }
        

        public function deleteProduct($id)
        {
            $database = new Database();
            $database->deleteRecord('products', $id);
        }
        
        public function restoreProduct($id)
        {
            return $this->db->restoreRecord($this->tableName);
        }
    }