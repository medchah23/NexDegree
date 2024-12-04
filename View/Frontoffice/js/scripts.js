window.addEventListener('DOMContentLoaded', event => {

    var navbarShrink = function () {
        const navbarCollapsible = document.body.querySelector('#mainNav');
        if (!navbarCollapsible) {
            return;
        }
        navbarCollapsible.classList.toggle('navbar-shrink', window.scrollY !== 0);
    };
    navbarShrink();

    window.addEventListener('scroll', navbarShrink);

    const mainNav = document.body.querySelector('#mainNav');
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            rootMargin: '0px 0px -40%',
        });
    };

    const navbarToggler = document.body.querySelector('.navbar-toggler');
    if (navbarToggler) {
        const responsiveNavItems = [].slice.call(document.querySelectorAll('#navbarResponsive .nav-link'));
        responsiveNavItems.forEach(function (responsiveNavItem) {
            responsiveNavItem.addEventListener('click', () => {
                if (window.getComputedStyle(navbarToggler).display !== 'none') {
                    navbarToggler.click();
                }
            });
        });
    }

    const createPostBtn = document.getElementById('createPostBtn');
    const postForm = document.getElementById('postForm');

    if (createPostBtn && postForm) {
        createPostBtn.addEventListener('click', function () {

            const isHidden = postForm.style.display === 'none' || postForm.style.display === '';
            postForm.style.display = isHidden ? 'block' : 'none';
        });
    }

}); 


function validatePostForm(event) {
    const postTitle = document.getElementById('postTitle');
    const postContent = document.getElementById('postContent');
    
    let title = postTitle.value.trim();
    let content = postContent.value.trim();

    
    if (title === "") {
        alert("Title is required.");
        event.preventDefault(); 
        postTitle.focus();
        return false;
    }
    if (title.length < 5) {
        alert("Title must be at least 5 characters long.");
        event.preventDefault();
        postTitle.focus();
        return false;
    }

    
    if (content === "") {
        alert("Content is required.");
        event.preventDefault(); 
        postContent.focus();
        return false;
    }
    if (content.length < 10) {
        alert("Content must be at least 10 characters long.");
        event.preventDefault();
        postContent.focus();
        return false;
    }

    return true;
}


document.addEventListener('DOMContentLoaded', function () {
    const postForm = document.querySelector('#postForm form');
    if (postForm) {
        postForm.addEventListener('submit', validatePostForm);
    }
});
