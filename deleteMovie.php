<?php

if (isset($_POST['submit'])) {

    require_once("conn.php");

    $title = $_POST['title'];

    $query = "";

    try
    {
      $prepared_stmt = $dbo->prepare($query);
      $prepared_stmt->bindValue(':title', $title, PDO::PARAM_STR);
      $prepared_stmt->execute();

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
      <a href="getMovie01.php">Search Movie</a>
      <a href="insertMovie.php">Insert Movie</a>
      <a href="deleteMovie.php">Delete Movie</a>
    </div>

    <h1> Delete a Movie </h1>

    <form method="post">

      <label for="title">Title of movie</label>
      <input type="text" name="title" id="title">

      <input type="submit" name="submit" value="Delete Movie">
    </form>



  </body>
</html>
