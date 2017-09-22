<?php
/*
Semester Tracker
Edit semester controller
Author: Elise Allen
Date: September 2017

Required includes:
inc/connect.inc.php
inc/error.html.php
editSemForm.html.php
*/

include 'inc/connect.inc.php'; //connection details (keep secure)

try {
    //Get the right ID from URL
    $semID = $_GET['id'];

    //If submit clicked, update the database with form contents
    if (isset($_POST['editSem'])) {
        $sql = "UPDATE Semester
                SET 'semNum' = :num,
                    'startDate' = :start,
                    'endDate' = :end,
                    'breakStart' = :breakStart,
                    'breakEnd' = :breakEnd
                WHERE 'semID = $semID";
    }

    //Retrieve information from database
    $sql = "SELECT * FROM Semester WHERE semID = $semID";
    $result = $pdo->query($sql);
    $result = $result->fetch();

    //Populate the edit form with the current details
    $semNum = $result['semNum'];
    $start = $result['startDate'];
    $end = $result['endDate'];
    $breakStart = $result['holStart'];
    $breakEnd = $result['holEnd'];

    include 'editSemForm.html.php';

} catch (PDOException $e) {
    $error = 'Something failed';
    include 'inc/error.html.php';
    exit();
}