 const dropdownBtns = document.querySelectorAll('.dropdown-btn');

    dropdownBtns.forEach(btn => {
    btn.addEventListener('click', function () {
        const dropdownContent = this.nextElementSibling;

        // Toggle dropdown visibility
        if (dropdownContent.style.display === 'block') {
            dropdownContent.style.display = 'none';
        } else {
            dropdownContent.style.display = 'block';
        }

        // Toggle the chevron icon direction
        const chevron = this.querySelector('.bi-chevron-down');
        if (chevron) {
            chevron.classList.toggle('bi-chevron-up');
        }
    });
});
