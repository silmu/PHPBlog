<?php
//Execute query on a specific username and fetch the result
function queryOnUser($query, $username){
    $objectDB = new DBConnect;
    $dbconn = $objectDB ->connect();
    $stmt = $dbconn->prepare($query);
    $stmt->execute([$username]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

//Execute query and return statement
function queryCheck($query){
    $objectDB = new DBConnect;
    $dbconn = $objectDB ->connect();
    $stmt = $dbconn->prepare($query);
    $selectResult = $stmt->execute();

    if(!$selectResult) {
        die('Query failed: ' . $query);
    }
    return $stmt;
}
?>