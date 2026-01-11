<?php
header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'message' => 'Direct PHP working! ',
    'timestamp' => date('Y-m-d H: i:s')
]);
