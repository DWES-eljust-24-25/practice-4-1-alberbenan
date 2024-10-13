<?php
//In this script, place the functions
session_start();

function validateFormData($data) {
    $errors = [];

    if (empty(trim($data['first_name']))) {
        $errors[] = "First name is required.";
    }

    if (empty(trim($data['surname']))) {
        $errors[] = "Surname is required.";
    }

    if (empty($data['title'])) {
        $data['title'] = "Mr.";
    }

    if (empty(trim($data['phone']))) {
        $errors[] = "Phone number is required.";
    } elseif (!preg_match("/^[0-9]{10}$/", $data['phone'])) {
        $errors[] = "Phone number must be 10 digits.";
    }

    if (empty(trim($data['email']))) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    return $errors;
}
?>
