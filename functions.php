<?php

	//loob AB'i ühenduse
	
	require_once("../config_global.php");
	$database = "if15_mkoinc_3";
	
	function getCarData(){
		
		$mysqli = new mysqli($GLOBALS["servername"],$GLOBALS["server_username"],$GLOBALS["server_password"],$GLOBALS ["database"]);

		$stmt = $mysqli -> prepare("SELECT id, user_id, number_plate, color FROM car_plates WHERE deleted is NULL ");
		
				$stmt->bind_result($id, $user_id_from_database, $number_plate, $color);
				$stmt ->execute();
		
		//tekitan tühja massiivi,kus edaspidi hoian andmeid
		$car_array = array();
		
		
		while($stmt->fetch()){
			
		//tekitan objekti, kus hakkan hoidma väärtusi
		$car = new StdClass();
		$car->id = $id;
		$car->plate = $number_plate;
		
		//lisan massiivi
		array_push($car_array, $car);
		//vardump ütleb tüübi ja sisu
		//echo"<pre>";
		//var_dump($car_array);
		//echo"</pre><br>";
		}
		
		//tagastan massiivi kus kõik read sees
		return $car_array;
		
		
		$stmt->close();
		
		$mysqli->close();
	}
	
	function deleteCar($id){
			
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			
		$stmt = $mysqli->prepare("UPDATE car_plates SET deleted=NOW() WHERE id=?");
		
		$stmt->bind_param("i", $id);
			if($stmt->execute()){
				//sai kustutatud
				header("Location: table.php");
			}
			
			$stmt->close();
			$mysqli->close();
		}
	
	
	function updateCar($id, $number_plate, $color){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE car_plates SET number_plate=?, color=? WHERE id=?");
		$stmt->bind_param("ssi", $number_plate, $color, $id);
		if($stmt->execute()){
			// sai uuendatud
			// kustutame aadressirea tühjaks
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
	}

	
?>