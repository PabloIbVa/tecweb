<?php
// Incluir el archivo de conexión a la base de datos
include_once __DIR__.'/database.php';

// Obtener el nombre del producto desde la solicitud GET
$name = $_GET['name'];

// Preparar la consulta SQL con una consulta preparada
$sql = "SELECT * FROM productos WHERE nombre = ?";
$stmt = $conexion->prepare($sql); // Usar $conexion en lugar de $conn
if ($stmt) {
    $stmt->bind_param("s", $name); // "s" indica que es un string
    $stmt->execute();
    $result = $stmt->get_result();

    // Preparar la respuesta
    $response = [];
    if ($result->num_rows > 0) {
        // El producto existe
        $response['existe'] = true;
    } else {
        // El producto no existe
        $response['existe'] = false;
    }

    // Devolver la respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($response);

    // Cerrar la consulta preparada
    $stmt->close();
} else {
    // Si hay un error en la preparación de la consulta
    $response = ['error' => 'Error al preparar la consulta'];
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Cerrar la conexión
$conexion->close();
?>