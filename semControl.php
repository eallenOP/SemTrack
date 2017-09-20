<?php
/*
Semester Tracker
Home page controller
Author: Elise Allen
Date: September 2017

Required includes:
inc/connect.inc.php
inc/error.html.php
index.php
*/

date_default_timezone_set('Pacific/Auckland');

include 'inc/connect.inc.php'; //connection details (keep secure)

try {
    
    //Set up semester table
    if (isset($_POST['pickSem']) && $_POST['semester'] != 'none') {
        $semester = $_POST['semester'];
        $sql = "SELECT * FROM Semester WHERE semID = $semester";
    } else {
        $sql = "SELECT * FROM Semester WHERE NOW() BETWEEN startDate AND endDate";
    }
    
    $stmt1 = $pdo->prepare($sql);
    $stmt1->execute();
    
    $stmt1->bindColumn(2, $startDate);
    $stmt1->bindColumn(3, $endDate);
    $stmt1->bindColumn(4, $breakStart);
    $stmt1->bindColumn(5, $breakEnd);
    $stmt1->bindColumn(6, $semNum);
    
    $stmt1->fetch();
    $startDate = new DateTime($startDate);
    $startDay = $startDate->format('l, d M');
    $startYear = $startDate->format('Y');
    $end = new DateTime($endDate);
    $endDay = $end->format('l, d M');
    $breakStart = new DateTime($breakStart);
    $breakEnd = new DateTime($breakEnd);
    $holFinish = $breakEnd->format('l, d M Y');
    $theseHols = $breakStart->format('l, d M') . " to {$holFinish}";
    
    //Welcome paragraph
    $sql = "SELECT startDate FROM Semester WHERE NOW() BETWEEN startDate AND endDate";
    $stmt =  $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    $stmt->bindColumn(1, $thisSemStartDate);

    $stmt->fetch();
    $thisSemStartDate = new DateTime($thisSemStartDate);
    $now = new DateTime();
    $today = $now->format('l');
    $weekNumber = 0;

    for ($i = $thisSemStartDate; $i < $now; $i->modify('+7 days')) { //loop over weeks of the semester
        //only deal with teaching weeks
        if ($i->getTimestamp() < $breakStart->getTimestamp() || $i->getTimestamp() > $breakEnd->getTimestamp()) { 
            $weekNumber++; //New week 
        }
    }

    //Set up assignments table
    $sql = "SELECT c.courseName, a.name, a.duration, a.weekDue, a.dayDue  FROM Assignment a
            JOIN Course c
            ON a.courseID = c.courseID
            ORDER BY a.weekDue";
    $stmt2 = $pdo->prepare($sql);
    $stmt2->execute();

    $stmt2->bindColumn(1, $cName);
    $stmt2->bindColumn(2, $aName);
    $stmt2->bindColumn(3, $aStart); //duration indicates assignment start date
    $stmt2->bindColumn(4, $aWeek);
    $stmt2->bindColumn(5, $aDayDue);

    //Build data for weeks table
    $sql = "SELECT holName, holDate FROM PubHol";
    $stmt3 = $pdo->prepare($sql);
    $stmt3->execute();

    $stmt3->bindColumn(1, $holName);
    $stmt3->bindColumn(2, $holDate);

    $week = 0;
    $arrayHol = array();
    while ($stmt3->fetch(PDO::FETCH_BOUND)) {
        $arrayHol[$holName] = $holDate;
    }
 
    //Set up semester pick drop down
    $sql = "SELECT semID, YEAR(startDate), semNum FROM Semester";
    $stmt4 = $pdo->prepare($sql);
    $stmt4->execute();

    $stmt4->bindColumn(1, $semID);
    $stmt4->bindColumn(2, $semDate);
    $stmt4->bindColumn(3, $semNumber);
    
    include 'index.php';

} catch (PDOException $e) {
    $error = 'Something failed';
    include 'inc/error.html.php';
    exit();
}