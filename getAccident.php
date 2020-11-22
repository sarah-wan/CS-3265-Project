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

if (isset($_POST['submit_zipcode'])) {
    require_once("conn.php");

    $zipcode = $_POST['zipcode'];

    $zipcode_query = "SELECT * FROM Accidents WHERE zipcode = :zipcode ORDER BY id ASC";

try
    {
      $zipcode_prepared_stmt = $dbo->prepare($zipcode_query);
      $zipcode_prepared_stmt->bindValue(':zipcode', $zipcode, PDO::PARAM_STR);
      $zipcode_prepared_stmt->execute();
      $zipcode_result = $zipcode_prepared_stmt->fetchAll();

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
    </div>
    <div class="main">
      <h1> Search for Accidents</h1>

      <form method="post">

        <label for="id"><strong>Search By ID</strong></label>
        <input type="text" name="id">

        <input type="submit" name="submit_id" value="Submit">
      </form>

      <form method="post">
        <label for="zipcode"><strong>Search By Zip Code</strong></label>
        <input type="text" name="zipcode">

        <input type="submit" name="submit_zipcode" value="Submit">
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
