<?php
require_once('config.php');

function execute($sql)
{
    // Open connection to the database
    $con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    
    // Check connection
    if (!$con) {
        die('Connection failed: ' . mysqli_connect_error());
    }

    // Execute the query
    if (!mysqli_query($con, $sql)) {
        die('Error executing query: ' . mysqli_error($con));
    }

    // Close connection
    mysqli_close($con);
}

function executeResult($sql)
{
    // Open connection to the database
    $con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);

    // Check connection
    if (!$con) {
        die('Connection failed: ' . mysqli_connect_error());
    }

    // Execute the query
    $result = mysqli_query($con, $sql);
    if (!$result) {
        die('Error executing query: ' . mysqli_error($con) . ' SQL: ' . $sql);
    }

    // Fetch all rows
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Close connection
    mysqli_close($con);

    return $data;
}


function executeSingleResult($sql)
{
    // Open connection to the database
    $con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    
    // Check connection
    if (!$con) {
        die('Connection failed: ' . mysqli_connect_error());
    }

    // Execute the query
    $result = mysqli_query($con, $sql);
    if (!$result) {
        die('Error executing query: ' . mysqli_error($con));
    }

    // Fetch single row
    $row = mysqli_fetch_assoc($result);

    // Close connection
    mysqli_close($con);

    return $row;
}
