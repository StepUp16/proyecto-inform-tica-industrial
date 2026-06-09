<?php
// Validamos que vengan los datos desde el formulario del taller
if(isset($_POST["sell_id"]) && isset($_POST["nuevo_estado"])){
    
    $sell_id = $_POST["sell_id"];
    $nuevo_estado = $_POST["nuevo_estado"];

    // Ejecutamos la actualización directa usando la clase nativa del framework
    $sql = "UPDATE sell SET estado_produccion=\"$nuevo_estado\" WHERE id=$sell_id";
    Executor::doit($sql);

    // Si el estado es "Listo para Instalacion", opcionalmente podrías agregar lógica 
    // aquí para notificar a recepción, pero para el MVP con ocultarlo de la cola basta.

    // Preparamos el mensaje de éxito para que salte la alerta verde (SweetAlert)
    $_SESSION["success"] = "Orden ORD-$sell_id actualizada a: $nuevo_estado";

    // Redirigimos de vuelta a la pantalla del taller
    print "<script>window.location='index.php?view=taller';</script>";

} else {
    // Si alguien intenta entrar a la URL directo sin mandar el formulario
    $_SESSION["error"] = "Datos incompletos para actualizar el estado.";
    print "<script>window.location='index.php?view=taller';</script>";
}
?>