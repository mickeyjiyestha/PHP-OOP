<?php
require(__DIR__ . '/../../Config/init.php');

// Initialize the product controller
$productController = new ProductController();

// Check if product_id is provided via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && !empty($_POST['product_id'])) {
    $id = $_POST['product_id'];

    // Validate if the ID is a valid number
    if (!is_numeric($id) || $id <= 0) {
        echo "Invalid product ID.";
        exit();
    }

    // Call the destroy method to delete the product
    $productController->destroy($id);

    // Redirect back to the products page
    header("Location: ../../index.php");
    exit();
} else {
    echo "No product ID provided.";
}
?>