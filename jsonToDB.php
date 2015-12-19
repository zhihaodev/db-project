<?php
    $server = 'localhost';
    $username = 'root';
    $dbname = 'yelp';

    $con = mysql_connect($server, $username, $dbname) or die('Connection failed: ' . mysql_error());
    mysql_select_db($dbname, $con);
    echo 'Inserting Business table... <br \>';

    $lines = file("yelp_academic_dataset_business_1.json");
    foreach($lines as $line) {
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
                VALUES('$business_id', '$name', '$address', '$city', '$state', '$latitude', '$longitude', '$Stars')";
        if(!mysql_query($sql, $con)) {
            die('Error:' .mysql_error());
        }

        $attributes = $data['attributes'];
        if (!empty(attributes)) {
            foreach ($attributes as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $key2 => $value2) {
                        if ($value2 == 'true') {
                            $sql = "INSERT INTO Business_Attributes(Business_ID, Attribute, value)
                                    VALUES('$business_id', '$key', '$key2')";
                            if(!mysql_query($sql, $con)) {
                                die('Error:' .mysql_error());
                            }
                            break;
                        }
                    }
                } else {
                    $sql = "INSERT INTO Business_Attributes(Business_ID, Attribute, value)
                            VALUES('$business_id', '$key', '$value')";
                    // if(!mysql_query($sql, $con)) {
                    //     die('Error:' .mysql_error());
                    // }
                }
            }
        }
    }

    echo 'Inserting User table... <br \>';
    $lines = file("yelp_academic_dataset_user_1.json");
    foreach($lines as $line) {
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
            die('Error:' .mysql_error());
        }
    }

    echo 'done! <br \>';
?>
