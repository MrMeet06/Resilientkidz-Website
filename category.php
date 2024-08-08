<?php
include 'header.php';
include 'functions.php'; // Includes functions for category management

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $result = addCategory($name);
    echo json_encode($result);
    exit();
}

// Fetch all categories
$categories = fetchCategories();
?>

<div class="container mt-5">
    <h2 class="mb-4">Manage Categories</h2>

    <form id="categoryForm" action="category.php" method="POST" target="hiddenIframe" onsubmit="handleFormSubmit(event)">
        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Category</button>
    </form>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody id="categoryTableBody">
            <?php
            $id = 1;
            if (!empty($categories)) :
                foreach ($categories as $category) : ?>
                    <tr>
                        <td><?= htmlspecialchars($id++) ?></td>
                        <td><?= htmlspecialchars($category['name']) ?></td>
                        <td><?= htmlspecialchars($category['created_at']) ?></td>
                    </tr>
                <?php endforeach;
            else : ?>
                <tr>
                    <td colspan="3" class="text-center">No categories found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<iframe name="hiddenIframe" style="display:none;"></iframe>
<?php include 'footer.php'; ?>