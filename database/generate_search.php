<?php 
    // Go through all the results, and create a marker array which includes the library name, latitude, longitude, and rating
    // This array is then added into another array $markers (which is used by the js function that generates the Map).
    while ($row = $stmt->fetch()) {
        $marker = Array('Name'=>$row['Name'], 'Latitude'=>$row['Latitude'], 'Longitude'=>$row['Longitude'], 'Rating'=>$row['Rating']);
        $markers[] = $marker;
        // If a image file path is set in the database, then retrieve the image corresponding to that file path
        if ((isset($row['ImageFilePath'])) && !empty($row['ImageFilePath'])){
            $imgSource = 'https://library-finder-library-images.s3.us-east-2.amazonaws.com/' . $row['ImageFilePath']; 
        }
        // If a image file path is not set, then retrieve the generic library image from the s3 bucket
        else {
            $imgSource = 'https://library-finder-library-images.s3.us-east-2.amazonaws.com/images/Library.jpg';
        }
        ?>
        <!-- Generate anchor cards using library name, library image, and library rating -->
        <a class="card text-white bg-dark my-2" href="individual_result.php?Library=<?= $row['Name']?>">
            <img class="card-img-top" src="<?=$imgSource?>" alt="<?=$row['Name'] ?>">
            <div class="card-body">
                <h5><?=$row['Name'] ?></h5>
                <h6><?php 
                // If library has no rating, then show unrated
                if ($row['Rating']) {
                    echo $row['Rating'] . " stars";
                } else {
                    echo "Unrated";
                }
                ?></h6>
                <p class="card-text">Latitude: <?=$row['Latitude']?>, Longitude: <?=$row['Longitude']?></p>
            </div>
        </a>
        <?php 
    }
?>

