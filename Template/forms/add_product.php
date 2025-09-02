<?php include("../head.php"); ?>

<body class="sb-nav-fixed">
    <?php include("../header.php"); ?>
    
    <div id="layoutSidenav_content">
        
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">

                    <div class="card shadow-lg rounded-3">
                        <div class="card-header bg-primary text-white text-center">
                            <h3>Add New Product</h3>
                        </div>
                        <div class="card-body">
                            <form action="/includes/action.php" method="POST" enctype="multipart/form-data">
                                
                                <!-- Product Title -->
                                <div class="mb-3">
                                    <label for="title" class="form-label">Product Title</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>

                                <!-- Product Description -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                                </div>

                                <!-- Product Price -->
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price ($)</label>
                                    <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                                </div>

                                <!-- Product Image -->
                                <div class="mb-3">
                                    <label for="image" class="form-label">Upload Image</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                                </div>

                                <!-- Submit -->
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success">Add Product</button>
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
