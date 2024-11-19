<?php
require(__DIR__ . '/../Config/init.php');
class ProductController
{
    private $productModel;
    private $categoryModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }

    /**
     * Index: this method allows users to  view all products in the database.
     */
    public function index() {
        return $this->productModel->getAllProducts();
        
    }

    public function getCategories() {
        return $this->categoryModel->getAllCategories(); // Fetch all categories from the Category model
    }

    public function create($data)
    {
        // Validate required fields
        if (empty($data['product_name']) || empty($data['category_id']) || empty($data['price']) || empty($data['stock'])) {
            // If any required field is missing, return false to indicate failure
            return false;
        }
    
        // Sanitize inputs
        $productName = htmlspecialchars($data['product_name']);
        $categoryId = (int) $data['category_id'];  
        $price = (float) $data['price'];           
        $stock = (int) $data['stock'];            
    
        // Call the model to insert the data
        $result = $this->productModel->createProduct([
            'product_name' => $productName,
            'category_id' => $categoryId,
            'price' => $price,
            'stock' => $stock,
        ]);
    
        // Return the result (whether the insert was successful or not)
        return $result;
    }

    public function getProductById($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid ID provided.");
        }
        $database = new Database();
        $result = $database->selectData('products', $id);
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    
    

    
    
    /**
     * Show: This method is used to show one specific product by its id.
     *   @param int $id - The id of the product that needs to be shown.
     *   @return array $product - An associative array containing information about the selected product.
     *   If no product with the given id exists, an empty array will be returned.
     */
    public function show($id) {}

    public function update($id, $data) {
        var_dump($data);
    // Validasi input
    if (empty($data['product_name']) || empty($data['category_id']) || empty($data['price'])) {
        throw new Exception("Product name, category, and price are required.");
    }

    // Menyiapkan data yang akan diupdate
    $productData = [
        'product_name' => $data['product_name'],
        'category_id' => $data['category_id'],
        'price' => $data['price'],
        'stock' => isset($data['stock']) ? $data['stock'] : 0, // Menggunakan 0 jika stock tidak disertakan
        'description' => isset($data['description']) ? $data['description'] : '', // Menggunakan string kosong jika description tidak disertakan
    ];

    // Memanggil metode updateProduct pada model untuk melakukan update di database
    return $this->productModel->updateProduct($id, $productData);
    }

    public function destroy($id) {
        try {
            // Check if the product exists
            $product = $this->productModel->getProductById($id);
            if ($product) {
                // Call the delete method in the model
                $this->productModel->deleteProduct($id);
                header("Location: index.php?message=Product+deleted+successfully");
            } else {
                throw new Exception("Product not found.");
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    

    public function restore($id) {
        return $this->productModel->restoreProduct($id);
    }
}