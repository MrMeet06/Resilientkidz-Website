<?php

include 'header.php';
include 'config.php'; // This should handle database connection

// Handle form submission to add a new category
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $stmt = $conn->prepare("INSERT INTO category (name) VALUES (?)");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $id = $stmt->insert_id;
    $created_at = date('Y-m-d H:i:s');
    echo json_encode(['id' => $id, 'name' => $name, 'created_at' => $created_at]);
    exit();
}

// Fetch all categories from the database
$sql = "SELECT * FROM category ORDER BY created_at DESC";
$result = $conn->query($sql);
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
            if ($result->num_rows > 0) :
                while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?= htmlspecialchars($id++) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                    </tr>
                <?php endwhile;
            else : ?>
                <tr>
                    <td colspan="3" class="text-center">No categories found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<iframe name="hiddenIframe" style="display:none;"></iframe>

<script>
    function handleFormSubmit(event) {
        event.preventDefault();
        const form = document.getElementById('categoryForm');
        const formData = new FormData(form);
        fetch(form.action, {
                method: form.method,
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.id && data.name && data.created_at) {
                    const tableBody = document.getElementById('categoryTableBody');
                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                    <td>${data.id}</td>
                    <td>${data.name}</td>
                    <td>${data.created_at}</td>
                `;
                    tableBody.prepend(newRow);
                    form.reset();
                } else {
                    alert('Failed to add category');
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>

<?php include 'footer.php'; ?>