<?php
require(__DIR__ . '/../../Config/init.php');

// Initialize the product controller
$productController = new ProductController();
$errors = [];

// Fetch categories
$categoryController = new CategoryController();
$categories = $categoryController->index();

// If form is submitted, handle the data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'product_name' => $_POST['product_name'],
        'category_id' => $_POST['category_id'],
        'price' => $_POST['price'],
        'stock' => $_POST['stock'],
    ];

    try {
        $productController->create($data);
        header("Location: /index.php?message=Product+added+successfully");
        exit;
    } catch (Exception $e) {
        $errors[] = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container my-5">
        <h2 class="text-center text-primary mb-4">Add Product</h2>
        <div class="card p-4 shadow-sm">
            <a href="/index.php" class="btn btn-secondary mb-3">Back to Product List</a>

            <!-- Product Input Form -->
            <form action="" method="post">
                <div class="mb-3">
                    <label for="product_name" class="form-label">Product Name</label>
                    <input type="text" id="product_name" name="product_name" class="form-control"
                        value="<?php echo isset($data['product_name']) ? htmlspecialchars($data['product_name']) : ''; ?>"
                        required>
                    <?php if (isset($errors['product_name'])): ?>
                    <div class="text-danger"><?php echo $errors['product_name']; ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select id="category" name="category_id" class="form-select" required>
                        <option value="">-- Select Category --</option>
                        <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>"
                            <?php echo isset($data['category_id']) && $data['category_id'] == $category['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category['category_name']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['category_id'])): ?>
                    <div class="text-danger"><?php echo $errors['category_id']; ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" id="price" name="price" class="form-control"
                        value="<?php echo isset($data['price']) ? htmlspecialchars($data['price']) : ''; ?>" required>
                    <?php if (isset($errors['price'])): ?>
                    <div class="text-danger"><?php echo $errors['price']; ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" id="stock" name="stock" class="form-control"
                        value="<?php echo isset($data['stock']) ? htmlspecialchars($data['stock']) : ''; ?>" required>
                    <?php if (isset($errors['stock'])): ?>
                    <div class="text-danger"><?php echo $errors['stock']; ?></div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary w-100">Add Product</button>
            </form>
        </div>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>