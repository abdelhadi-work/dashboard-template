<?php
include("config.php"); // include DB connection
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// --- SELECT PRODUCTS ---
function getProducts($conn) {
    $sql = "SELECT * FROM products ORDER BY id DESC"; // fetch all products
    $result = mysqli_query($conn, $sql);
    $products = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
    }
    return $products;
}
function deleteProduct($conn, $id) {
    $sql = "DELETE FROM products WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}

// Handle delete POST request
if (isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    deleteProduct($conn, $id);
}
// You can later add insertProduct, updateProduct, deleteProduct here


// function deleteProduct($conn, $id) {
//     $sql = "DELETE FROM products WHERE id=?";
//     $stmt = mysqli_prepare($conn, $sql);
//     mysqli_stmt_bind_param($stmt, "i", $id);
//     mysqli_stmt_execute($stmt);
// }

// Handle delete request
// if (isset($_GET['delete'])) {
//     $id = intval($_GET['delete']);
//     deleteProduct($conn, $id);

//     // Redirect back to products table page
//     header("Location: index.php"); 
//     exit();
// }
// if (isset($_GET['delete'])) {
//     $id = intval($_GET['delete']);
//     deleteProduct($conn, $id);

//     // Redirect back to products table page
//     header("Location: index.php");
//     exit();
// }
function insertProduct($conn, $title, $description, $price, $image) {
    // Upload folder inside includes/
    $targetDir = __DIR__ . "/uploads/"; // absolute path
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // create if not exists
    }

    // Save image
    $fileName = time() . "_" . basename($image["name"]);
    $targetFile = $targetDir . $fileName;
    move_uploaded_file($image["tmp_name"], $targetFile);

    // Store relative path for display in DB
    $dbPath = "/" . $fileName;

    // Insert query
    $sql = "INSERT INTO products (title, description, price, image_url) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssds", $title, $description, $price, $dbPath);
    mysqli_stmt_execute($stmt);
}


function updateProduct($conn, $id, $title, $description, $price, $image) {
    $targetDir = __DIR__ . "/uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    if ($image["error"] === 4) {
        // No new image uploaded, keep the old image URL
        // Fetch current image_url
        $sqlGet = "SELECT image_url FROM products WHERE id=?";
        $stmtGet = mysqli_prepare($conn, $sqlGet);
        mysqli_stmt_bind_param($stmtGet, "i", $id);
        mysqli_stmt_execute($stmtGet);
        $result = mysqli_stmt_get_result($stmtGet);
        $row = mysqli_fetch_assoc($result);
        $oldImage = $row['image_url'];

        // Update only title, description, price (keep image)
        $sql = "UPDATE products SET title=?, description=?, price=?, image_url=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssdsi", $title, $description, $price, $oldImage, $id);
        mysqli_stmt_execute($stmt);

    } else {
        // New image uploaded
        $fileName = time() . "_" . basename($image["name"]);
        $targetFile = $targetDir . $fileName;
        move_uploaded_file($image["tmp_name"], $targetFile);

        $dbPath = "/" . $fileName;

        $sql = "UPDATE products SET title=?, description=?, price=?, image_url=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssdsi", $title, $description, $price, $dbPath, $id);
        mysqli_stmt_execute($stmt);
    }
}

if (isset($_POST['title'], $_POST['description'], $_POST['price']) && isset($_FILES['image'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = floatval($_POST['price']);
    $image = $_FILES['image'];

    // Check if update_id exists (to decide if it's an update or insert)
    if (isset($_POST['update_id']) && !empty($_POST['update_id'])) {
        $id = intval($_POST['update_id']);
        // Call the updateProduct function
        updateProduct($conn, $id, $title, $description, $price, $image);
    } else {
        // Call the insertProduct function
        insertProduct($conn, $title, $description, $price, $image);
    }

    // Redirect to index.php after insert or update
    header("Location: /index.php");
    exit();
}

?>
