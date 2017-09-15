<?php
/*
Semester Tracker
Public Holiday Dates controller
Author: Elise Allen
Date: September 2017

Required includes:
inc/connect.inc.php
inc/error.html.php
publicHolidays.html.php
*/

include 'inc/connect.inc.php'; //connection details (keep secure)

try {
    if (isset($_POST['addHol'])) {
        //Add the specified holiday details to the database
        $sql = "INSERT INTO PubHol (holName, holDate)
        VALUES (:name, :holDate)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':holDate', $holDate);

        $name = $_POST['holName'];
        $holDate = $_POST['holDate'];
        $stmt->execute();
    }

    $sql = "SELECT * FROM PubHol";
    $stmt1 = $pdo->prepare($sql);
    $stmt1->execute();

    $stmt1->bindColumn(2, $holName);
    $stmt1->bindColumn(3, $hDate);

    $now = new DateTime();
    $thisYear = $now->format('Y');

    include 'publicHolidays.html.php';
    
} catch (PDOException $e) {
    $error = 'Something failed';
    include 'inc/error.html.php';
    exit();
}