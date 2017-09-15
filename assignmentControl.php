<?php
/*
Semester Tracker
Assignments controller
Author: Elise Allen
Date: September 2017

Required includes:
inc/connect.inc.php
inc/error.html.php
courses.html.php
*/

include 'inc/connect.inc.php'; //connection details (keep secure)

try {
    if (isset($_POST['addAssignment'])) {
        //Add the specified semester details to the database
        $sql = "INSERT INTO Assignment (name, courseID, weekDue, dayDue, duration)
        VALUES (:name, :course, :week, :day, :duration)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':course', $course);
        $stmt->bindParam(':week', $week);
        $stmt->bindParam(':day', $day);
        $stmt->bindParam(':duration', $duration);

        $name = $_POST['aName'];
        $course = $_POST['courseID'];
        $week = $_POST['weekDue'];
        $day = $_POST['dayDue'];
        $duration = $_POST['duration'];
        $stmt->execute();
    }

    $sql = "SELECT * FROM Course";
    $stmt1 = $pdo->prepare($sql);
    $stmt1->execute();

    $stmt1->bindColumn(1, $courseID);
    $stmt1->bindColumn(2, $courseName);

    $sql = "SELECT * FROM Assignment a
            JOIN Course c
            ON a.courseID = c.courseID";
    $stmt2 = $pdo->prepare($sql);
    $stmt2->execute();

    $stmt2->bindColumn(2, $aName);
    $stmt2->bindColumn(3, $courseID);
    $stmt2->bindColumn(4, $weekDue);
    $stmt2->bindColumn(5, $dayDue);
    $stmt2->bindColumn(6, $duration);
    $stmt2->bindColumn(8, $courseName);
    
    include 'assignments.html.php';
    
} catch (PDOException $e) {
    $error = 'Something failed';
    include 'inc/error.html.php';
    exit();
}