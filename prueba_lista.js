document.addEventListener('DOMContentLoaded', function() {
    fetch('dni_guardados.json')
    .then(response => response.json())
    .then(data => {
        const dniList = document.getElementById('dni-list');
        dniList.innerHTML = ''; // Clear existing content

        if (data.length === 0) {
            dniList.innerHTML = '<li>No hay DNI guardados.</li>';
        } else {
            data.forEach(item => {
                const li = document.createElement('li');
                li.textContent = item.dni;
                dniList.appendChild(li);
            });
        }
    })
    .catch(error => {
        console.error('Error al cargar el archivo JSON:', error);
        const dniList = document.getElementById('dni-list');
        dniList.innerHTML = '<li>Error al cargar la lista de DNI.</li>';
    });
});
