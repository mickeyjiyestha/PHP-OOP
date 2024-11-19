<?php
require_once(__DIR__ . '/../../Config/init.php');

$productController = new ProductController();
$categories = $productController->getCategories();

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Fetch the product by ID
    $product = $productController->getProductById($productId);
} else {
    echo "Product ID not specified.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    // Validate product_name
    if (empty($_POST["product_name"])) {
        $errors['product_name'] = "Product Name is required";
    } else {
        $product_name = $_POST["product_name"];
    }

    // Validate price
    if (empty($_POST["price"])) {
        $errors['price'] = "Price is required";
    } else if (is_numeric($_POST["price"]) == false) {
        $errors['price'] = "Price must be a number";
    } else if (floatval($_POST["price"]) <= 0) {
        $errors['price'] = "Price should be greater than zero";
    } else {
        $price = $_POST["price"];
    }

    // Validate stock
    if (!isset($_POST["stock"]) || empty($_POST["stock"])) {
        $errors['stock'] = "Stock is required";
    } else if (!is_numeric($_POST["stock"])) {
        $errors['stock'] = "Stock must be a valid number";
    } else if ((int)$_POST["stock"] < 0) {
        $errors['stock'] = "Stock cannot be negative";
    } else {
        $stock = $_POST["stock"];
    }

    // Validate category_id
    if (empty($_POST["category_id"])) {
        $errors['category_id'] = "Category is required";
    } else {
        $category_id = $_POST["category_id"];
    }

    // Check for validation errors and update product
    if (empty($errors)) {
        $data = [
            'product_name' => $_POST['product_name'],
            'price' => $_POST['price'],
            'stock' => $_POST['stock'],
            'category_id' => $_POST['category_id'],  // Add the category_id here
        ];

        if ($productController->update($productId, $data)) {
            header("Location: /../../index.php"); // Redirect to product list after successful update
            exit;
        } else {
            echo "Error updating product.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container my-5">
        <h2>Edit Product</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name"
                    value="<?= $product['product_name'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" value="<?= $product['price'] ?>"
                    required>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <option value="">Select Category</option>
                    <?php
                    // Loop through the categories and populate the options
                    foreach ($categories as $category) {
                        $selected = $product['category_id'] == $category['id'] ? 'selected' : '';
                        echo "<option value='{$category['id']}' {$selected}>{$category['category_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" value="<?= $product['stock'] ?>"
                    required>
            </div>
            <button type="submit" class="btn btn-success">Update Product</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>