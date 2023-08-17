<?php

function helloWorld(){
	echo "Hello World !!!";
}

function cleanLastname($lastname){
	return  strtoupper(trim($lastname));
}
function cleanFirstname($firstname){
	return  ucwords(strtolower(trim($firstname)));
}
function cleanEmail($email){
	return strtolower(trim($email));
}


function connectDB(){
	//Se connecter à la BDD
	try{
		$connection = new PDO("mysql:host=193.70.42.147;dbname=RIVER;port=3306","RIVER","RIVER");
	}catch(Exception $e){
		//Si on arrive pas à se connecter alors on fait un die avec erreur SQL
		die("Erreur SQL ".$e->getMessage() );
	}

	return $connection;
}



function isConnected(){

	if( !empty($_SESSION['email'])  &&  !empty($_SESSION['login']) && $_SESSION['login']==1 ) {

		//Ok il a une session mais est ce que son email est encore dans
		//la bdd
		$connect = connectDB();
		$queryPrepared = $connect->prepare("SELECT id from apn_utilisateurs WHERE email=:email");
		$queryPrepared->execute(["email"=>$_SESSION['email']]);
		$result = $queryPrepared->fetch();
		
		if(!empty($result )){
			return true;
		}
	}

	return false;
}



// Fonction pour créer une réservation dans la base de données
function createReservation($connection, $date, $startTime, $endTime, $customerName, $customerEmail) {
    // Préparer la requête d'insertion
    $query = $connection->prepare("INSERT INTO apn_reservation (date, start_time, end_time, customer_name, customer_email) VALUES (?, ?, ?, ?, ?)");

    // Exécuter la requête avec les valeurs fournies
    $query->execute([$date, $startTime, $endTime, $customerName, $customerEmail]);
}


?>