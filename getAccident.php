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

if (isset($_POST['submit_state'])) {

    $state = $_POST['state'];

    $state_query = "SELECT * FROM accidents WHERE state = :state";

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

if (isset($_POST['submit_zipcode'])) {

    $zipcode = $_POST['zipcode'];

    $zipcode_query = "SELECT * FROM Accidents WHERE zipcode = :zipcode";

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
        <a href="index.html">Home</a>
        <a href="getAccident.php">Search Accidents</a>
    </div>
    <div class="main">
      <h1> Search for Accidents</h1>

      <form method="post">

        <label for="id"><strong>Search By ID</strong></label>
        <input type="text" name="id">

        <input type="submit" name="submit_id" value="Submit">
      </form>
      <?php
        if (isset($_POST['submit_id'])) {
          if ($id_result && $id_prepared_stmt->rowCount() > 0) { ?>

                <h2>Results from ID</h2>

                <?php foreach ($id_result as $row) { ?>
                  <p><strong>ID: </strong><?php echo $row["id"]; ?>
                    <strong> Source: </strong><?php echo $row["src"]; ?>
                    <strong> TMC: </strong><?php echo $row["tmc"]; ?>
                    <strong> Severity: </strong><?php echo $row["severity"]; ?> <br>
                    <strong> Description: </strong><?php echo $row["acc_description"]; ?><br>
                    <button onclick="showTable(<?php echo $row["id"];?>)">More Info</button></p>
                    <table id="<?php echo $row["id"];?>">
                      <tbody>
                        <tr>
                          <td>Start Time</td>
                          <td><?php echo $row["start_time"]; ?></td>
                        </tr>
                        <tr>
                          <td>End Time</td>
                          <td><?php echo $row["end_time"]; ?></td>
                        </tr>
                        <tr>
                          <td>Start Latitude</td>
                          <td><?php echo $row["start_lat"]; ?></td>
                        </tr>
                        <tr>
                          <td>Start Longitude</td>
                          <td><?php echo $row["start_lng"]; ?></td>
                        </tr>
                        <tr>
                          <td>End Latitude</td>
                          <td><?php echo $row["end_lat"]; ?></td>
                        </tr>
                        <tr>
                          <td>End Longitude</td>
                          <td><?php echo $row["end_lng"]; ?></td>
                        </tr>
                        <tr>
                          <td>Distance</td>
                          <td><?php echo $row["distance"]; ?></td>
                        </tr>
                        <tr>
                          <td>Street Num</td>
                          <td><?php echo $row["street_num"]; ?></td>
                        </tr>
                        <tr>
                          <td>Street</td>
                          <td><?php echo $row["street"]; ?></td>
                        </tr>
                        <tr>
                          <td>Side</td>
                          <td><?php echo $row["side"]; ?></td>
                        </tr>
                        <tr>
                          <td>County</td>
                          <td><?php echo $row["county"]; ?></td>
                        </tr>
                        <tr>
                          <td>State</td>
                          <td><?php echo $row["state"]; ?></td>
                        </tr>
                        <tr>
                          <td>Zip Code</td>
                          <td><?php echo $row["zipcode"]; ?></td>
                        </tr>
                        <tr>
                          <td>Country</td>
                          <td><?php echo $row["country"]; ?></td>
                        </tr>
                        <tr>
                          <td>Timezone</td>
                          <td><?php echo $row["timezone"]; ?></td>
                        </tr>
                        <tr>
                          <td>Airport Code</td>
                          <td><?php echo $row["airport_code"]; ?></td>
                        </tr>
                      </tbody>
                    </table>
                <?php } ?>

          <?php } else { ?>
            Sorry No results found for <?php echo $_POST['id']; ?>.
          <?php }
      } ?>
    </div>


    <script type="text/javascript">
      function showTable(id) {
        document.getElementById(id).style.display = "block";
      }
    </script>

  </body>
</html>
