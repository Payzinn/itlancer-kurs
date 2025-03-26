document.addEventListener('DOMContentLoaded', function(){
    const radios = document.getElementsByName('sphere');
    const container = document.getElementById('sphere_types_container');
    function showSphereTypes() {
         document.querySelectorAll('.sphere_types_group').forEach(group => group.style.display = 'none');
         let selected = document.querySelector('input[name="sphere"]:checked');
         if(selected) {
             container.style.display = 'block';
             let sphereId = selected.value;
             let group = document.querySelector('.sphere_types_group[data-sphere-id="'+ sphereId +'"]');
             if(group) {
                 group.style.display = 'flex';
             }
         } else {
             container.style.display = 'none';
         }
    }
    radios.forEach(radio => {
         radio.addEventListener('change', showSphereTypes);
    });
    showSphereTypes();
});