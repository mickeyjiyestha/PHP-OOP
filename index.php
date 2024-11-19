<?php
// Include necessary files
require_once(__DIR__ . '/Config/init.php');

// Initialize the ProductController
$productController = new ProductController();

// Fetch the products from the controller
$products = $productController->index();

// Handle the restore action if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["restoreAllProducts"])) {
    $productController->restore($_POST["restoreAllProducts"]);
    header("Location: index.php");
}

// Handle the delete action if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["deleteProduct"])) {
    $productController->destroy($_POST["product_id"]);
    header("Location: index.php");
    exit; // Always call exit after a redirect to stop further execution
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary">Product List</h2>
            <div>
                <a href="View/products/create.php" class="btn btn-success me-2">Add Product</a>
                <a href="allCategory.php" class="btn btn-secondary">All Categories</a>
            </div>
        </div>

        <!-- Button to restore all products -->
        <form action="index.php" method="POST" class="mb-4">
            <button type="submit" name="restoreAllProducts" class="btn btn-warning">Restore All Products</button>
        </form>

        <!-- Product table -->
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($products) {
                    foreach ($products as $product) {
                        echo "<tr>";
                        echo "<td>" . $product['id'] . "</td>";
                        echo "<td>" . $product['product_name'] . "</td>";
                        echo "<td>" . $product['category_name'] . "</td>";
                        echo "<td>" . $product['price'] . "</td>";
                        echo "<td>" . $product['stock'] . "</td>";
                        echo "<td>
                                <a href='View/products/update.php?id=" . $product['id'] . "' class='btn btn-primary btn-sm'>Edit</a>
<form action='/View/products/delete.php' method='POST' style='display:inline;'>
    <input type='hidden' name='product_id' value='" . $product['id'] . "'>
    <button type='submit' name='deleteProduct' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\");'>Delete</button>
</form>

                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No products available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>