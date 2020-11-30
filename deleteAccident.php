<?php

if (isset($_POST['submit'])) {

    require_once("conn.php");

    $id = $_POST['id'];

    $insert_call = "CALL delete_accident(:id)";

    try
    {
      $prepared_stmt = $dbo->prepare($insert_call);
      $prepared_stmt->bindValue(':id', $id, PDO::PARAM_STR);

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
    <title>Delete an Accident</title>
    <link rel="stylesheet" type="text/css" href="project2.css" />
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
      <h1> Delete an Accident </h1>
      <p>
        On this page, you are able to delete an accident previously reported through the form.
      </p>

      <form method="POST">
              <tr>
                  <td><strong>
                      ID :
                      <strong></td>
                  <td>
                      <input type = "text" name = "id" required>
                  </td>
                </tr>
                <tr>
                    <td>
                        <input type = "submit" value = "Submit" name = "submit">
                    </td>
                </tr><br><br>
      </form>
      <?php

        if (isset($_POST['submit'])) {
          if ($isSuccess) {
                ?>
                Successfully Deleted Accident!
              <?php
          } else {?>
                Error!
          <?php
                print_r($prepared_stmt ->errorInfo());
            }
         } ?>

    </div>
  </body>
</html>
