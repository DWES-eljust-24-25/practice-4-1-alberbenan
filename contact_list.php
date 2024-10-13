<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .edit {
            color: blue;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2 style="text-align: center;">Contact List</h2>

<?php
session_start();
$contacts = $_SESSION['contacts'] ?? []; // Usar la variable de sesión para obtener contactos

if (empty($contacts)) {
    echo "<p>No contacts found.</p>";
} else {
    echo "<table>";
    echo "<tr><th>ID</th><th>Title</th><th>Name</th><th>Surname</th><th>Phone</th><th>Email</th><th>Actions</th></tr>";
    
    foreach ($contacts as $contact) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($contact['id']) . "</td>";
        echo "<td>" . htmlspecialchars($contact['title']) . "</td>";
        echo "<td>" . htmlspecialchars($contact['name']) . "</td>";
        echo "<td>" . htmlspecialchars($contact['surname']) . "</td>";
        echo "<td>" . htmlspecialchars($contact['phone']) . "</td>";
        echo "<td>" . htmlspecialchars($contact['email']) . "</td>";
        echo "<td><a href='contact_form.php?id=" . htmlspecialchars($contact['id']) . "' class='edit'>Edit</a></td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>

<br>
<div style="text-align: center;">
    <a href="contact_form.php">Create New Contact</a>
</div>

</body>
</html>
