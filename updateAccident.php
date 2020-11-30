<?php

if (isset($_POST['submit'])) {

    require_once("conn.php");

    $id = $_POST['id'];
    $severity = $_POST['Severity'];
    $starttime =  date("Y-m-d H:i:s", strtotime($_POST["Starttime"]));
    $endtime = date("Y-m-d H:i:s", strtotime($_POST["Endtime"]));
    $description = $_POST['description'];
    $streetnumber = $_POST['streetnum'];
    $streetname = $_POST['street'];
    $side = $_POST['side'];
    $city = $_POST['city'];
    $county = $_POST['county'];
    $state = $_POST['state'];
    $zipcode = $_POST['zipcode'];
    $timezone = $_POST['timezone'];

    $insert_call = "CALL report_accident(:id, :severity, :starttime, :endtime, :description, :streetnum, :streetname, :side, :city, :county, :state, :zipcode, :timezone)";

    try
    {
      $prepared_stmt = $dbo->prepare($insert_call);
      $prepared_stmt->bindValue(':id', $id, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':severity', $severity, PDO::PARAM_INT);
      $prepared_stmt->bindValue(':starttime', $starttime, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':endtime', $endtime, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':description', $description, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':streetnum', $streetnumber, PDO::PARAM_INT);
      $prepared_stmt->bindValue(':streetname', $streetname, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':side', $side, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':city', $city, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':county', $county, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':state', $state, PDO::PARAM_STR);
      $prepared_stmt->bindValue(':zipcode', $zipcode, PDO::PARAM_INT);
      $prepared_stmt->bindValue(':timezone', $timezone, PDO::PARAM_STR);

      $isSuccess = $prepared_stmt->execute();
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
      <h1> Report an Accident</h1>
      <p>
        On this page, you are able to report a new accident that will be added to the
        database upon submitting the form.
      </p>

      <form method="POST">
          <table>
              <tr>
                  <td><strong>
                      ID :
                      <strong></td>
                  <td>
                      <input type = "text" name = "id" required>
                  </td>
                </tr>
                <tr>
                    <td><strong>
                        Severity :
                    <strong></td>
                    <td>
                        <input type = "radio" name = "Severity" value = "1" required> 1
                        <input type = "radio" name = "Severity" value = "2"> 2
                        <input type = "radio" name = "Severity" value = "3"> 3
                        <input type = "radio" name = "Severity" value = "4"> 4
                        <input type = "radio" name = "Severity" value = "5"> 5
                    </td>
                </tr>
                <tr>
                    <td><strong>
                        Start Time:
                    <strong></td>
                    <td>
                        <input type = "datetime-local" name = "Starttime" required>
                    </td>
                </tr>
                <tr>
                    <td><strong>
                        End Time:
                    <strong></td>
                    <td>
                        <input type = "datetime-local" name = "Endtime" required>
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
                        <input type = "radio" name = "side" value = "R" required> Right
                        <input type = "radio" name = "side" value = "L"> Left
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
                        <select id = "timezone" name = "timezone">
                            <option value="US/Eastern">US/Eastern</option>
                            <option value="US/Central">US/Central</option>
                            <option value="US/Mountain View">US/Mountain View</option>
                            <option value="US/Pacific">US/Pacific</option>
                        </select>

                    </td>
                </tr>
                <tr>
                    <td>
                        <input type = "submit" value = "Submit" name = "submit">
                    </td>
                </tr>
            </table>
      </form>
      <?php

        if (isset($_POST['submit'])) {
          if ($isSuccess) {
                ?>
              Error Has Occured
              <?php
          } else {?>
            Successfully Inserted Accident!
          <?php
            }
         } ?>

    </div>
  </body>
</html>
