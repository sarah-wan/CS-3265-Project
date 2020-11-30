<?php

require_once("conn.php");
require_once("state_options.php");
?>

<html>
  <head>
    <title>View Accident Area By State</title>
    <link rel="stylesheet" type="text/css" href="project2.css" />
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
  </head>

  <body>
    <div id="navbar">
        <a href="index.html"> About Database </a>
        <a href="getAccident.php"> Search Accidents </a>
        <a href="accidentAreaView.php">View Accident Area by State</a>
        <a href="accidentWeatherConditions.php">View Accident Weather Conditions</a>
        <a href="updateAccident.php">Report an Accident</a>
        <a href="deleteAccident.php">Delete an Accident</a>
		</div>
    <div class="main">
      <h1>View Accident Area by State</h1>
      <p>
        On this page, you can see the overall data for the elements of the accidents
        per state. Upon submitting the form, there will be a graph that shows the
        number of accidents in the state per severity levels and the number of
        accidents that have the different elements of the road.
      </p>

      <form method="post">
        <label for="state">Choose a state</label>
        <select class="states" name="state">
          <option value=""></option>
            <?php
            if ($options_result && $options_prepared_stmt->rowCount() > 0){
                foreach($options_result as $row) {
                  ?>
                  <option value="<?= $row["state"]?>"><?php echo $states_options[$row["state"]];?></option>
                  <?php
                }
            }
            if (isset($_POST['state'])) {
              $state = $_POST['state'];

              $state_query = "SELECT DISTINCT state,
                                              severity,
                                              COUNT(severity) AS severity_count,
                                              COUNT(CASE WHEN amenity = 'True' THEN 1 END) AS amenity_count,
                                              COUNT(CASE WHEN bump = 'True' THEN 1 END) AS bump_count,
                                              COUNT(CASE WHEN crossing = 'True' THEN 1 END) AS crossing_count,
                                              COUNT(CASE WHEN give_way = 'True' THEN 1 END) AS give_way_count,
                                              COUNT(CASE WHEN junction = 'True' THEN 1 END) AS junction_count,
                                              COUNT(CASE WHEN no_exit = 'True' THEN 1 END) AS no_exit_count,
                                              COUNT(CASE WHEN roundabout = 'True' THEN 1 END) AS roundabout_count,
                                              COUNT(CASE WHEN stop_signal = 'True' THEN 1 END) AS stop_signal_count,
                                              COUNT(CASE WHEN traffic_calming = 'True' THEN 1 END) AS traffic_calming_count,
                                              COUNT(CASE WHEN traffic_signal = 'True' THEN 1 END) AS traffic_signal_count,
                                              COUNT(CASE WHEN turning_loop = 'True' THEN 1 END) AS turning_loop_count
                              FROM accident_area
                              WHERE state = :state
                              GROUP BY state, severity
                              ORDER BY severity ASC";
              try
                  {
                    $state_prepared_stmt = $dbo->prepare($state_query);
                    $state_prepared_stmt->bindValue(':state', $state, PDO::PARAM_STR);
                    $state_prepared_stmt->execute();
                    $state_result = $state_prepared_stmt->fetchAll();

                  }
              catch (PDOException $ex)
                  { // Error in database processing.
                    echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
                  }
            }
            ?>
        </select><br><br>
        <input type="submit" name="submit_state" value="Submit State">
      </form>
      <div id="severityChart" style="height: 370px; width: 100%;"></div>
    <?php
    if ($state_result && $state_prepared_stmt->rowCount() > 0) {
      $severity_data = array();
      $amenity_total = 0;
      $bump_total = 0;
      $crossing_total = 0;
      $give_way_total = 0;
      $junction_total = 0;
      $no_exit_total = 0;
      $roundabout_total = 0;
      $stop_signal_total = 0;
      $traffic_calming_total = 0;
      $traffic_signal_total = 0;
      $turning_loop_total = 0;
      foreach ($state_result as $row) {
        $curr_severity = array(
          "x" => $row["severity"],
          "y" => $row["severity_count"]
        );
        array_push($severity_data, $curr_severity);

        $amenity_total += $row["amenity_count"];
        $bump_total += $row["bump_count"];
        $crossing_total += $row["crossing_count"];
        $give_way_total += $row["give_way_count"];
        $junction_total += $row["junction_count"];
        $no_exit_total += $row["no_exit_count"];
        $roundabout_total += $row["roundabout_count"];
        $stop_signal_total += $row["stop_signal_count"];
        $traffic_calming_total += $row["traffic_calming_count"];
        $traffic_signal_total += $row["traffic_signal_count"];
        $turning_loop_total += $row["turning_loop_count"];
      }
     ?>
     <p>
       This graph represents the number of accidents in each severity level
       in the state of <?php echo $state_options[$row['state']]; ?>.
     </p>
    <script type="text/javascript">
        CanvasJS.addColorSet("severity",
          ["#ff6b6b", "#ff1f1f", "#e00000", "#a30000"]);
        var chart = new CanvasJS.Chart("severityChart", {
            animationEnabled: true,
            colorSet: "severity",
            title:{
              text: "Accident Severity Levels in <?php echo $states_options[$row["state"]];?>"
            },
            axisY:{
              includeZero: true,
              title: "Number of Accidents"
            },
            axisX:{
              title: "Severity Level",
              interval: 1
            },
            data: [{
              type: "column",
              indexLabelFontColor: "#5A5757",
              indexLabelPlacement: "outside",
              dataPoints: <?php echo json_encode($severity_data, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
    </script>

    <h2>Surrounding Area of the Accident</h2>
    <p>Below represents what the number of accidents that occurred with these
        road elements present. Here is a description of what each element represents
        on the road: <br>
        <ul>
          <li><strong>Amenity: </strong>A person sustained a life changing injury
              due to the accident.</li>
          <li><strong>Bump: </strong>A bump in the road where the accident occurred.</li>
          <li><strong>Crossing: </strong>A crosswalk or a crossing warning sign
              covered the area.</li>
          <li><strong>Give Way/Yield: </strong>A yield sign was near the sight
              of the accident.</li>
          <li><strong>Junction: </strong>A road had multiple paths for the person
              to take where the accident occurred.</li>
          <li><strong>No Exit: </strong>No exit sign was near the accident.</li>
          <li><strong>Roundabout: </strong>The accident occurred near a roundabout
              in the road.</li>
          <li><strong>Stop Signal: </strong>Someone ran a stop sign to cause the
              accident.</li>
          <li><strong>Traffic Calming: </strong> The traffic was calming down when
              the accident occurred.</li>
          <li><strong>Traffic Signal: </strong>A traffic light was near the accident.</li>
          <li><strong>Turning Loop: </strong>The accident occurred near a turning
              loop in the road.</li>
        </ul>
      </p>
    <div class="row">
      <div class="column left">
        <div id=amenity>
          <img src="images/amenity.png" alt="">
          <p><strong>Amenity</strong><br>
                <u>Number of accidents</u>: <?php echo $amenity_total;?></p>
        </div>
        <div id="no_exit">
          <img src="images/no_exit.png" alt="">
          <p><strong>No Exit Sign</strong><br>
                <u>Number of accidents</u>: <?php echo $no_exit_total;?></p>
        </div>
        <div id="turning_loop">
          <img src="images/turning_loop.jpg" alt="">
          <p><strong>Turning Loop</strong><br>
                <u>Number of accidents</u>: <?php echo $turning_loop_total;?></p>
        </div>
      </div>
      <div class="column left">
        <div id="bump">
          <img src="images/bump.png" alt="">
          <p><strong>Bump</strong><br>
                <u>Number of accidents</u>: <?php echo $bump_total;?></p>
        </div>
        <div id="roundabout">
          <img src="images/roundabout.png" alt="">
          <p><strong>Roundabout</strong><br>
                <u>Number of accidents</u>: <?php echo $roundabout_total;?></p>
        </div>
      </div>
      <div class="column middle">
        <div id="crossing">
          <img src="images/crossing.png" alt="">
          <p><strong>Crossing</strong><br>
                <u>Number of accidents</u>: <?php echo $crossing_total;?></p>
        </div>
        <div id="stop_signal">
          <img src="images/stop_signal.png" alt="">
          <p><strong>Stop Sign</strong><br>
                <u>Number of accidents</u>: <?php echo $stop_signal_total;?></p>
        </div>
      </div>
      <div class="column right">
        <div id="give_way">
          <img src="images/give_way.png" alt="">
          <p><strong>Give Way/Yield</strong><br>
                <u>Number of accidents</u>: <?php echo $give_way_total;?></p>
        </div>
        <div id="traffic_calming">
          <img src="images/traffic_calming.png" alt="">
          <p><strong>Traffic Calming</strong><br>
                <u>Number of accidents</u>: <?php echo $traffic_calming_total;?></p>
        </div>

      </div>
      <div class="column right">
        <div id="junction">
          <img src="images/junction.jpg" alt="">
          <p><strong>Junction</strong><br>
                <u>Number of accidents</u>: <?php echo $junction_total;?></p>
        </div>
        <div id="traffic_signal">
          <img src="images/traffic_signal.png" alt="">
          <p><strong>Traffic Signal</strong><br>
                <u>Number of accidents</u>: <?php echo $traffic_signal_total;?></p>
        </div>
      </div>
    </div>
    <?php
    }
    ?>
  </div>

  </body>
</html>
