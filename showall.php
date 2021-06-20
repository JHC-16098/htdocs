<?php include("topbit.php");

$find_sql = "SELECT * FROM `game_details` ";
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
                <?php echo $find_rs['name']; ?> | Tags: <?php echo $find_rs['steamspy_tags']; ?> | <?php 
                    $pos_ratings = $find_rs['positive_ratings'];
                    $neg_ratings = $find_rs['negative_ratings'];
                    if($pos_ratings>$neg_ratings) {
                        echo ("Positive Reviews by ".($pos_ratings-$neg_ratings)." reviews");
                    }
                    elseif($pos_ratings<$neg_ratings){
                        echo ("Negative Reviews by ".($neg_ratings-$pos_ratings)." reviews");
                    }
                    else{
                        echo "Review Data Not Available";
                    }
                    ?> | Link: <a href="https://store.steampowered.com/app/<?php echo $find_rs['appid'];?>"><?php echo $find_rs['name'];?> on Steam</a>
               </div>
               <br />
               <?php 
            }
            while($find_rs=mysqli_fetch_assoc($find_query));
        }
    
    ?>

	
	</div> <!-- / main -->
			
<?php include("bottombit.php");