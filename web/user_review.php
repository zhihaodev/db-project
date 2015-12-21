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
//	$businessname = $_POST["businessname"];
	$username = $_POST["username"];
		$sql = "SELECT B1.Text, B1.Stars, B1.Date  FROM (SELECT User_ID FROM User WHERE Name = '$username') B, Business_Review B1 WHERE B1.User_ID = B.User_ID ORDER BY B1.DATE";
		$sql2 = $sql;
		$sql3 = $sql;
		$sql4 = $sql;
	$result = mysql_query($sql, $conn);
	$result2 = mysql_query($sql2, $conn2);
	$result3 = mysql_query($sql3, $conn3);
	$result4 = mysql_query($sql4, $conn4);
	
	$i = 1;
	echo '<table cellpadding = "0" cellspacing = "0" class = "table table-striped">';
	echo '<tr><th>#</th><th>Review</th><th>Stars</th><th>Date</th></tr>';
	while($row = mysql_fetch_row($result)){
 		$review = $row[0];
                $stars = $row[1];
                $date = $row[2];
                echo'<tr>';
                echo '<td>', $i, '</td>';
                echo '<td>', $review, '</td>';
                echo '<td>', $stars, '</td>';
                echo '<td>', $date, '</td>';
                echo'</tr>';	
		$i++;
	}
	 while($row = mysql_fetch_row($result2)){
                $review = $row[0];
                $stars = $row[1];
                $date = $row[2];
                echo'<tr>';
                echo '<td>', $i, '</td>';
                echo '<td>', $review, '</td>';
                echo '<td>', $stars, '</td>';
                echo '<td>', $date, '</td>';
                echo'</tr>';
		$i++;
        }
	 while($row = mysql_fetch_row($result3)){
                $review = $row[0];
                $stars = $row[1];
                $date = $row[2];
                echo'<tr>';
                echo '<td>', $i, '</td>';
                echo '<td>', $review, '</td>';
                echo '<td>', $stars, '</td>';
                echo '<td>', $date, '</td>';
                echo'</tr>';
		$i++;
        }
	 while($row = mysql_fetch_row($result4)){
                $review = $row[0];
                $stars = $row[1];
                $date = $row[2];
                echo'<tr>';
                echo '<td>', $i, '</td>';
                echo '<td>', $review, '</td>';
                echo '<td>', $stars, '</td>';
                echo '<td>', $date, '</td>';
                echo'</tr>';
		$i++;
        }
	mysql_close($conn);
	mysql_close($conn2);
	mysql_close($conn3);
        mysql_close($conn4);
	
?>

