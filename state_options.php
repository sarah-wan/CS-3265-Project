<?php
require_once("conn.php");
$options_query = "SELECT state FROM states ORDER BY state ASC";
try
{
  $options_prepared_stmt = $dbo->prepare($options_query);
  $options_prepared_stmt->execute();
  $options_result = $options_prepared_stmt->fetchAll();
}
catch (PDOException $ex)
{ // Error in database processing.
  echo $sql . "<br>" . $error->getMessage(); // HTTP 500 - Internal Server Error
}

$states_options = array(
  "AL" => "Alabama",
  "AR" => "Arkansas",
  "AZ" => "Arizona",
  "CA" => "California",
  "CO" => "Colorado",
  "CT" => "Connecticut",
  "DC" => "Washington, DC",
  "DE" => "Delaware",
  "FL" => "Florida",
  "GA" => "Georgia",
  "HI" => "Hawaii",
  "IA" => "Iowa",
  "ID" => "Idaho",
  "IL" => "Illinois",
  "IN" => "Indiana",
  "KS" => "Kansas",
  "KY" => "Kentucky",
  "LA" => "Louisiana",
  "MA" => "Massachusetts",
  "MD" => "Maryland",
  "ME" => "Maine",
  "MI" => "Michigan",
  "MN" => "Minnesota",
  "MO" => "Missouri",
  "MS" => "Mississippi",
  "MT" => "Montana",
  "NC" => "North Carolina",
  "ND" => "North Dakota",
  "NE" => "Nebraska",
  "NH" => "New Hampshire",
  "NJ" => "New Jersey",
  "NM" => "New Mexico",
  "NV" => "Nevada",
  "NY" => "New York",
  "OH" => "Ohio",
  "OK" => "Oklahoma",
  "OR" => "Oregon",
  "PA" => "Pennsylvania",
  "RI" => "Rhode Island",
  "SC" => "South Carolina",
  "SD" => "South Dakota",
  "TN" => "Tennessee",
  "TX" => "Texas",
  "UT" => "Utah",
  "VA" => "Virginia",
  "VT" => "Vermont",
  "WA" => "Washington",
  "WI" => "Wisconsin",
  "WV" => "West Virginia",
  "WY" => "Wyoming"
);

 ?>
