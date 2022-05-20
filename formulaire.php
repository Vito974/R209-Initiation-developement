<?php
// Start the session
session_start();
include "config.php";
?>

<?php 
    
    
    


    

    
        
        try {
          $conn = new PDO("mysql:host=$servername;dbname=cinema", $username, $password);
          // set the PDO error mode to exception
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          echo "Connected successfully";
        } catch(PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
        }
    
    
       
        
       
        
        
        try {
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT titre,idFilm FROM Film ");
          $stmt->execute();
          $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
          //print_r($stmt->fetchAll());
          //permet d'afficher uniquement les titres pour le menu déroulant
          $data = $stmt->fetchAll();
          
          echo "<br></br>";
          
          
        
          
        } catch(PDOException $e) {
          echo "Error: " . $e->getMessage();
        }
        $conn = null;
        
    
    
    
    ?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
</head>
<body>
    
<form action="formulaire.php" method="get">
 Mail : <input type="email" id="email" name="mail" />
 <br><br/>
 <select name="film" id="slect-film">
    <option value="">--Choisissez un film--</option>
    <?php 
    foreach ($data as $key => $value) {
        
            echo '<option value="'.$value['idFilm'].'">'.$value['titre'].'</option>';
        
    }

    ?>
    
</select>
<br><br/>
<!--Menu déroulant-->
note :
<select name="note" id="note-select">
    <option value="">--Notez ce film avec objectivité svp--</option>
    <option value="0">0</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
</select>
 
 <br><br/>

 <br><br/>
 <input type="submit" value="OK">
 
</form>  
<?php 
if (isset($_GET['film'])) {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }
    $film = $_GET['film'];
    $mail = $_GET['mail'];
    $note = $_GET['note'];

    $sql = "INSERT INTO Notation (idFilm, email, note) VALUES('$film', '$mail', '$note')";

    if ($conn->query($sql) === TRUE) {
    echo "Merci pour votre contribution";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

}

?>  
</body>
</html>