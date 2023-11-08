<?php
require_once 'vendor/autoload.php';

use vendor\kreait\firebasep\src\Firebase\Factory;



$firebase = (new Factory)->create();
$database = $firebase->getDatabase();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "google_login";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
    echo connect;
}

// Define a Firebase reference
$ref = $database->getReference('users');

// Listen for Firebase events
$ref->on('value', function ($snapshot) use ($conn) {
    $data = $snapshot->getValue();

    // Loop through Firebase data and sync with MySQL
    foreach ($data as $userId => $userData) {
        $name = $userData['name'];
        $email = $userData['email'];

        // Insert or update MySQL record
        $sql = "REPLACE INTO users (id, name, email) VALUES ('$userId', '$name', '$email')";
        if ($conn->query($sql) === TRUE) {
            echo "Record synced successfully";
        } else {
            echo "Error syncing record: " . $conn->error;
        }
    }
});
$conn->close();
?>
