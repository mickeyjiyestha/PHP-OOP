<?php
require(__DIR__ . '/../../Config/init.php'); // Pastikan file init.php sudah benar

// Menginisialisasi controller kategori
$categoryController = new CategoryController();

// Memastikan 'id' ada di parameter URL dan merupakan angka yang valid
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
    $id = $_GET['id'];

    // Lakukan query untuk mengambil kategori berdasarkan ID
    try {
        $category = $categoryController->getCategoryById($id);
        
        // Cek apakah kategori ditemukan
        if ($category) {
            // Tampilkan data kategori
            $categoryId = $category['id'];  // Assign category ID for the form action
        } else {
            echo "Category not found.";
            exit;  // Stop further processing if category is not found
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit;  // Stop further processing if there’s an exception
    }
} else {
    echo "Invalid or missing category ID.";
    exit;  // Stop further processing if the ID is invalid or missing
}

// Proses jika form di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category_name'])) {
    try {
        // Memanggil metode update dari CategoryController
        $categoryController->update($categoryId, $_POST);

        // Redirect ke halaman daftar kategori setelah berhasil update
        header("Location: /../../allCategory.php");
        exit;
    } catch (Exception $e) {
        // Menampilkan error jika ada masalah
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary">Update Category</h2>
            <a href="/../../allCategory.php" class="btn btn-secondary">Back to Category List</a>
        </div>

        <!-- Form untuk mengupdate kategori -->
        <form action="update.php?id=<?php echo $categoryId; ?>" method="POST">
            <div class="mb-3">
                <label for="category_name" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="category_name" name="category_name"
                    value="<?php echo htmlspecialchars($category['category_name']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Category</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>