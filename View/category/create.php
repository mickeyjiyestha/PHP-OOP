<?php
require(__DIR__ . '/../../Config/init.php');

$categoryController = new CategoryController();
$errors = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $data = [
        'category_name' => $_POST['category_name']
    ];

    // Call the create method and handle any errors
    try {
        $categoryController->create($data);
        // Redirect or display success message
        echo "<div class='alert alert-success'>Category successfully added.</div>";
    } catch (Exception $e) {
        $errors['category_name'] = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container my-5">
        <h2 class="text-center text-primary mb-4">Add Category</h2>
        <div class="card p-4 shadow-sm">
            <a href="/../allCategory.php" class="btn btn-secondary mb-3">Back to Category List</a>

            <!-- Category Input Form -->
            <form action="" method="post">
                <div class="mb-3">
                    <label for="category_name" class="form-label">Category Name</label>
                    <input type="text" id="category_name" name="category_name" class="form-control" required>
                    <?php if (isset($errors['category_name'])): ?>
                    <div class="text-danger"><?php echo $errors['category_name']; ?></div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary w-100">Add Category</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>