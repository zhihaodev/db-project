<head>
<meta charset = "utf-8">
<meta http-equiv = "X-UA-Compatible" content = "IE = edge">
<meta name = "viewport" content = "width = device-width, initial-scale = 1">
<title>DatabaseProject</title>
<!-- Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
<style type="text/css">
    table.db-table      { border-right:1px solid #ccc; border-bottom:1px solid #ccc; }
    table.db-table th   { background:#eee; padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
    table.db-table td   { padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
</style>
</head>
<?php
	// server 1
	$dbhost1 = '52.20.153.92:3306';
	// server 2
	$dbhost2 = '52.21.83.20';
	// server 3
	$dbhost3 = '52.21.131.52';
	// server 4
	$dbhost4 = '52.20.153.168';
	$dbuser = 'dbuser';
	$dbpass = 'yelp';
	$dbname = 'yelp';
	// connect server 1 database
	$conn = mysql_connect($dbhost1, $dbuser, $dbpass) or die ('Error connecting to mysql');
	// connect server 2 databse
	$conn2 = mysql_connect($dbhost2, $dbuser, $dbpass) or die ('Error connecting to mysql');
	
	// connect server 3 database
        $conn3 = mysql_connect($dbhost3, $dbuser, $dbpass) or die ('Error connecting to mysql');
        
	// connect server 4 databse
        $conn4 = mysql_connect($dbhost4, $dbuser, $dbpass) or die ('Error connecting to mysql');
	
	mysql_select_db($dbname);

	$businessname = $_POST["businessname"];
//echo $businessname;
	/*
	if($businessname != null){
		$sql = "SELECT Name, Address, Stars FROM Business WHERE Name = '$businessname'";
		 
	}
	*/	
	$businesscate = $_POST["businesscate"];
	$location = $_POST["location"];
	$wifi = $_POST["wifi"];
	$numAtt = 0;
	if($wifi == "on"){
		$wifi = " Attribute = 'Wi-Fi' and";
		$numAtt++;
	}
	$pet = $_POST["pet"];
        if($pet == "on"){
                $pet = " Attribute = 'Dogs Allowed' and";
        	$numAtt++;
	}
	$smoke = $_POST["smoke"];
        if($smoke == "on"){
                $smoke = " Attribute = 'Smoking' and";
        	$numAtt++;
	}
	$open24hours = $_POST["open24hours"];
        if($open24hours == "on"){
                $open24hours = " Attribute = 'Open 24 Hours' and";
        	$numAtt++;
	}
	$parking = $_POST["parking"];
        if($parking == "on"){
                $parking = " Attribute = 'Parking' and";
        	$numAtt++;
	}
	$reservation = $_POST["reservation"];
        if($reservation == "on"){
                $reservation = " Attribute = 'Takes Reservations' and";
        	$numAtt++;
	}
	if($numAtt != 0 && $businessname == null){
		$attributes = "WHERE" . $wifi . $pet . $smoke . $open24hours . $parking . $reservation;
        	$final_attr = substr($attributes, 0, -4);	
		$sql = "SELECT DISTINCT B.Name, B.Address, B.Stars FROM Business B,(SELECT Business_ID FROM Business_Attributes"." " .$final_attr." ".") B2, (SELECT Business_ID FROM Business_Categories  WHERE Category = '$businesscate')B1 WHERE B.City = '$location' AND B.Business_ID = B1.Business_ID AND B.Business_ID = B2.Business_ID ORDER BY B.Stars DESC LIMIT 20";
	     	$sql2 = $sql;
		$sql3 = $sql; 
		$sql4 = $sql;	
	}else if ($numAtt == 0 && $businessname == null){
        	$sql = "SELECT DISTINCT B.Name, B.Address, B.Stars FROM Business B, (SELECT Business_ID FROM Business_Categories  WHERE Category = '$businesscate')B1 WHERE B.City = '$location' AND B.Business_ID = B1.Business_ID ORDER BY B.Stars DESC LIMIT 20";
        	$sql2 = $sql;	
		$sql3 = $sql;
		$sql4 = $sql;
	}else if($numAtt == 0 && $businessname != null){
		$sql = "SELECT B1.Name, B1.Address,B.Stars FROM Business B, (SELECT Business_ID,Name, Address FROM Business WHERE Name = '$businessname') B1 WHERE B.Business_ID = B1.Business_ID";
		$sql2 = $sql;
		$sql3 = $sql;
		$sql4 = $sql;
	}else{
	};
	$result = mysql_query($sql, $conn);
	$result2 = mysql_query($sql2, $conn2);
	$result3 = mysql_query($sql3, $conn3);
	$result4 = mysql_query($sql4, $conn4);
	
	$i = 1;
	echo '<table cellpadding = "0" cellspacing = "0" class = "table table-striped">';
	echo '<tr><th>#</th><th>Name</th><th>Address</th><th>Stars</th></tr>';
	$rows = array();
	$map = array();
	while($row = mysql_fetch_row($result)){
		//echo $row[2];
		//$ele = array($row[2]=> $row);
		//$rows = $rows+ $ele;
		echo $row[0];
		$rows[$i] = $row[2];
		$map[$i] = $row;
		$i++;
	}
//	echo count($rows);
	$j = 21; 
	while($row = mysql_fetch_row($result2)){
         // echo $row[0]; 
	       $rows[$j] = $row[2];
		$map[$j] = $row;
                $j++;
        }
        $m = 41;
        while($row = mysql_fetch_row($result3)){
  	//echo $row[0];         
       		$rows[$m] = $row[2];
                $map[$m] = $row;
                $m++;
        }
        $n = 61;
        while($row = mysql_fetch_row($result4)){
  	//echo $row[0];         
       		$rows[$n] = $row[2];
                $map[$n] = $row;
                $n++;
        }
	arsort($rows);
	$a = 1;
	foreach ($rows as $key => $val){
		$answer = $map[$key];
		//echo $answer[0];
		
		$Business_Name = $answer[0];
                $Business_Address = $answer[1];
                $Business_Star = $answer[2];
                echo'<tr>';
                echo '<td>', $a, '</td>';
                echo '<td>', $Business_Name, '</td>';
                echo '<td>', $Business_Address, '</td>';
                echo '<td>', $Business_Star, '</td>';
                echo'</tr>';
                $a++;
		if($a == 21){
		    break;
		}
		
	}
	
	mysql_close($conn);
	mysql_close($conn2);
	mysql_close($conn3);
        mysql_close($conn4);
	
?>

