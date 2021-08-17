<?php include("topbit.php");

$id= $_GET['id'];
$find_sql = 
"SELECT * 
FROM `game_details`

INNER JOIN genre ON (game_details.GenreID = genre.genre_id)
INNER JOIN developer ON (game_details.devID = developer.devID)
INNER JOIN publisher ON (game_details.pubID = publisher.pubID)
INNER JOIN descriptions ON (game_details.appid = descriptions.appid)
WHERE game_details.appid = $id
";

$find_query = mysqli_query($dbconnect, $find_sql) or die(mysqli_error($dbconnect));
$find_rs = mysqli_fetch_assoc($find_query);
$count = mysqli_num_rows($find_query);

?>
			
	<div class="box main">
	<h2><div class="title_box"><?php echo $find_rs['name'] ?></div>     <a class="applink_a" href="https://store.steampowered.com/app/<?php echo $find_rs['appid'];?>"><i class="fab fa-steam"></i> STEAM</a></h2>

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
                    <?php
                     $pos_ratings = $find_rs['positive_ratings'];
                     $neg_ratings = $find_rs['negative_ratings'];
                     $num_ratings = $pos_ratings + $neg_ratings;
                     $pos_percent = ($pos_ratings/$num_ratings)*100;
                     ?>
                    <div class="review_box">
                    </h3><?php echo $num_ratings?> reviews</h3>
                    <br>

                    <progress class="review_bar" max="100" value=<?php echo $pos_percent?>><span></span></progress>
                    <br>
                    <br>
                    <div class="pos_reviews"> <?php echo $pos_ratings?> Positive </div> <div class="neg_reviews"> <?php echo $neg_ratings ?> Negative </div>
                    <?php 
                    /*
                        if($pos_percent<50) {
                            echo round((($neg_ratings/$num_ratings)*100))."% Negative"; 
                        }
                        elseif($pos_percent>=50) {
                            echo round($pos_percent)."% Positive";
                        }
                        */
                    ?>
                    
                    </div>
                    <br>
                    <br>

                <div class="description">
                <?php 
                
                $about = $find_rs['About'];
                $about = str_replace("â€”", "-", $about);
                echo str_replace("â€™", "'", $about);
                
                ?>
                </div>

                

                <?php
            }
            while($find_rs=mysqli_fetch_assoc($find_query));
        }
    
    ?>

	
	</div> <!-- / main -->
			
<?php include("bottombit.php");