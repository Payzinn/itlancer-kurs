document.addEventListener('DOMContentLoaded', function() {
    var modal       = document.getElementById("myModal");
    var openBtn     = document.getElementById("sphere_modal");
    var closeBtn    = document.getElementsByClassName("close")[0];
    var backBtn     = document.getElementById("backBtn");
    var sphereBlocks = document.querySelectorAll('.sphere-block');

    // Если на странице нет кнопки "Выбрать сферу", выходим
    if(!openBtn) return;

    // Открыть модалку
    openBtn.addEventListener('click', function(e) {
        e.preventDefault();
        modal.style.display = "block";
    });

    // Закрыть по крестику
    closeBtn.addEventListener('click', function() {
        modal.style.display = "none";
        resetSphereBlocks();
    });

    // Закрыть по клику вне окна
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
            resetSphereBlocks();
        }
    });

    // Для каждого блока (основная сфера)
    sphereBlocks.forEach(function(block) {
        var heading = block.querySelector('h3');
        var ul = block.querySelector('ul');
        var liItems = ul.querySelectorAll('li');

        // Клик по заголовку сферы => показываем только подтипы этой сферы
        heading.addEventListener('click', function() {
            // Скрываем все
            sphereBlocks.forEach(function(b) {
                b.style.display = 'none';
                b.querySelector('ul').style.display = 'none';
            });
            // Показываем только текущую
            block.style.display = 'block';
            ul.style.display = 'block';
            // Делаем видимой кнопку "Назад"
            backBtn.style.display = 'inline-block';
        });

        // Клик по конкретному подтипу
        liItems.forEach(function(li) {
            li.addEventListener('click', function() {
                var stid   = this.getAttribute('data-stid');
                var stname = this.textContent;

                // 1) Записываем ID в скрытое поле
                document.getElementById("chosen_sphere").value = stid;
                // 2) Показываем пользователю выбранное название
                document.getElementById("sphere_chosen_name").textContent = "Вы выбрали: " + stname;

                // 3) Закрываем модалку
                modal.style.display = "none";
                resetSphereBlocks();
            });
        });
    });

    // Кнопка "Назад" => возвращаемся к списку всех сфер
    backBtn.addEventListener('click', function() {
        resetSphereBlocks();
    });

    // Сброс отображения: все сферы показываются, списки скрыты, "Назад" скрыта
    function resetSphereBlocks() {
        sphereBlocks.forEach(function(block) {
            block.style.display = 'block';
            block.querySelector('ul').style.display = 'none';
        });
        backBtn.style.display = 'none';
    }
});
