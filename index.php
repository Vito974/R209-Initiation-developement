<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cinema</title>
</head>
<body>
    <h1> CineKambaie974 </h1>
    
    <form action="script.php" method="get">
 Le film qui vous chercher : <input type="text" name="recherche" />
 
 <input type="submit" value="OK">
 
 <br><br/>
</form>
<form action="script2.php" method="get">
 Chercher des films par acteur : <input type="text" name="recherche" />
 
 <input type="submit" value="OK">
 

</form>
<h2> Inscription : </h2>
<form method="get" action="inscription.php">
email :<input type="text" name="email"/>
<br><br/>
nom :<input type="text" name="nom" />
<br><br/>
prénom :<input type="text" name="prenom"/>
<br><br/>
région :<input type="text" name="region"/>
<br><br/>
<input type="submit" value="OK">
</form>
<br><br/>
<a href="http://192.168.50.185/~debian/R209/TD5/formulaire.php"> Notation des films </a>
<br><br/>


    <?php 
    
    
    
    //variable pour la connexion à la base
    include "config.php";



    //connexion à la base
    try {
      $conn = new PDO("mysql:host=$servername;dbname=cinema", $username, $password);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully";
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }

    //Pour la création du tableau
    echo "<table style='border: solid 1px black;'>";
    echo "<tr><th>Titre</th><th>Année</th><th>Genre</th></tr>";
    
    //POO pour créer la classe tableau
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
    
   
    //autre connexion à la base
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $conn->prepare("SELECT titre,annee,genre FROM Film ");
      $stmt->execute();
    
      // set the resulting array to associative
      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
        echo $v;
      }
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    $conn = null;
    echo "</table>";



?>



    
    
</body>
</html>