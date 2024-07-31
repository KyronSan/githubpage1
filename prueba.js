document.getElementById('dni-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const dni = document.getElementById('dni').value;
    if (!dni) {
        document.getElementById('message').textContent = 'Por favor, ingrese un DNI válido.';
        return;
    }

    const dniData = { dni: dni };

    fetch('guardar_dni.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dniData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('message').textContent = 'DNI guardado exitosamente';
        } else {
            document.getElementById('message').textContent = 'Error al guardar el DNI';
        }
    })
    .catch(error => {
        document.getElementById('message').textContent = 'Error al guardar el DNI';
    });
});
