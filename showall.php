<?php include("topbit.php");

$find_sql = "SELECT * FROM `game_details`
JOIN genre ON (game_details.GenreID = genre.genre_id)
JOIN developer ON (game_details.devID = developer.devID)
JOIN publisher ON (game_details.pubID = publisher.pubID)
JOIN descriptions ON (game_details.appid = descriptions.appid)
LIMIT 25
";

$find_query = mysqli_query($dbconnect, $find_sql);
$find_rs = mysqli_fetch_assoc($find_query);
$count = mysqli_num_rows($find_query);

?>
			
	<div class="box main">
	<h2>Results</h2>

    <?php 
    
        if($count < 1) {
            ?>
            
            <div class="error">
                Sorry! There are no results that match your search.
            </div>

            <?php
        }

        else {
            do
            {
                ?>
                <div class="results">
                    <h2><?php echo $find_rs['name']; ?></h2>
                    <div class="tags"> 
                    <?php echo "Developer: ".$find_rs['developer']; ?>
                    </div>
                    <div class="tags">
                    <?php echo "Publisher: ".$find_rs['publisher']; ?>
                    </div>
                    <br>
                    <br>

                <?php 

                    $tags = $find_rs['steamspy_tags'];
                    $tag_array = explode(";", $tags);
                    //$num_tags = sizeof($tag_array);
                    foreach($tag_array as $tag) {
                        ?>
                        <div class="tags">
                            <?php echo $tag; ?>
                        </div>
                        <?php
                    }
                    
                
                ?>

                <?php
                
                    $platforms = $find_rs['platforms'];
                    
                    if(str_contains($platforms, 'windows')) {
                        $platforms = str_replace("windows", "<i class=\"fab fa-windows\"></i>", $platforms);
                    } 
                    if(str_contains($platforms, 'mac')) {
                        $platforms = str_replace("mac", "<i class=\"fab fa-apple\"></i>", $platforms);
                    } 
                    if(str_contains($platforms, 'linux')) {
                        $platforms = str_replace("linux", "<i class=\"fab fa-linux\"></i>", $platforms);
                    } 
                    
                    $platform_array = explode(";", $platforms);
                    foreach ($platform_array as $platform) {
                        ?>
                        <div class="tags">
                            <?php echo $platform; ?>
                        </div>
                        <?php
                    }
                    //echo "[ ".str_replace(";", " ]   [ ", $platforms)." ]";
                ?> 
                <br> 
                <br>
                <?php 
                    $pos_ratings = $find_rs['positive_ratings'];
                    $neg_ratings = $find_rs['negative_ratings'];
                    $num_ratings = $pos_ratings + $neg_ratings;
                    if($pos_ratings>$neg_ratings) {
                        ?>
                        <div class="pos_reviews">
                        <?php echo (round(($pos_ratings/$num_ratings)*100)."% Positive Reviews"); ?>
                        </div>
                        <?php

                    }
                    elseif($pos_ratings<$neg_ratings){
                        ?>
                        <div class="neg_reviews">
                        <?php echo (round(($neg_ratings/$num_ratings)*100)."% Negative Reviews"); ?>
                        </div>
                        <?php

                    }
                    elseif($num_ratings == 0){
                        ?>
                        <div class="no_reviews">
                        <?php echo "No Reviews"; ?>
                        </div>
                        <?php
                    }
                    else{
                        ?>
                        <div class="no_reviews">
                        <?php echo "Review Data Not Available"; ?>
                        </div>
                        <?php
                    }
                    ?> 
                    
                    <br>
                    <br>
                    
                   <a class="applink_a" href="https://store.steampowered.com/app/<?php echo $find_rs['appid'];?>"><i class="fab fa-steam"></i> STEAM</a>
                   <br>
                   <br>
                   <div class="description">
                   <?php 
                   
                   $about = $find_rs['About'];
                   echo str_replace("â€™", "'", $about);
                   
                   ?>
                   </div>
                   
               </div>
               <br />

               <?php 
            }
            while($find_rs=mysqli_fetch_assoc($find_query));
        }
    
    ?>

	
	</div> <!-- / main -->
			
<?php include("bottombit.php");