<form method="POST" action="welcome.php">
    <input type="text" name="q" placeholder="Search...">
    <button type="submit">Search</button>
</form>
<?php

if(isset($_POST['q'])){
  $search_query = $_POST['q'];
  $api_url = "https://thefoodfone.com/api/alldatafetch.php/?q=". urlencode($search_query);
  $api_response = file_get_contents($api_url);
  $result = json_decode($api_response, true);
  if($result){
    foreach($result as $item){
      $poster = $item['poster'];
      $description = $item['overview'];
    
      echo '<div class="result">';
      echo '<a href="videos.php?poster=' . urlencode($poster) . '"><img id="hello" src="' . htmlspecialchars($poster, ENT_QUOTES) . '"></a>';
      echo '<p>'.$description.'</p>';
      echo '</div>';
    }
  } else {
    echo "No results found.";
  }
}
?>
