<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

$query = "SELECT * FROM tbl_posts";
$result = $pdo->query($query);

$posts = $result->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($posts);
?>
