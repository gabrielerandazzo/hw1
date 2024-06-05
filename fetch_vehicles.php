<?php
require_once 'dbconfig.php';
$response = array(
    'data_type' => '',
    'data' => array()
);

if (isset($_GET['request'])) {
    $requestType = $_GET['request'];

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

    if ($requestType == 'brand') {
        $query = "SELECT DISTINCT brand FROM vehicle";
    } elseif ($requestType == 'model' && isset($_GET['brand'])) {
        $brand = mysqli_real_escape_string($conn, $_GET['brand']);
        $query = "SELECT DISTINCT model FROM vehicle WHERE brand = '$brand'";
    } elseif ($requestType == 'version' && isset($_GET['brand']) && isset($_GET['model'])) {
        $brand = mysqli_real_escape_string($conn, $_GET['brand']);
        $model = mysqli_real_escape_string($conn, $_GET['model']);
        $query = "SELECT id, version FROM vehicle WHERE brand = '$brand' AND model = '$model'";
    } else {
        echo json_encode($response);
        mysqli_close($conn);
        exit;
    }

    $res = mysqli_query($conn, $query);

    if ($res) {
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {

                if ($requestType == 'brand') {

                    $response['data'][] = $row['brand'];
                } elseif ($requestType == 'model') {

                    $response['data'][] = $row['model'];
                } elseif ($requestType == 'version') {

                    $response['data'][] = array(
                        'id' => $row['id'],
                        'version' => $row['version']
                    );

                }
            }
        }
        $response['data_type'] = $requestType;
    }

    mysqli_close($conn);
    echo json_encode($response);
}
?>