<?php
/*
Semester Tracker
Semester Dates controller
Author: Elise Allen
Date: September 2017

Required includes:
inc/connect.inc.php
inc/error.html.php
semesters.html.php
*/

include 'inc/connect.inc.php'; //connection details (keep secure)

try {
    if (isset($_POST['addSem'])) {
        //Add the specified semester details to the database
        $sql = "INSERT INTO Semester (startDate, endDate, holStart, holEnd, semNum)
        VALUES (:start, :end, :hStart, :hEnd, :num)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':start', $start);
        $stmt->bindParam(':end', $end);
        $stmt->bindParam(':hStart', $hStart);
        $stmt->bindParam(':hEnd', $hEnd);
        $stmt->bindParam(':num', $num);

        $start = $_POST['semStart']; // a date
        $end = $_POST['semEnd']; // a date
        $hStart = $_POST['holStart']; // a date
        $hEnd = $_POST['holEnd']; // a date
        $num = $_POST['semNum']; // a number (semester 1 or 2)
        $stmt->execute();
    }

    $sql = "SELECT * FROM Semester";
    $stmt1 = $pdo->prepare($sql);
    $stmt1->execute();

    $stmt1->bindColumn(2, $startDate);
    $stmt1->bindColumn(3, $endDate);
    $stmt1->bindColumn(4, $holStart);
    $stmt1->bindColumn(5, $holEnd);
    $stmt1->bindColumn(6, $semNum);

    $now = new DateTime();
    $thisYear = $now->format('Y');

    include 'semesters.html.php';
    
} catch (PDOException $e) {
    $error = 'Something failed';
    include 'inc/error.html.php';
    exit();
}