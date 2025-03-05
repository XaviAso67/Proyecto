// Función para validar el formulario
function validarFormulario(event) {
    event.preventDefault(); // Evita que el formulario se envíe antes de la validación

    // Obtener los valores de los campos
    const nombre = document.getElementById('nombre').value.trim();
    const email = document.getElementById('email').value.trim();
    const mensaje = document.getElementById('mensaje').value.trim();

    // Validación
    if (nombre === "") {
        alert("El nombre es obligatorio.");
        return false;
    }

    if (email === "") {
        alert("El correo electrónico es obligatorio.");
        return false;
    }

    // Validación de formato de correo electrónico (expresión regular simple)
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!emailRegex.test(email)) {
        alert("Por favor ingresa un correo electrónico válido.");
        return false;
    }

    if (mensaje === "") {
        alert("El mensaje es obligatorio.");
        return false;
    }

    // Si pasa todas las validaciones, enviar el formulario usando AJAX
    const formData = new FormData();
    formData.append("nombre", nombre);
    formData.append("email", email);
    formData.append("mensaje", mensaje);

    fetch('procesar_contacto.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Formulario enviado correctamente.");
            // Limpiar el formulario
            document.querySelector("form").reset();
        } else {
            alert("Hubo un error al enviar el formulario.");
        }
    })
    .catch(error => {
        alert("Error al enviar el formulario. Intenta nuevamente.");
        console.error(error);
    });
}

// Asignamos el evento de envío del formulario
document.querySelector("form").addEventListener("submit", validarFormulario);
