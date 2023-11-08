<?php
// Example code in play.php

$timestamp = $_GET['timestamp'];
header("Location: play_video.php?timestamp=" . $timestamp);
exit;
?>
