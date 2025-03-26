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

    function showNotification(message, type) {
        const notification = document.getElementById('notification');
        notification.textContent = message;
        notification.className = 'notification ' + type; 
        notification.style.right = '20px'; 

        setTimeout(function() {
            notification.style.right = '-300px'; 
        }, 3000);
    }

    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    const message = urlParams.get('message');
    if (status === 'success') {
        showNotification('Операция выполнена успешно!', 'success');
    } else if (status === 'error' && message) {
        showNotification('Ошибка: ' + message, 'error');
    }
});