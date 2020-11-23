<?php

if (isset($_POST['submit_id'])) {

    require_once("conn.php");

    $id = $_POST['id'];

    $id_query = "SELECT * FROM Accidents WHERE id = :id";

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
    </div>
    <div class="main">
      <h1> Report an Accident</h1>

      <form method="post">
          <table>
              <tr>
                  <td><strong>
                      ID :
                      <strong></td>
                  <td>
                      <input type = "text" ID = "" required>
                  </td>
                </tr>
                <tr>
                    <td><strong>
                        Severity :
                    <strong></td>
                    <td>
                        <input type = "radio" name = "Severity" required> 1
                        <input type = "radio" name = "Severity"> 2
                        <input type = "radio" name = "Severity"> 3
                        <input type = "radio" name = "Severity"> 4
                        <input type = "radio" name = "Severity"> 5
                    </td>
                </tr>
                <tr>
                    <td><strong>
                        Start Time:
                    <strong></td>
                    <td>
                        <input type = "datetime-local" name = "Start" required>
                    </td>
                </tr>
                <tr>
                    <td><strong>
                        End Time:
                    <strong></td>
                    <td>
                        <input type = "datetime-local" name = "End" required>
                    </td>
                </tr>
                <tr>
                    <td><strong>
                        Description:
                    <strong></td>
                    <td>
                        <input type = "text" name = "description">
                    </td>
                </tr>
                <tr>
                    <td><strong>
                        Street Number:
                    <strong></td>
                    <td>
                        <input type = "text" name = "streetnum">
                    </td>
                </tr>
                <tr>
                    <td><strong>
                        Street Name:
                    <strong></td>
                    <td>
                        <input type = "text" name = "street" required>
                    </td>
                </tr>
                <tr>
                    <td><strong>
                        Side:
                    <strong></td>
                    <td>
                        <input type = "radio" name = "side" required> R
                        <input type = "radio" name = "side"> L
                    </td>
                </tr>
                <tr>
                    <td><strong>
                        City:
                    <strong></td>
                    <td>
                        <input type = "text" name = "city" required>
                    </td>
                </tr>
                <tr>
                    <td><strong>
                        County:
                    <strong></td>
                    <td>
                        <input type = "text" name = "county">
                    </td>
                </tr>
                <tr>
                    <td><strong>
                        State:
                    <strong></td>
                    <td>
                        <select id = "state" name = "state">
                            <option value="AL">Alabama</option>
                            <option value="AK">Alaska</option>
                            <option value="AZ">Arizona</option>
                            <option value="AR">Arkansas</option>
                            <option value="CA">California</option>
                            <option value="CO">Colorado</option>
                            <option value="CT">Connecticut</option>
                            <option value="DE">Delaware</option>
                            <option value="DC">District Of Columbia</option>
                            <option value="FL">Florida</option>
                            <option value="GA">Georgia</option>
                            <option value="HI">Hawaii</option>
                            <option value="ID">Idaho</option>
                            <option value="IL">Illinois</option>
                            <option value="IN">Indiana</option>
                            <option value="IA">Iowa</option>
                            <option value="KS">Kansas</option>
                            <option value="KY">Kentucky</option>
                            <option value="LA">Louisiana</option>
                            <option value="ME">Maine</option>
                            <option value="MD">Maryland</option>
                            <option value="MA">Massachusetts</option>
                            <option value="MI">Michigan</option>
                            <option value="MN">Minnesota</option>
                            <option value="MS">Mississippi</option>
                            <option value="MO">Missouri</option>
                            <option value="MT">Montana</option>
                            <option value="NE">Nebraska</option>
                            <option value="NV">Nevada</option>
                            <option value="NH">New Hampshire</option>
                            <option value="NJ">New Jersey</option>
                            <option value="NM">New Mexico</option>
                            <option value="NY">New York</option>
                            <option value="NC">North Carolina</option>
                            <option value="ND">North Dakota</option>
                            <option value="OH">Ohio</option>
                            <option value="OK">Oklahoma</option>
                            <option value="OR">Oregon</option>
                            <option value="PA">Pennsylvania</option>
                            <option value="RI">Rhode Island</option>
                            <option value="SC">South Carolina</option>
                            <option value="SD">South Dakota</option>
                            <option value="TN">Tennessee</option>
                            <option value="TX">Texas</option>
                            <option value="UT">Utah</option>
                            <option value="VT">Vermont</option>
                            <option value="VA">Virginia</option>
                            <option value="WA">Washington</option>
                            <option value="WV">West Virginia</option>
                            <option value="WI">Wisconsin</option>
                            <option value="WY">Wyoming</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong>
                        Zipcode:
                    <strong></td>
                    <td>
                        <input type = "text" name = "zipcode" required>
                    </td>
                </tr>
                <tr>
                    <td><strong>
                        Timezone:
                    <strong></td>
                    <td>
                        <select id = "state" name = "state">
                            <option value="US/Eastern">US/Eastern</option>
                            <option value="US/Central">US/Central</option>
                            <option value="US/Mountain View">US/Mountain View</option>
                            <option value="US/Pacific">US/Pacific</option>
                        </select>

                    </td>
                </tr>
                <tr>
                    <td>
                        <input type = "Submit" value = "Submit" name = ""> 
                    </td>
                </tr>
            </table>
      </form>
      <?php
        function results($result) {
           foreach ($result as $row) {
            ?>
            <p><strong>ID: </strong><?php echo $row["id"]; ?>
              <strong> Source: </strong><?php echo $row["src"]; ?>
              <strong> TMC: </strong><?php echo $row["tmc"]; ?>
              <strong> Severity: </strong><?php echo $row["severity"]; ?> <br>
              <strong> Description: </strong><?php echo $row["acc_description"]; ?><br>
              <button type="button" name="button" onclick="showDiv('<?php echo $row["id"];?>')">More Info</button>
              <div id=<?= $row["id"]?> class="info">
                <table>
                  <tbody>
                    <tr>
                      <th>Start Time</th>
                      <th>End Time</th>
                      <th>Start Position (Latitude, Longitude)</th>
                      <th>End Position (Latitude, Longitude)</th>
                      <th>Distance (mi)</th>
                      <th>Address</th>
                      <th>Timezone</th>
                      <th>Airport Code</th>
                    </tr>
                    <tr>
                      <td><?php echo $row["start_time"]; ?></td>
                      <td><?php echo $row["end_time"]; ?></td>
                      <td><?php echo "(", $row["start_lat"], ", ", $row["start_lng"], ")"; ?></td>
                      <?php
                        $end_lat = $row["end_lat"];
                        $end_lng = $row["end_lng"];
                        $end_position = "(" . $end_lat . "," . $end_lng . ")";
                        if (is_null($row["end_lat"]) || is_null($row["end_lng"])) {
                          $end_position = "Unknown";
                        }
                       ?>
                      <td><?php echo $end_position; ?></td>
                      <td><?php echo $row["distance"]; ?></td>
                      <td><?php echo $row["street_num"], " ", $row["street"],
                          " ", $row["side"], " ", $row["county"], ", ",
                          $row["state"], " ", $row["zipcode"], ", ",
                          $row["country"];?></td>
                      <td><?php echo $row["timezone"]; ?></td>
                      <td><?php echo $row["airport_code"]; ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
          <?php }
        }

        if (isset($_POST['submit_id'])) {
          if ($id_result && $id_prepared_stmt->rowCount() > 0) {
                ?>
              <h2>Results from ID</h2>
              <?php
              results($id_result);
          } else {?>
            Sorry! No results for id: <?php echo $id; ?>.
          <?php
            }
         } else if (isset($_POST['submit_zipcode'])) {
            if ($zipcode_result && $zipcode_prepared_stmt->rowCount() > 0) {
              ?>
              <h2>Results from Zip Code</h2>
              <?php
              results($zipcode_result);
            } else {?>
              Sorry! No results for zip code: <?php echo $zipcode; ?>.
            <?php }
          } ?>

    </div>


    <script type="text/javascript">
      function showDiv(id) {
        if (document.getElementById(id).style.display == "block") {
          document.getElementById(id).style.display = "none";
        } else {
          document.getElementById(id).style.display = "block";
        }
      }
    </script>

  </body>
</html>
