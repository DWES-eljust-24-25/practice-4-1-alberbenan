<?php
//This script is to show the validated data from contact.php
session_start();
require 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = validate_form_data($_POST);

    if (empty($errors)) {
        $_SESSION['contact_data'] = $_POST;
        header("Location: checkdata.php");
        echo "<p style='color:red;'>VALIDATE OK</p>";        
        exit;
    } else {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
}
?>
