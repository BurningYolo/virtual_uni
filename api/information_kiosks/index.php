<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

$query = "SELECT * FROM tbl_information_kiosks";
$result = $pdo->query($query);

$kiosks = $result->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($kiosks);
?>
