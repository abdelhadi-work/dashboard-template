<?php
include("../includes/config.php"); // DB connection
include("../includes/actions.php"); // functions

// Get product by ID
if (!isset($_GET['id'])) {
    die("Product ID not provided.");
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM products WHERE id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    die("Product not found.");
}
?>

<?php include("../head.php"); ?>

<body class="sb-nav-fixed">
    <?php include("../header.php"); ?>
    
    <div id="layoutSidenav_content">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-7">

                    <div class="card shadow-lg rounded-4 border-0">
                        <div class="card-header bg-dark text-white text-center py-3">
                            <h3 class="mb-0">Edit Product</h3>
                        </div>
                        <div class="card-body p-4" style="background-color: #f8f9fa;">
                            
                            <!-- Edit Form -->
                            <form action="/includes/action.php" method="POST" enctype="multipart/form-data">
                                <!-- Hidden ID -->
                                <input type="hidden" name="update_id" value="<?= $product['id']; ?>">

                                <!-- Product Title -->
                                <div class="mb-4">
                                    <label for="title" class="form-label fw-semibold">Product Title</label>
                                    <input type="text" 
                                           class="form-control rounded-pill shadow-sm" 
                                           id="title" 
                                           name="title" 
                                           value="<?= htmlspecialchars($product['title']); ?>" 
                                           required>
                                </div>

                                <!-- Product Description -->
                                <div class="mb-4">
                                    <label for="description" class="form-label fw-semibold">Description</label>
                                    <textarea class="form-control rounded-3 shadow-sm" 
                                              id="description" 
                                              name="description" 
                                              rows="4" 
                                              required><?= htmlspecialchars($product['description']); ?></textarea>
                                </div>

                                <!-- Product Price -->
                                <div class="mb-4">
                                    <label for="price" class="form-label fw-semibold">Price ($)</label>
                                    <input type="number" 
                                           step="0.01" 
                                           class="form-control rounded-pill shadow-sm" 
                                           id="price" 
                                           name="price" 
                                           value="<?= htmlspecialchars($product['price']); ?>" 
                                           required>
                                </div>

                                <!-- Product Image -->
                                <div class="mb-4">
                                    <label for="image" class="form-label fw-semibold">Upload New Image</label>
                                    <input type="file" 
                                           class="form-control shadow-sm" 
                                           id="image" 
                                           name="image" 
                                           accept="image/*">
                                    <small class="text-muted mt-1 d-block">
                                        Current Image: 
                                        <?php if (!empty($product['image_url'])): ?>
                                            <img src="../includes/uploads/<?= htmlspecialchars($product['image_url']); ?>" 
                                                 alt="product" 
                                                 width="80" 
                                                 class="rounded">
                                        <?php else: ?>
                                            No image uploaded
                                        <?php endif; ?>
                                    </small>
                                </div>

                                <!-- Submit -->
                                <div class="d-grid mt-3">
                                    <button type="submit" class="btn btn-dark btn-lg rounded-pill">
                                        Update Product
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <?php include("../footer.php"); ?>
    </div>
      
    <?php include("../script.php"); ?> 
</body>
</html>
