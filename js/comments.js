// Function to handle comment submission via AJAX
function ajaxSubmitComment() {
    const form = document.getElementById('comment-form');
    const formData = new FormData(form);

    fetch('ajax-handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const ajaxMessage = document.getElementById('ajaxMessage');

        if (data.status === 'success') {
            // Append the new comment to the comments section
            const commentsUl = document.getElementById('comments-ul');
            const newComment = document.createElement('li');
            newComment.innerHTML = data.html;
            commentsUl.insertBefore(newComment, commentsUl.firstChild);

            // Clear the form
            form.reset();

            ajaxMessage.innerHTML = '<p class="success-message">Comment submitted successfully!</p>';
        } else {
            ajaxMessage.innerHTML = '<p class="error-message">Error: ' + data.message + '</p>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('ajaxMessage').innerHTML = '<p class="error-message">An error occurred while submitting the comment. Please try again later.</p>';
    });
}
