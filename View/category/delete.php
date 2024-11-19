`<?php
require(__DIR__ . '/../../Config/init.php');

// Initialize the category controller
$categoryController = new CategoryController();

// Check if category_id is provided via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category_id']) && !empty($_POST['category_id'])) {
    $id = $_POST['category_id'];

    // Validate if the ID is a valid number
    if (!is_numeric($id) || $id <= 0) {
        echo "Invalid category ID.";
        exit();
    }

    // Call the destroy method to delete the category
    $categoryController->destroy($id);

    // Redirect back to the categories page
    header("Location: ../../allcategory.php");
    exit();
} else {
    echo "No category ID provided.";
}
?>`