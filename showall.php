<?php include("topbit.php"); 
$platform_link = $_GET['platforms'];
$page = $_GET['page'];
if(empty($page)){
    $page = 0;
}
$extraVars = "";
$platform_t = $_GET['platforms'];
$search = $_GET['search'];
$sort_field = $_GET['s_column'];
$sort_type = $_GET['s_order'];
$s_c_text = strval($sort_field);
$s_msg = $_GET['s_msg'];
$s_o_text = strval($sort_type);
$tag = $_GET['tag'];
$tag_message = $_GET['message'];
$id = 0;
    foreach($_GET AS $key=>$value) {
        $extraVars .= '<input type="hidden" name="'.$key.'" value="'.$value.'" />';
    }

$find_sql = "SELECT *, ROUND(positive_ratings/(positive_ratings + negative_ratings)*100.0) AS positive_percentage, (positive_ratings + negative_ratings) AS num_ratings FROM `game_details`  
INNER JOIN genre ON (game_details.GenreID = genre.genre_id)
INNER JOIN developer ON (game_details.devID = developer.devID)
INNER JOIN publisher ON (game_details.pubID = publisher.pubID)
WHERE steamspy_tags LIKE '%$tag%' AND name LIKE '%$search%' AND platforms LIKE '%$platform_t%'
ORDER BY $sort_field $sort_type
LIMIT $page, 25
";
$count_sql = "SELECT *, ROUND(positive_ratings/(positive_ratings + negative_ratings)*100.0) AS positive_percentage, (positive_ratings + negative_ratings) AS num_ratings FROM `game_details`  
INNER JOIN genre ON (game_details.GenreID = genre.genre_id)
INNER JOIN developer ON (game_details.devID = developer.devID)
INNER JOIN publisher ON (game_details.pubID = publisher.pubID)
WHERE steamspy_tags LIKE '%$tag%' AND name LIKE '%$search%' AND platforms LIKE '%$platform_t%'
ORDER BY $sort_field $sort_type";

$find_rows = mysqli_query($dbconnect, $count_sql) or die(mysqli_error($dbconnect));
$find_query = mysqli_query($dbconnect, $find_sql) or die(mysqli_error($dbconnect));
$find_rs = mysqli_fetch_assoc($find_query);
$count = mysqli_num_rows($find_rows);

