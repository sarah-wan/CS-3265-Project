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
    <title>View Accident Weather Conditions</title>
    <link rel="stylesheet" type="text/css" href="project2.css" />
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>

  <body>
    <div id="navbar">
        <a href="index.html">About Database</a>
        <a href="getAccident.php">Search Accidents</a>
        <a href="accidentAreaView.php">View Accident Area by State</a>
        <a href="accidentWeatherConditions.php">View Accident Weather Conditions</a>
        <a href="updateAccident.php">Report an Accident</a>
        <a href="deleteAccident.php">Delete an Accident</a>
    </div>
    <div class="main">
      <h1>View Accident Weather Conditions</h1>
      <p>
        On this page, you can view the weather conditions for different accidents
        based on the ID you provide. Upon submitting the form, the webpage will
        load a graphic that represents all the weather conditions when the
        accident occurred.
      </p>

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
             // $timestamp = explode(" ", $row['weather_timestamp']);
             // $time = DateTime::createFromFormat("H:i:s", $timestamp);
             // if ($) {
             //   // code...
             // }
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
            <div class="weather_results">
              <div class="weather">
                <span class="city"><?php echo $city; ?> <i class="fa fa-location-arrow"></i></span><br>
                <span class="temperature"><?php echo intval($temperature); ?>&#8457;</span><br>
                <span class="weather_condition"><?php echo $weather_condition; ?></span>
              </div>
              <div class="descriptions">
                <table>
                  <tbody>
                    <tr>
                      <td>
                        <span class="description_labels">WIND</span><br>
                        <?php
                        if ($wind_speed) {
                          ?>
                          <span class="description_info"><?php echo $wind_direction . " " . $wind_speed . " mph"; ?></span>
                          <?php
                        } else {
                          ?>
                          <span class="description_info"><?php echo $wind_direction; ?></span>
                          <?php
                        }
                         ?>
                      </td>
                      <td>
                        <span class="description_labels">WIND CHILL</span><br>
                        <?php
                        if ($wind_chill) {
                          ?>
                          <span class="description_info"><?php echo $wind_chill; ?></span>
                          <?php
                        } else {
                          ?>
                          <span class="description_info">N/A</span>
                          <?php
                        }
                         ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="description_labels">HUMIDITY</span><br>
                        <?php
                        if ($humidity) {
                          ?>
                          <span class="description_info"><?php echo intval($humidity) . "%"; ?></span>
                          <?php
                        } else {
                          ?>
                          <span class="description_info">N/A</span>
                          <?php
                        }
                         ?>
                      </td>
                      <td>
                        <span class="description_labels">VISIBILITY</span><br>
                        <?php
                        if ($visibility) {
                          ?>
                          <span class="description_info"><?php echo $visibility . " mi"; ?></span>
                          <?php
                        } else {
                          ?>
                          <span class="description_info">N/A</span>
                          <?php
                        }
                         ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span class="description_labels">PRESSURE</span><br>
                        <?php
                        if ($pressure) {
                          ?>
                          <span class="description_info"><?php echo $pressure . " inHg"; ?></span>
                          <?php
                        } else {
                          ?>
                          <span class="description_info">N/A</span>
                          <?php
                        }
                         ?>
                      </td>
                      <td>
                          <span class="description_labels">PRECIPITATION</span><br>
                          <?php
                          if ($precipitation) {
                            ?>
                            <span class="description_info"><?php echo $precipitation . " in"; ?></span>
                            <?php
                          } else {
                            ?>
                            <span class="description_info">N/A</span>
                            <?php
                          }
                           ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

          <?php }
        }

        if (isset($_POST['submit_id'])) {
          if ($id_result && $id_prepared_stmt->rowCount() > 0) {
                ?>
              <h2>Results from ID</h2>
              <?php
              // print_r($id_result);
              weather_results($id_result);
          } else {?>
            Sorry! No results for id: <?php echo $id; ?>.
          <?php
            }
         }
          ?>

    </div>

  </body>
</html>
