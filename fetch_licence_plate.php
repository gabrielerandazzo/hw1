<?php
require_once 'dbconfig.php';

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

if (!empty($_GET['licence_plate'])) {
    $licencePlate = mysqli_real_escape_string($conn, $_GET['licence_plate']);

    $fetchNumberPlateQuery = "SELECT id_vehicle FROM licence_plates WHERE licence_plate = '$licencePlate'";
    $res = mysqli_query($conn, $fetchNumberPlateQuery);

    if ($res) {
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $vehicle_id = $row['id_vehicle'];

            $fetchVehicleQuery = "SELECT * FROM vehicle WHERE id = $vehicle_id";
            $result = mysqli_query($conn, $fetchVehicleQuery);

            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    $vehicleRow = mysqli_fetch_assoc($result);
                    echo json_encode(['vehicle' => $vehicleRow]);
                } else {
                    echo json_encode(['vehicle' => null, 'error' => 'Nessun veicolo trovato']);
                }
            } else {
                echo json_encode(['vehicle' => null, 'error' => mysqli_error($conn)]);
            }
        } else {
            echo json_encode(['vehicle' => null, 'error' => 'Nessuna targa trovata']);
        }
    } else {
        echo json_encode(['vehicle' => null, 'error' => mysqli_error($conn)]);
    }
}
mysqli_close($conn);
?>