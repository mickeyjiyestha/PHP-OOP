<?php
require(__DIR__ . '/../Config/init.php');
class CategoryController
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
    }

    /**
     * Index: this method allows users to  view all products in the database.
     */
    public function index() {
        return $this->categoryModel->getAllCategories();
        
    }

    public function getCategoryById($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid ID provided.");
        }
        $database = new Database();
        $result = $database->selectData('categories', $id);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        var_dump($data);
        if (empty($data['category_name'])) {
            throw new Exception("Category name is required.");
        }
    
        $categoryData = [
            'category_name' => $data['category_name']
        ];
    
        // Debugging: Cek data yang akan dikirim ke model
        var_dump($categoryData); 
    
        return $this->categoryModel->createCategory($categoryData);
    }
    /**
     * Show: This method is used to show one specific product by its id.
     *   @param int $id - The id of the product that needs to be shown.
     *   @return array $product - An associative array containing information about the selected product.
     *   If no product with the given id exists, an empty array will be returned.
     */
    public function show($id) {}

    public function  update($id, $data) {
        if (empty($data['category_name'])) {
            throw new Exception("Category name is required.");
        }
    
        $categoryData = [
            'category_name' => $data['category_name']
        ];
    
        return $this->categoryModel->updateCategory($id, $categoryData);
    }

    public function destroy($id) {
        try {
            // Check if the category exists
            $category = $this->categoryModel->getCategoryById($id);
            if ($category) {
                // Call the delete method in the model
                $this->categoryModel->deleteCategory($id);
                header("Location: index.php?message=Category+deleted+successfully");
            } else {
                throw new Exception("Category not found.");
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function restore($id) {
        return $this->categoryModel->restoreCategory($id);
    
    }
}