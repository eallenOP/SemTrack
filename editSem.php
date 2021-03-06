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
    
    //If submit clicked, update the database with form contents
    if (isset($_POST['editSem'])) {
        $ID = $_POST['id'];
        $num = $_POST['semNum'];
        $start = $_POST['semStart'];
        $end = $_POST['semEnd'];
        $breakStart = $_POST['breakStart'];
        $breakEnd = $_POST['breakEnd'];

        $sql = "UPDATE Semester
                SET semNum = :num,
                    startDate = :start,
                    endDate = :end,
                    holStart = :breakStart,
                    holEnd = :breakEnd
                WHERE semID = $ID";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':num', $num);
        $stmt->bindParam(':start', $start);
        $stmt->bindParam(':end', $end);
        $stmt->bindParam(':breakStart', $breakStart);
        $stmt->bindParam(':breakEnd', $breakEnd);
        $stmt->execute();

        include 'semDates.php';
    } else {

        //Get the right ID from URL
        $semID = $_GET['id'];
    
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
    }
    

} catch (PDOException $e) {
    $error = 'Something failed';
    include 'inc/error.html.php';
    exit();
}