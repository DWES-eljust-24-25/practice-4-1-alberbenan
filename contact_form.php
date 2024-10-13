<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        form {
            width: 580px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<h2 style="text-align: center;">Contact Form</h2>

<?php
session_start();
require 'functions.php';
$contacts = &$_SESSION['contacts']; 

$id = 0;
$title = "Mr.";
$first_name = "";
$surname = "";
$birth_date = "";
$phone = "";
$email = "";
$types = [];

// If there are no contacts, upload initial contacts
if (!isset($contacts)) {
    $contacts = require 'data.php'; // Load contacts from data.php file
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    foreach ($contacts as $contact) {
        if ($contact['id'] === $id) {
            $title = $contact['title'];
            $first_name = $contact['name'];
            $surname = $contact['surname'];
            $birth_date = $contact['birthdate'];
            $phone = $contact['phone'];
            $email = $contact['email'];
            if ($contact['favourite']) {
                $types[] = "Favorite";
            }
            if ($contact['important']) {
                $types[] = "Important";
            }
            if ($contact['archived']) {
                $types[] = "Archived";
            }
            break;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = validateFormData($_POST);

    if (empty($errors)) {
        // Update or add the contact
        $contactData = [
            'id' => $_POST['id'],
            'title' => $_POST['title'],
            'name' => $_POST['first_name'],
            'surname' => $_POST['surname'],
            'birthdate' => $_POST['birth_date'],
            'phone' => $_POST['phone'],
            'email' => $_POST['email'],
            'favourite' => in_array("Favorite", $_POST['type'] ?? []),
            'important' => in_array("Important", $_POST['type'] ?? []),
            'archived' => in_array("Archived", $_POST['type'] ?? [])
        ];

        if ($id === 0) {
            // Create new contact
            $contactData['id'] = count($contacts) + 1; // Asignar nuevo ID
            $contacts[] = $contactData;
        } else {
            // Update existing contact
            foreach ($contacts as &$contact) {
                if ($contact['id'] === $id) {
                    $contact = $contactData;
                    break;
                }
            }
        }

        header("Location: contact_list.php");
        exit;
    } else {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
}
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id; ?>" method="POST">
    <!-- ID -->
    <label for="id">ID</label>
    <input type="text" id="id" name="id" value="<?php echo $id; ?>">
    <br><br>
    <!-- Title -->
    <label for="title">Title</label>
    <div class="radio-group">
        <label><input type="radio" name="title" value="Mr." <?php if ($title === "Mr.") echo "checked"; ?>> Mr.</label>
        <label><input type="radio" name="title" value="Mrs." <?php if ($title === "Mrs.") echo "checked"; ?>> Mrs.</label>
        <label><input type="radio" name="title" value="Miss" <?php if ($title === "Miss") echo "checked"; ?>> Miss</label>
    </div>
    <br>
    <!-- First Name -->
    <label for="first_name">First Name</label>
    <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>">
    <!-- Surname -->
    <label for="surname">Surname</label>
    <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($surname); ?>">
    <br><br>
    <!-- Birth Date -->
    <label for="birth_date">Birth Date</label>
    <input type="date" id="birth_date" name="birth_date" value="<?php echo $birth_date; ?>">
    <br>
    <!-- Phone -->
    <label for="phone">Phone</label>
    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
    <br>
    <!-- Email -->
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
    <br><br>
    <!-- Type (Checkboxes) -->
    <label for="type">Type</label>
    <div class="checkbox-group">
        <label><input type="checkbox" name="type[]" value="Favorite" <?php if (in_array("Favorite", $types)) echo "checked"; ?>> Favorite</label><br>
        <label><input type="checkbox" name="type[]" value="Important" <?php if (in_array("Important", $types)) echo "checked"; ?>> Important</label><br>
        <label><input type="checkbox" name="type[]" value="Archived" <?php if (in_array("Archived", $types)) echo "checked"; ?>> Archived</label><br>
    </div>
    <br>
    <!-- Buttons -->
    <input type="submit" name="save" value="Save">
    <input type="submit" name="update" value="Update">
</form>
</body>
</html>
