<?php
// Establecer la cabecera para que se devuelvan respuestas en formato JSON
header('Content-Type: application/json');

// Verificar si los datos fueron enviados mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';

    // Validaciones simples
    if (empty($nombre) || empty($email) || empty($mensaje)) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
        exit;
    }

    // Validación de formato de correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'El correo electrónico no es válido.']);
        exit;
    }

    // Configuración del correo
    $to = 'contacto@miempresa.com'; // Dirección de correo de destino
    $subject = 'Nuevo mensaje de contacto'; // Asunto del correo

    // Crear el contenido del mensaje en texto plano
    $message = "Nombre: $nombre\n";
    $message .= "Correo Electrónico: $email\n";
    $message .= "Mensaje: $mensaje\n";

    // Cabeceras del correo
    $headers = 'From: ' . $email . "\r\n" . // El correo del usuario que envía el mensaje
               'Reply-To: ' . $email . "\r\n" . // Dirección de respuesta
               'X-Mailer: PHP/' . phpversion();

    // Enviar el correo
    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(['success' => true, 'message' => 'Formulario enviado correctamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Hubo un error al enviar el formulario.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
?>
