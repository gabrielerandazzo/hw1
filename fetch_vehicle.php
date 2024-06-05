<?php
require_once 'dbconfig.php';

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

if (!empty($_GET['vehicle_id'])) {
    $vehicle_id = mysqli_real_escape_string($conn, $_GET['vehicle_id']);

    $fetchVehicleQuery = "SELECT * FROM vehicle WHERE id =" . $vehicle_id;

    $res = mysqli_query($conn, $fetchVehicleQuery);

    if ($res) {
        if (mysqli_num_rows($res) > 0) {
            $vehicleRow = mysqli_fetch_assoc($res);
            echo json_encode(['vehicle' => $vehicleRow]);
        } else {
            echo json_encode(['vehicle' => null, 'error' => 'Nessun veicolo trovato']);
        }
    } else {
        echo json_encode(['vehicle' => null, 'error' => mysqli_error($conn)]);
    }
}
mysqli_close($conn);
?>