?>
			
	<div class="box main">
    
	<h2>Results</h2>
    <form name="search" action="showall.php" onsubmit="return validateSearch()" method="get">
    <?php echo $extraVars;?>
		Search: <input class="tags" type="text" value="<?php echo $search?>" name="search">
		<input class="taglink" value="🔎" type="submit">
		</form>
        <br>
        <br>
    <div class="tags">
    <?php echo str_replace("'", "", $tag_message) ?>
    </div>
    <div class="tags">
    
    
        Platform: <?php 

        $platform_link_msg = $platform_link;

        if(str_contains($platform_link_msg, 'windows')) {
            $platform_link_msg = str_replace("windows", "<i class=\"fab fa-windows\"></i>", $platform_link_msg);
            
        } 
        if(str_contains($platform_link_msg, 'mac')) {
            $platform_link_msg = str_replace("mac", "<i class=\"fab fa-apple\"></i>", $platform_link_msg);
            
        } 
        if(str_contains($platform_link_msg, 'linux')) {
            $platform_link_msg = str_replace("linux", "<i class=\"fab fa-linux\"></i>", $platform_link_msg);
            
        } 
        
        echo $platform_link_msg ?>
    
    
    </div>
    <div class="dropdown">
    <button onclick="myFunction()" class="dropbtn">Sort by: <?php echo $s_msg ?></button>
    <div id="myDropdown" class="dropdown-content">
        <a href="showall.php?tag=<?php echo $tag ?>&message=Filtering by: <?php echo $tag ?>&s_column=name&s_order=ASC&s_msg=Name A -> Z&search=<?php echo $search?>&platforms=<?php echo $platform_link ?>&page=<?php echo $page ?>">Name A -> Z</a>
        <a href="showall.php?tag=<?php echo $tag ?>&message=Filtering by: <?php echo $tag ?>&s_column=name&s_order=DESC&s_msg=Name Z -> A&search=<?php echo $search?>&platforms=<?php echo $platform_link ?>&page=<?php echo $page ?>">Name Z -> A</a>
        <a href="showall.php?tag=<?php echo $tag ?>&message=Filtering by: <?php echo $tag ?>&s_column=price&s_order=DESC&s_msg=Name Price High -> Low&search=<?php echo $search?>&platforms=<?php echo $platform_link ?>&page=<?php echo $page ?>">Price High -> Low</a>
        <a href="showall.php?tag=<?php echo $tag ?>&message=Filtering by: <?php echo $tag ?>&s_column=price&s_order=ASC&s_msg=Name Price Low -> High&search=<?php echo $search?>&platforms=<?php echo $platform_link ?>&page=<?php echo $page ?>">Price Low -> High</a>
        <a href="showall.php?tag=<?php echo $tag ?>&message=Filtering by: <?php echo $tag ?>&s_column=positive_percentage DESC,&s_order=num_ratings DESC&s_msg=Reviews High -> Low&search=<?php echo $search?>&platforms=<?php echo $platform_link ?>&page=<?php echo $page ?>">Reviews High -> Low</a>
        <a href="showall.php?tag=<?php echo $tag ?>&message=Filtering by: <?php echo $tag ?>&s_column=positive_percentage ASC,&s_order=num_ratings DESC&s_msg=Reviews Low -> High&search=<?php echo $search?>&platforms=<?php echo $platform_link ?>&page=<?php echo $page ?>">Reviews Low -> High</a>
        <a href="showall.php?tag=<?php echo $tag ?>&message=Filtering by: <?php echo $tag ?>&s_column=num_ratings&s_order=DESC&s_msg=Popularity&search=<?php echo $search?>&platforms=<?php echo $platform_link ?>&page=<?php echo $page ?>">Popularity</a>
    </div>
    </div>
    <a class="tags" href="showall.php?message=All Games&s_column=appid&s_order=ASC&page=<?php echo $page ?>">Clear All</a> 
    <br>
    <br>
    <?php $page_platform = $platform_link; ?>
    <a class="taglink" href="showall.php?tag=<?php echo $tag ?>&message=Filtering by: <?php echo $tag ?>&s_column=<?php echo $sort_field?>&s_order=<?php echo $sort_type ?>&s_msg=<?php echo $s_msg ?>&search=<?php echo $search ?>&platforms=<?php echo $page_platform ?>&page=0"><i class="fas fa-angle-double-left"></i></a> 
    <a class="taglink" href="showall.php?tag=<?php echo $tag ?>&message=Filtering by: <?php echo $tag ?>&s_column=<?php echo $sort_field?>&s_order=<?php echo $sort_type ?>&s_msg=<?php echo $s_msg ?>&search=<?php echo $search ?>&platforms=<?php echo $page_platform ?>&page=<?php 

    if($page == 0){
        echo $page;
    } 
    else {
        echo ($page - 25);
    }
    ?>"><i class="fas fa-angle-left"></i></a> 
    <div class="tags"><?php echo ($page/25 + 1) ?></div> 
    <a class="taglink" href="showall.php?tag=<?php echo $tag ?>&message=Filtering by: <?php echo $tag ?>&s_column=<?php echo $sort_field?>&s_order=<?php echo $sort_type ?>&s_msg=<?php echo $s_msg ?>&search=<?php echo $search ?>&platforms=<?php echo $page_platform ?>&page=<?php
        
        if(($page+25) >= $count) {
            echo ($count-25);
        }
        else{
            echo ($page + 25);
        }
        
    
    ?>"><i class="fas fa-angle-right"></i></a>
    <a class="taglink" href="showall.php?tag=<?php echo $tag ?>&message=Filtering by: <?php echo $tag ?>&s_column=<?php echo $sort_field?>&s_order=<?php echo $sort_type ?>&s_msg=<?php echo $s_msg ?>&search=<?php echo $search ?>&platforms=<?php echo $page_platform ?>&page=<?php echo ($count - 25)?>"><i class="fas fa-angle-double-right"></i></a> 
    <br>
    <br>
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
                    <a class="deslink_a" href="showdescription.php?id=<?php echo $find_rs['appid'] ?>"><?php echo str_replace('Â®', '®', $find_rs['name']); ?></a>
                    <br>
                    <br>
                    <div class="tags">
                        <?php echo "$".$find_rs['price']; ?>
                    </div>
                    <br>
                    <br>
                    <div class="tags"> 
                    <?php echo "Developed by ".$find_rs['developer']; ?>
                    </div>
                    <div class="tags">
                    <?php echo "Published by ".$find_rs['publisher']; ?>
                    </div>
                    <br>
                    <br>

                <?php 

                    $tags = $find_rs['steamspy_tags'];
                    $tag_array = explode(";", $tags);
                    //$num_tags = sizeof($tag_array);
                    foreach($tag_array as $tag_link) {
                        ?>    
                            <a class="taglink" href="showall.php?tag=<?php echo $tag_link ?>&message=Filtering by: <?php echo $tag_link ?>&s_column=<?php echo $s_c_text ?>&s_order=<?php echo $s_o_text ?>&s_msg=<?php echo $s_msg ?>&search=<?php echo $search?>&platforms=<?php echo $platform_link ?>"><?php echo $tag_link; ?></a>
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
                        $platform_link = "";
                        if(str_contains($platform, "windows")) {
                            $platform_link="windows";
                        }
                        if(str_contains($platform, "apple")) {
                            $platform_link="mac";
                        }
                        if(str_contains($platform, "linux")) {
                            $platform_link="linux";
                        }

                    ?>
                        <a class="taglink" href="showall.php?tag=<?php echo $tag ?>&message=Filtering by: <?php echo $tag ?>&s_column=<?php echo $s_c_text ?>&s_order=<?php echo $s_o_text ?>&s_msg=<?php echo $s_msg ?>&search=<?php echo $search?>&platforms=<?php echo $platform_link ?>"><?php echo $platform ?></a>
                        <?php
                    }
                    //echo "[ ".str_replace(";", " ]   [ ", $platforms)." ]";
                ?> 
 
                <?php 
                    $pos_ratings = $find_rs['positive_ratings'];
                    $neg_ratings = $find_rs['negative_ratings'];
                    $num_ratings = $pos_ratings + $neg_ratings;
                    /*
                    if(($pos_ratings/$num_ratings)*100>65) {
                        ?>
                        <div class="pos_reviews">
                        <?php echo (round(($pos_ratings/$num_ratings)*100)."% Positive Reviews"); ?>
                        </div>
                        <?php

                    }
                    elseif(($pos_ratings/$num_ratings)*100<35){
                        ?>
                        <div class="neg_reviews">
                        <?php echo (round(($neg_ratings/$num_ratings)*100)."% Negative Reviews"); ?>
                        </div>
                        <?php
                    }
                    elseif((($pos_ratings/$num_ratings)*100>35) && (($pos_ratings/$num_ratings)*100<65)) {
                        
                        if($pos_ratings>$neg_ratings) {
                            ?>
                            <div class="mix_reviews">
                            <?php echo("Mixed Reviews - ".(round(($pos_ratings/$num_ratings)*100)."% Positive")); ?>
                            </div>
                            <?php
                        }
                        elseif($neg_ratings>$neg_ratings) {
                            ?>
                            <div class="mix_reviews">
                            <?php
                            echo ("Mixed Reviews - ".(round(($neg_ratings/$num_ratings)*100)."% Negative"));
                            ?>
                            </div>
                            <?php
                        }
                        ?>
                        <?php
                    }
                    */
                    
                    $pos_percent = ($pos_ratings/$num_ratings)*100;
                    ?>
        
                    
                    


