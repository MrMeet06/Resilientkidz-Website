        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.dropdown-item').forEach(function(item) {
                item.addEventListener('click', function() {
                    var categoryId = this.getAttribute('data-id');
                    document.getElementById('category_id').value = categoryId;
                });
            });

            document.querySelectorAll('.edit-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    var row = this.closest('tr');
                    var id = row.children[0].innerText.trim();
                    var title = row.children[1].innerText.trim();
                    var category = row.children[2].innerText.trim();
                    var createdAt = row.children[3].innerText.trim();
                    var imageSrc = row.children[4].querySelector('img').src;
                    var description = row.children[5].innerText.trim();
                    var short_description = row.children[6].innerText.trim();
                    var status = row.children[7].innerText.trim();

                    document.getElementById('id').value = id;
                    document.getElementById('title').value = title;
                    document.getElementById('category_id').value = category;
                    document.getElementById('description').value = description;
                    document.getElementById('short_description').value = short_description;
                    document.getElementById('status').value = status;
                    // For image preview, you might need additional logic to handle image display
                });
            });
        });