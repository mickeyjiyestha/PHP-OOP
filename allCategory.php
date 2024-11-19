<?php
require_once(__DIR__ . '/Config/init.php');

$categoryController = new CategoryController();

// Fetch all categories
$categories = $categoryController->index();

// Check if the form was submitted to restore a category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["restoreCategories"])) {
    $categoryController->restore($_POST["restoreCategories"]);
    header("Location: allCategory.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category List</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary">Category List</h2>
            <div>
                <a href="View/category/create.php" class="btn btn-success me-2">Add Category</a>
                <a href="/index.php" class="btn btn-secondary">Back to Products</a>
            </div>
        </div>

        <!-- Tombol Restore All Categories -->
        <form action="allCategory.php" method="POST" class="mb-4">
            <button type="submit" name="restoreCategories" class="btn btn-primary">Restore All Categories</button>
        </form>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($categories) {
                    foreach ($categories as $category) {
                        echo "<tr>";
                        echo "<td>" . ($category['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($category['category_name']) . "</td>";
                        echo "<td>
                                <a href='View/category/update.php?id=" . $category['id'] . "' class='btn btn-warning btn-sm'>Update</a>
    <form action='/View/category/delete.php' method='POST' style='display:inline;'>
        <input type='hidden' name='category_id' value='" . $category['id'] . "'>
        <button type='submit' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this category?\");'>Delete</button>
    </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='text-center'>No categories available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>