<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>Okasha</title>
        <style type="text/css">
            h1 {
                margin-left: 25px;
            }
            #corps {
                width:900px;
				margin-left:auto;
				margin-right:auto;
				background-color:black;
				color: white;
				border-radius: 10px;
				box-shadow: 10px 10px 10px black;
				border: 0.2px solid black;
				text-align:left;
				background-image: url("images/fond.png");
				padding-bottom: 20px;
				padding-top: 20px;
				margin-top: 60px;
				margin-bottom:0px;
            }
            #fieldCheck {
                float:left;
				margin:0 25px 15px 25px;
                width:180px;
                height:60px; 
            }
            #fieldChamps {
                margin-right: 25px;
                height: 150px;
            }		
	</style> 
    </head>
    <body>
		<div id="corps"> 
        <h1>Okasha</h1>
		<form method="post" action="" id="formCheck">
        <fieldset id="fieldCheck">
                <input type="checkbox" name="majuscule"/>
                <label> Majuscule</label><br/>
                <input type="checkbox" name="minuscule"/>
                <label> Minuscule </label><br/>
                <input type="checkbox" name="chiffre"/>
                <label> Chiffre </label><br/>
				<input type="checkbox" name="special"/>
				<label> Caractères ASCII </label><br/>
        </fieldset>
        <fieldset id="fieldChamps">    
                <input type="text" name="nombre" onKeypress="if((event.keyCode < 48 || event.keyCode > 57) && event.which > 31) event.returnValue = false; if((event.which < 48 || event.which > 57) && event.which > 31) return false;">
				<label> Nombre de mot de passe </label><br/>
				<input type="text" name="longueur" onKeypress="if((event.keyCode < 48 || event.keyCode > 57) && event.which > 31) event.returnValue = false; if((event.which < 48 || event.which > 57) && event.which > 31) return false;">
				<label> Longeur du mot de passe </label><br/>
                <input type="submit" name="generer" value="Generer"/>
				<input type="submit" name="doublon" value="Doublon"/>
				<input type="submit" name="associer" value="Associer"/>
        </fieldset>
		</form>
        
<?php

$conn = new PDO("mysql:dbname=genpassword;host=localhost","root","");		//Connexion à la BDD
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);				//Active le Mode Exception
$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);		//Les résultats seront rangés par défault dans un tableau associatif
$conn->exec("SET NAMES 'utf8'");											//Transaction avec la BDD en UTF8
        
function getpass($nombre, $valeurs, $nbcarac) {
    
	$resultat = "";

	for ($i=0; $i < $nombre; $i++) {

		$val = $valeurs[rand(0,$nbcarac -1)];
		$resultat = $resultat.$val;
	}

	return $resultat;
}

function associer ($longueur, $allcaractere, $nbcaractere){

	$ouvre = fopen("login.txt","r");  // Ouverture du fichier
    while (!feof ($ouvre)) {          // Tant que pas en fin de fichier
	$lecture = fgets($ouvre, 4096); // Stockage dans $lecture
	$donnee = explode("*", $lecture);  // Parsing des données basé sur "*")
                    
    $combien = count($donnee); // Nombre d'éléments
    echo "<b>Ce fichier contient ",$combien," couple login et mot de passe : </b><br><br>";
                    
    for ($i = 0; $i < $combien; $i++) {
		// Ajout du mot de passe
        $result = getpass($longueur, $allcaractere, $nbcaractere);
        fputs($donnee, '&nbsp' . $result);
        // Stockage temporaire des données toujours avec le séparateur
        $liste_modif.=$donnee[$i]."*";
        }
	}
	fclose($ouvre); // Fermeture du document   
    $ouvre = fopen("login.txt","");
    fwrite($ouvre, $liste_modif);
    fclose($ouvre);
}

// longueur mot de passe

// $longueur = $_POST["longueur"]

  // ensemble des caractéres
$allcaractere = array();

  // tableau majuscule
$majuscule = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

  // tableau minuscule
$minuscule = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");

  //  tableau de nombre 
$chiffre = array("0","1","2","3","4","5","6","7","8","9");

$special = array(",","?",";",".",":","/","!","&","~","\"","#","(","[","-","|","`","_","\\","^","@",")","]","=","}","<",">");

// verification des checkbox 

// array_merge  : fusionne plusieurs tableaux en un seul

if (isset($_POST["generer"]) || isset($_POST["associer"])) {
	
	if (isset($_POST["majuscule"]) || isset($_POST['minuscule']) || isset($_POST['chiffre']) || isset($_POST['special'])) {
		
		if (!empty($_POST["nombre"]) && !empty($_POST["longueur"])) {
			
			if (isset($_POST['minuscule']))
				$allcaractere = array_merge($allcaractere, $minuscule);

			if (isset($_POST["majuscule"]))
				$allcaractere = array_merge($allcaractere, $majuscule);

			if (isset($_POST["chiffre"]))
				$allcaractere = array_merge($allcaractere, $chiffre);

			if (isset($_POST["special"]))
				$allcaractere = array_merge($allcaractere, $special);

			$nbcaractere = count($allcaractere);
			
			if (isset($_POST["generer"]))
				for ($i = 0; $i < $_POST["nombre"]; $i++) {
					$result = getpass($_POST["longueur"], $allcaractere, $nbcaractere);
					$query = "INSERT INTO `pass` (password) VALUES ('".addslashes($result)."')";
					$conn->query($query);
					echo $result;
					echo "</br>";
				}
			
			if (isset($_POST["associer"]))
				associer($_POST["longueur"], $allcaractere, $nbcaractere);
		}
		else {
			echo "Veuillez entrer un nombre et une longueur de mot de passe.";
			echo "</br>";
		}
	}
	else 
		echo "Veuillez choisir au moins un type de caractère que doit comporter votre mot de passe.";
}

if (isset($_POST["doublon"])) {
	$query = "ALTER IGNORE TABLE pass ADD UNIQUE INDEX (password)";
	$conn->query($query);
	$query2 = "SELECT `password`, COUNT(*) AS nombre FROM `pass` GROUP BY `password` HAVING COUNT(*) > 1";
	$nbdoublons = $conn->query($query2)->fetch();
	echo $nbdoublons." doublons détectés et supprimés. Suppression des doublons terminée.";
	$query1 = "ALTER TABLE pass DROP INDEX `password`";
	$conn->query($query1);
}
     
//$rand_keys = array_rand($majuscule, 10);
//echo $majuscule[$rand_keys[0]];
//echo "<br/>";

//echo rand(15,20);
//echo "<br/>";
//$res = getpass(10,10,15);
//echo $res;
?>
        </div>
    </body>
</html>
