<?php
function sanitize($data) {
    return htmlspecialchars(trim($data));
}

$fullname = sanitize($_POST['fullname'] ?? '');
$email = sanitize($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';
$gender = sanitize($_POST['gender'] ?? '');
$hobbies = $_POST['hobbies'] ?? [];

$errors = [];


if (empty($fullname)) $errors[] = "Full Name is required.";
if (empty($email)) $errors[] = "Email is required.";
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid Email format.";

if (empty($password) || empty($confirm_password)) {
    $errors[] = "Both password fields are required.";
} elseif ($password !== $confirm_password) {
    $errors[] = "Passwords do not match.";
}

if (empty($gender)) $errors[] = "Gender is required.";
if (empty($hobbies)) $errors[] = "At least one hobby must be selected.";

if (!empty($errors)) {

    $query = http_build_query(['error' => implode(' ', $errors)]);
    header("Location: register.html?$query");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration Success</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card p-4 shadow-sm">
      <h2 class="mb-4 text-success">Registration Successful</h2>
      <ul class="list-group">
        <li class="list-group-item"><strong>Full Name:</strong> <?= $fullname ?></li>
        <li class="list-group-item"><strong>Email:</strong> <?= $email ?></li>
        <li class="list-group-item"><strong>Gender:</strong> <?= $gender ?></li>
        <li class="list-group-item"><strong>Hobbies:</strong> <?= implode(', ', array_map('sanitize', $hobbies)) ?></li>
      </ul>
    </div>
  </div>
</body>
</html>
