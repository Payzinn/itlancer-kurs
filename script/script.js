document.addEventListener('DOMContentLoaded', function() {
    var modal       = document.getElementById("myModal");
    var openBtn     = document.getElementById("sphere_modal");
    var closeBtn    = document.getElementsByClassName("close")[0];
    var backBtn     = document.getElementById("backBtn");
    var sphereBlocks = document.querySelectorAll('.sphere-block');

    if(!openBtn) return;

    openBtn.addEventListener('click', function(e) {
        e.preventDefault();
        modal.style.display = "block";
    });

    closeBtn.addEventListener('click', function() {
        modal.style.display = "none";
        resetSphereBlocks();
    });

    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
            resetSphereBlocks();
        }
    });

    sphereBlocks.forEach(function(block) {
        var heading = block.querySelector('h3');
        var ul = block.querySelector('ul');
        var liItems = ul.querySelectorAll('li');

        heading.addEventListener('click', function() {
            sphereBlocks.forEach(function(b) {
                b.style.display = 'none';
                b.querySelector('ul').style.display = 'none';
            });
            block.style.display = 'block';
            ul.style.display = 'block';
            backBtn.style.display = 'inline-block';
        });

        liItems.forEach(function(li) {
            li.addEventListener('click', function() {
                var stid   = this.getAttribute('data-stid');
                var stname = this.textContent;

                document.getElementById("chosen_sphere").value = stid;
                document.getElementById("sphere_chosen_name").textContent = "Вы выбрали: " + stname;

                modal.style.display = "none";
                resetSphereBlocks();
            });
        });
    });

    backBtn.addEventListener('click', function() {
        resetSphereBlocks();
    });

    function resetSphereBlocks() {
        sphereBlocks.forEach(function(block) {
            block.style.display = 'block';
            block.querySelector('ul').style.display = 'none';
        });
        backBtn.style.display = 'none';
    }
});
