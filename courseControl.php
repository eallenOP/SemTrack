<?php
/*
Semester Tracker
Courses controller
Author: Elise Allen
Date: September 2017

Required includes:
inc/connect.inc.php
inc/error.html.php
courses.html.php
*/

include 'inc/connect.inc.php'; //connection details (keep secure)

try {
    if (isset($_POST['addCourse'])) {
        //Add the specified semester details to the database
        $sql = "INSERT INTO Course (courseID, courseName)
        VALUES (:code, :name)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':name', $name);

        $code = $_POST['courseID'];
        $name = $_POST['courseName'];
        $stmt->execute();
    }

    $sql = "SELECT * FROM Course";
    $stmt1 = $pdo->prepare($sql);
    $stmt1->execute();

    $stmt1->bindColumn(1, $courseCode);
    $stmt1->bindColumn(2, $courseName);
    
    include 'courses.html.php';
    
} catch (PDOException $e) {
    $error = 'Something failed';
    include 'inc/error.html.php';
    exit();
}