<?php
                    /*
                    if($num_ratings == 0){
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
                    */
                    ?> 


                   
               </div>
                    <br>
               <?php 
            }
            while($find_rs=mysqli_fetch_assoc($find_query));
        }
    
    ?>

    <a class="taglink" href="showall.php?tag=<?php echo $tag ?>&message=Filtering by: <?php echo $tag ?>&s_column=<?php echo $sort_field?>&s_order=<?php echo $sort_type ?>&s_msg=<?php echo $s_msg ?>&search=<?php echo $search ?>&platforms=<?php echo $page_platform ?>&page=0"><i class="fas fa-angle-double-left"></i></a> 
    <a class="taglink" href="showall.php?tag=<?php echo $tag ?>&message=Filtering by: <?php echo $tag ?>&s_column=<?php echo $sort_field?>&s_order=<?php echo $sort_type ?>&s_msg=<?php echo $s_msg ?>&search=<?php echo $search ?>&platforms=<?php echo $page_platform ?>&page=<?php 
    if($page == 0){
        echo $page;
    } 
    else {
        echo ($page - 25);
    }
    ?>"><i class="fas fa-angle-left"></i></a> 
    <div class="tags"><?php echo ($page/25 + 1) ?></div> 
    <a class="taglink" href="showall.php?tag=<?php echo $tag ?>&message=Filtering by: <?php echo $tag ?>&s_column=<?php echo $sort_field?>&s_order=<?php echo $sort_type ?>&s_msg=<?php echo $s_msg ?>&search=<?php echo $search ?>&platforms=<?php echo $page_platform ?>&page=<?php 
    
    if(($page+25) > $count) {
        echo ($count-25);
    }
    else{
        echo ($page + 25);
    }
    
    ?>"><i class="fas fa-angle-right"></i></a>
    <a class="taglink" href="showall.php?tag=<?php echo $tag ?>&message=Filtering by: <?php echo $tag ?>&s_column=<?php echo $sort_field?>&s_order=<?php echo $sort_type ?>&s_msg=<?php echo $s_msg ?>&search=<?php echo $search ?>&platforms=<?php echo $page_platform ?>&page=<?php echo ($count - 25)?>"><i class="fas fa-angle-double-right"></i></a> 
	</div> <!-- / main -->
			
<?php include("bottombit.php");