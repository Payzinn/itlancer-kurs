document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.portfolio_link').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var modalId = this.getAttribute('href').replace('#', '') + 'Modal';
            document.getElementById(modalId).style.display = 'block';
        });
    });

    document.querySelectorAll('.close').forEach(function(closeBtn) {
        closeBtn.addEventListener('click', function() {
            this.closest('.modal').style.display = 'none';
        });
    });

    window.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    });
});