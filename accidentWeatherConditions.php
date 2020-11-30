<?php

if (isset($_POST['submit_id'])) {

    require_once("conn.php");

    $id = $_POST['id'];

    $id_query = "SELECT * FROM accident_weather WHERE id = :id";

try
    {
      $id_prepared_stmt = $dbo->prepare($id_query);
      $id_prepared_stmt->bindValue(':id', $id, PDO::PARAM_STR);
      $id_prepared_stmt->execute();
      $id_result = $id_prepared_stmt->fetchAll();

    }
    catch (PDOException $ex)
    { // Error in database processing.
      echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
    }
}
?>

<html>
  <head>
    <link rel="stylesheet" type="text/css" href="project2.css" />
  </head>

  <body>
    <div id="navbar">
        <a href="index.html">About Database</a>
        <a href="getAccident.php">Search Accidents</a>
        <a href="accidentAreaView.php">View Accident Area by State</a>
        <a href="updateAccident.php">Report an Accident</a>
        <a href="accidentWeatherConditions.php">View Accident Weather Conditions</a>
    </div>
    <div class="main">
      <h1> Search for Accidents</h1>

      <form method="post">

        <label for="id"><strong>Search By ID</strong></label>
        <input type="text" name="id"><br><br>

        <input type="submit" name="submit_id" value="Submit ID">
      </form>
      <br>
      <?php
        function weather_results($result) {
           foreach ($result as $row) {
             $id = $$row['id'];
             $city = $row['city'];
             $state = $row['state'];
             $
             $timestamp = explode(" ", $row['weather_timestamp']);
             $time = DateTime::createFromFormat("H:i:s", $timestamp);
             if ($) {
               // code...
             }
             $temperature = $row['temperature'];
             $wind_chill = $row['$wind_chill'];
             $humidity = $row['humidity'];
             $pressure = $row['pressure'];
             $visibility = $row['visibility'];
             $wind_direction = $row['wind_direction'];
             $wind_speed = $row['wind_speed'];
             $precipitation = $row['precipitation'];
             $weather_condition = $row['weather_condition'];
            ?>
            <div class="weather_results" style="">

            </div>

          <?php }
        }

        if (isset($_POST['submit_id'])) {
          if ($id_result && $id_prepared_stmt->rowCount() > 0) {
                ?>
              <h2>Results from ID</h2>
              <?php
              print_r($id_result);
              // weather_results($id_result);
          } else {?>
            Sorry! No results for id: <?php echo $id; ?>.
          <?php
            }
         } ?>

    </div>

  </body>
</html>
