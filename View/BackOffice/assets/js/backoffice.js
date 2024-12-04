function confirmDelete(event) {
    if (!confirm("Are you sure you want to delete this post? This action cannot be undone.")) {
        event.preventDefault();
    }
}

function toggleFormVisibility(formId) {
    const form = document.getElementById(formId);
    if (form) {
        form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
    }
}

function validateForm(event) {
    const title = document.getElementById('title');
    const content = document.getElementById('content');

    if (!title.value.trim()) {
        alert("Title is required!");
        event.preventDefault();
        return;
    }

    if (!content.value.trim()) {
        alert("Content is required!");
        event.preventDefault(); 
        return;
    }
}


function showMessage(type, message) {
    const messageContainer = document.getElementById('messageContainer');
    if (messageContainer) {
        messageContainer.innerHTML = `
            <div class="${type}">
                ${message}
                <span class="close" onclick="this.parentElement.style.display='none';">&times;</span>
            </div>`;
        messageContainer.style.display = 'block';
        setTimeout(() => {
            messageContainer.style.display = 'none';
        }, 5000); // Extended duration
    }
}

function initializeEventListeners() {
    const deleteLinks = document.querySelectorAll('.delete-post');
    deleteLinks.forEach(link => {
        link.addEventListener('click', confirmDelete);
    });

    const postForm = document.getElementById('postForm');
    if (postForm) {
        postForm.addEventListener('submit', validateForm);
    }

    const addPostButton = document.getElementById('addPostButton');
    if (addPostButton) {
        addPostButton.addEventListener('click', function () {
            toggleFormVisibility('addPostForm');
        });
    }

    const editPostButton = document.getElementById('editPostButton');
    if (editPostButton) {
        editPostButton.addEventListener('click', function () {
            toggleFormVisibility('editPostForm');
        });
    }
}

document.addEventListener('DOMContentLoaded', function () {
    initializeEventListeners();

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('message')) {
        const message = urlParams.get('message');
        const messageType = urlParams.get('messageType');
        showMessage(messageType, message);
    }
});
