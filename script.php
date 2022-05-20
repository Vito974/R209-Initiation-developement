<?php 

include "config.php";
//récupère la recherche dans le formulaire
$recherche = $_GET["recherche"];

    //connexion à la base
    try {
      $conn = new PDO("mysql:host=$servername;dbname=cinema", $username, $password);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully";
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }


    echo "<table style='border: solid 1px black;'>";
    echo "<tr><th>Titre</th><th>Année</th><th>Genre</th></tr>";
    
    //POO pour la classe du tableau
    class TableRows extends RecursiveIteratorIterator {
      function construct($it) {
        parent::construct($it, self::LEAVES_ONLY);
      }
    
      function current() {
        return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
      }
    
      function beginChildren() {
        echo "<tr>";
      }
    
      function endChildren() {
        echo "</tr>" . "\n";
      }
    }
    
    
    //Connexion à la base
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $conn->prepare("SELECT titre,annee,genre FROM Film WHERE titre = '$recherche'");
      $stmt->execute();
      $notation = $conn->prepare("SELECT DISTINCT email,note FROM Notation INNER JOIN Film ON Notation.idFilm=Film.idFilm WHERE titre = '$recherche'");
      $notation->execute();
      $notation = $notation->fetchAll();
      
      // set the resulting array to associative
      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
        echo $v;
      }
      echo "</table>";
      echo "<br></br>";
      echo "Email / ";
      echo "Et Note sur 10: ";
      echo "<br></br>";
      
      foreach($notation as $v) {
        echo $v['email']." ";
        echo $v['note']."/10";
        echo "<br></br>";
      }

    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    $conn = null;
    



?>