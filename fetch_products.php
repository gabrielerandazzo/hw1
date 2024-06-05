<?php
require_once 'dbconfig.php';

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));


if (isset($_GET['keyword'])) {
    $keyword = mysqli_real_escape_string($conn, $_GET['keyword']);
} else {
    $keyword = '';
}

if (isset($_GET['page'])) {
    $page = (int) $_GET['page'];
} else {
    $page = 1;
}

if (isset($_GET['limit'])) {
    $limit = (int) $_GET['limit'];
} else {
    $limit = 10;
}

$offset = ($page - 1) * $limit;
$sql = "";

if (isset($_GET['vehicle_id'])) {
    $vehicle_id = mysqli_real_escape_string($conn, $_GET['vehicle_id']);

    if ($vehicle_id) {
        $sql = "SELECT p.* 
        FROM products p
        INNER JOIN compatibility c ON p.id = c.parts_id
        WHERE (p.name LIKE '%" . $keyword . "%' OR p.product_number LIKE '%" . $keyword . "%')
        AND c.vehicle_id = '" . $vehicle_id . "'
        LIMIT $limit OFFSET $offset";
    }

} else {
    $sql = "SELECT * FROM products WHERE name LIKE '%" . $keyword . "%' OR product_number LIKE '%" . $keyword . "%' LIMIT " . $limit . " OFFSET " . $offset;
}

$result = mysqli_query($conn, $sql);

$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $row['details'] = json_decode($row['details'], true);
    $products[] = $row;
}

$totalSql = "SELECT COUNT(*) AS total FROM products WHERE name LIKE '%$keyword%' OR product_number LIKE '%$keyword%'";
$totalResult = mysqli_query($conn, $totalSql);
$totalRow = mysqli_fetch_assoc($totalResult);
$total = $totalRow['total'];

echo json_encode(['products' => $products, 'total' => $total]);
mysqli_close($conn);
?>