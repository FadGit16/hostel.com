<?php
header('Content-Type: application/json');

include('db_connection.php');

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'];

if (!$email) {
  echo json_encode(['success' => false, 'message' => 'Invalid User email']);
  exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);  
$user = $stmt->fetch();

if (!$user) {
  echo json_encode(['success' => false, 'message' => 'User not found']);
  exit;
}

if ($user['status'] == 'outside') {
  $stmt = $pdo->prepare("UPDATE users SET status = 'inside' WHERE email = ?");
  $stmt->execute([$email]);  // Use $email instead of $userId
  echo json_encode(['success' => true, 'action' => 'entered']);
} else {
  // Update user status to 'outside'
  $stmt = $pdo->prepare("UPDATE users SET status = 'outside' WHERE email = ?");
  $stmt->execute([$email]);  // Use $email instead of $userId
  echo json_encode(['success' => true, 'action' => 'exited']);
}
?>
