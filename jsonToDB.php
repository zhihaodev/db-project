<?php
    $server = 'localhost';
    $username = 'root';
    $dbname = 'yelp';

    $con = mysql_connect($server, $username, $dbname) or die('Connection failed: ' . mysql_error());
    mysql_select_db($dbname, $con);
    echo 'Inserting table... <br \>';


    // Insert Business table
    $fd = fopen("yelp_academic_dataset_business_1.json", "r");
    while (!feof($fd)) {
        $line = fgets($fd, 10000); 
        $data = json_decode($line, true);
        $business_id = $data['business_id'];

        $name = mysql_real_escape_string($data['name']);
        $address = mysql_real_escape_string($data['full_address']);
        $city = mysql_real_escape_string($data['city']);
        $state = $data['state'];
        $latitude = $data['latitude'];
        $longitude = $data['longitude'];
        $stars = $data['stars'];
        $sql = "INSERT INTO Business(Business_ID, Name, Address, City, State, Latitude, Longitude, Stars)
                VALUES('$business_id', '$name', '$address', '$city', '$state', '$latitude', '$longitude', '$stars')";
        if(!mysql_query($sql, $con)) {
            echo "Error: ".$line."<br \>";
            echo "Error: ".$sql."<br \>";
            echo 'Error:' .mysql_error()."<br \>";
            // die('Error:' .mysql_error());
        }

        // Insert Attribute table
        $attributes = $data['attributes'];
        if (!empty($attributes)) {
            foreach ($attributes as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $key2 => $value2) {
                        if ($value2 == 'true') {
                            $sql = "INSERT INTO Business_Attributes(Business_ID, Attribute, Value)
                                    VALUES('$business_id', '$key', '$key2')";
                            if(!mysql_query($sql, $con)) {
                                echo "Error: ".$sql."<br \>";
                                echo 'Error:' .mysql_error()."<br \>";
                                // die('Error:' .mysql_error());
                            }
                            break;
                        }
                    }
                } else {
                    if (is_bool($value)) {
                        $value = ($value) ? 'true' : 'false';
                    }
                    $sql = "INSERT INTO Business_Attributes(Business_ID, Attribute, Value)
                            VALUES('$business_id', '$key', '$value')";
                    if(!mysql_query($sql, $con)) {
                        echo "Error: ".$sql."<br \>";
                        echo 'Error:' .mysql_error()."<br \>";
                        // die('Error:' .mysql_error());
                    }
                }
            }
        }
        
        // Insert Category table
        $categories = $data['categories'];
        if (!empty($categories)) {
            foreach ($categories as $category) {
                $category = mysql_real_escape_string($category);
                $sql = "INSERT INTO Business_Categories(Business_ID, category)
                        VALUES('$business_id', '$category')";
                if(!mysql_query($sql, $con)) {
                    echo "Error: ".$sql."<br \>";
                    echo 'Error:' .mysql_error()."<br \>";
                    die('Error:' .mysql_error());
                }
            }
        }
    }
    fclose ($fd);


    // Insert User table
    $fd = fopen("yelp_academic_dataset_user_1.json", "r");
    while (!feof($fd)) {
        $line = fgets($fd, 150000); 
        $data = json_decode($line, true);
        $user_id = $data['user_id'];
        $name = mysql_real_escape_string($data['name']);
        $count = $data['review_count'];
        $stars = $data['average_stars'];
        $since = $data['yelping_since'];
        $fans = $data['fans'];
        $sql = "INSERT INTO User(User_ID, Name, Review_Count, Average_Stars, Yelping_Since, Fans)
                VALUES('$user_id', '$name', '$count', '$stars', '$since', '$fans')";
        if(!mysql_query($sql, $con)) {
            echo "Error: ".$sql."<br \>";
            echo 'Error:' .mysql_error()."<br \>";
            // die('Error:' .mysql_error());
        }
    }
    fclose($fd);


    // Insert Review table
    $fd = fopen("yelp_academic_dataset_review_1.json", "r"); 
    while (!feof($fd)) { 
        $line = fgets($fd, 10000); 
        $data = json_decode($line, true);
        $business_id = $data['review_id'];
        $user_id = $data['user_id'];
        $stars = $data['stars'];
        $text = mysql_real_escape_string($data['text']);
        $date = $data['date'];
        $sql = "INSERT INTO Business_Review(Business_ID, User_ID, Stars, Text, Date)
                VALUES('$business_id', '$user_id', '$stars', '$text', '$date')";
        if(!mysql_query($sql, $con)) {
            echo "Error: ".$sql."<br \>";
            echo 'Error:' .mysql_error()."<br \>";
            // die('Error:' .mysql_error());
        }
    } 
    fclose($fd);


    // Insert Check_In table
    $fd = fopen("yelp_academic_dataset_checkin_1.json", "r"); 
    while (!feof($fd)) {
        $line = fgets($fd, 1024); 
        $data = json_decode($line, true);
        $business_id = $data['business_id'];
        $monday = $data['checkin_info']['Mon'];
        $tuesday = $data['checkin_info']['Tue'];
        $wednesday = $data['checkin_info']['Wed'];
        $thursday = $data['checkin_info']['Thu'];
        $friday = $data['checkin_info']['Fri'];
        $saturday = $data['checkin_info']['Sat'];
        $sunday = $data['checkin_info']['Sun'];
        $sql = "INSERT INTO Check_In(Business_ID, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday)
                VALUES('$business_id', '$monday', '$tuesday', '$wednesday', '$thursday', '$friday', '$saturday', '$sunday')";
        if(!mysql_query($sql, $con)) {
            echo "Error: ".$sql."<br \>";
            echo 'Error:' .mysql_error()."<br \>";
            // die('Error:' .mysql_error());
        }
    }
    fclose($fd);

    echo 'done! <br \>';
?>
