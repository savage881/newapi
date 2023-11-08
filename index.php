<!DOCTYPE html>
<html>
<head>
    <title>Watch Video</title>
</head>
<body>
<?php
// Assuming you have already established a database connection
$host="localhost";
$username="root";
$password="";
$dbname="watch";


$conn = mysqli_connect($host, $username, $password,$dbname);
if(!$conn){
die("Connection failed:".mysqli_connect_error());
}

// Retrieve the video ID from the URL parameter
$videoId = $_GET['video_id'];

// Query the database to fetch video information
$query = "SELECT * FROM videos WHERE video_id = ?";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "s", $videoId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

// Display video player, title, and description
$videoUrl = $row['video_url'];
$title = $row['title'];
$description = $row['description'];

echo '<h2>' . $title . '</h2>';
echo '<p>' . $description . '</p>';

echo '<video controls>';
echo '<source src="' . $videoUrl . '" type="video/mp4">';
echo '</video>';


$userProgress = getUserProgress($userId, $videoId); // Your custom function to fetch user progress

// Output JavaScript to set the video player's time marker to the user's progress
echo '<script>';
echo 'var video = document.querySelector("video");';
echo 'video.addEventListener("loadedmetadata", function() {';
echo '    video.currentTime = ' . $userProgress . ';';
echo '});';
echo '</script>';

// Close the database connection
mysqli_close($connection);
?>
</body>
</html>
