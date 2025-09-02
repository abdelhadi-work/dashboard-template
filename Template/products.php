<?php
include("includes/action.php");

$products = getProducts($conn); // fetch products
?>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        DataTable Example
    </div>
    <div class="card-body">
        <table id="datatablesSimple" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <!-- <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot> -->
            <tbody>
                <?php foreach ($products as $product): ?>
                    
                    <tr>
                        <td><?php
                         echo $product['id']; ?></td>
                        <td><?php echo htmlspecialchars($product['title']); ?></td>
                        <td><?php echo htmlspecialchars($product['description']); ?></td>
                        <td><?php echo number_format($product['price'], 2); ?></td>
                        
                       <td>
    <?php if (!empty($product['image_url'])): ?>
        <img src="includes/uploads/<?php echo htmlspecialchars($product['image_url']); ?>" width="80" alt="product">
    <?php else: ?>
        No Image
    <?php endif; ?>
</td>

     <td><button class="btn btn-warning btn-sm" 
        onclick="location.href='forms/edit_product.php?id=<?php echo $product['id']; ?>'">
    <i class="bi bi-pencil-square"></i>
</button>

  <form method="POST" style="display:inline;">
    <input type="hidden" name="delete_id" value="<?php echo $product['id']; ?>">
    <button type="submit" class="btn btn-danger btn-sm" 
            onclick="return confirm('Are you sure you want to delete this product?')">
        <i class="bi bi-trash"></i>
    </button>
</form>


                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>