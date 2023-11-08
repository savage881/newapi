<html>
<head>
    <title></title>
    <style>
        #hello {
            width: 100px;
        }
    </style>
</head>
<body>
    <?php
        // Get the API response
        $response = file_get_contents('https://thefoodfone.com/api/alldatafetch.php');

        // Decode the JSON response into an array
        $videos = json_decode($response, true);

    
        $url = $videos[0]['video'];
        $urlposter = $videos[4]['poster'];
        $url1 = $videos[3]['video'];

        // Display the video player
        echo '<video width="640" height="360" controls autoplay>';
        echo '<source src="' . $url . '" type="video/mp4">';
        echo '</video>';
        echo '<img id="hello" src="' . $urlposter . '">';

        echo '<video width="640" height="360" controls autoplay>';
        echo '<source src="' . $url1 . '" type="video/mp4">';
        echo '</video>';
    ?>
</body>
</html>
