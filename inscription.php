<?php 

include "config.php";
$email = $_GET['email'];
$nom = $_GET['nom'];
$prenom = $_GET['prenom'];
echo $prenom;
$region = $_GET['region'];

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO Internaute (email, nom, prenom, region) VALUES ('$email', '$nom', '$prenom', '$region')";
  // use exec() because no results are returned
  $conn->exec($sql);
  echo "New record created successfully";
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;


?>