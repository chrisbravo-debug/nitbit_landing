<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $nombre = strip_tags(trim($_POST["nombre"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $mensaje = strip_tags(trim($_POST["mensaje"]));

    // **MODIFICA ESTAS LÍNEAS**
    $destinatario = "demian.perez@nitbit.mx"; // El email donde quieres recibir los mensajes
    $asunto = "Nuevo mensaje de contacto de $nombre";

    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($mensaje) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Enviar una respuesta de error si algo falla
        http_response_code(400);
        echo "Por favor, completa el formulario y vuelve a intentarlo.";
        exit;
    }

    // Construir el cuerpo del correo
    $contenido = "Nombre: $nombre\n";
    $contenido .= "Email: $email\n\n";
    $contenido .= "Mensaje:\n$mensaje\n";

    // Construir las cabeceras del correo
    $cabeceras = "From: $nombre <$email>";

    // Enviar el correo
    if (mail($destinatario, $asunto, $contenido, $cabeceras)) {
        // Si se envía correctamente, redirigir a una página de éxito (opcional)
        header("Location: gracias.html"); // Crea una página llamada gracias.html
        exit;
    } else {
        // Si falla el envío
        http_response_code(500);
        echo "Oops! Algo salió mal y no pudimos enviar tu mensaje.";
    }

} else {
    // Si alguien intenta acceder al script directamente
    http_response_code(403);
    echo "Hubo un problema con tu envío, por favor intenta de nuevo.";
}
?>