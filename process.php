<?php
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}


$errors = [];
$success = "";
$submittedData = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $fullname = sanitize_input($_POST["fullname"] ?? '');
    $email = sanitize_input($_POST["email"] ?? '');
    $phone = sanitize_input($_POST["phone"] ?? '');
    $message = sanitize_input($_POST["message"] ?? '');

    
    if (empty($fullname)) {
        $errors[] = "Full Name is required.";
    }

    if (empty($email)) {
        $errors[] = "Email Address is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid Email Address.";
    }

    if (empty($phone)) {
        $errors[] = "Phone Number is required.";
    } elseif (!preg_match('/^\+?\d{7,15}$/', $phone)) {
        $errors[] = "Invalid Phone Number.";
    }

    if (empty($message)) {
        $errors[] = "Message is required.";
    }

    
    if (empty($errors)) {
        $submittedData = [
            "Full Name" => $fullname,
            "Email Address" => $email,
            "Phone Number" => $phone,
            "Message" => $message
        ];

        $success = "Thank you! Your message has been submitted successfully.";
    }
}
?>