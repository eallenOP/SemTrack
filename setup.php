<?php
/*
Semester Tracker
Database setup file
Author: Elise Allen
Date: September 2017

Required includes:
inc/connect.inc.php
inc/error.html.php
output.html.php
*/

include 'inc/connect.inc.php'; //connection details (keep secure)

try {
    //remove this later
    $dropQuery = "DROP TABLE IF EXISTS Assignment"; 
    $pdo->exec($dropQuery);
    
    $dropQuery = "DROP TABLE IF EXISTS PubHol"; 
    $pdo->exec($dropQuery);
    
    $dropQuery = "DROP TABLE IF EXISTS CourseSem"; 
    $pdo->exec($dropQuery);
    
    $dropQuery = "DROP TABLE IF EXISTS Semester"; 
    $pdo->exec($dropQuery);

    $dropQuery = "DROP TABLE IF EXISTS Course"; 
    $pdo->exec($dropQuery);

    //Create tables
    $sql = "CREATE TABLE IF NOT EXISTS Course
    (
        courseID    VARCHAR(6) NOT NULL PRIMARY KEY,
        courseName  VARCHAR(30) NOT NULL
    )";
    $pdo->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS Semester
    (
        semID       INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        startDate   DATE NOT NULL,
        endDate     DATE NOT NULL,
        breakStart    DATE NOT NULL,
        breakEnd      DATE NOT NULL,
        semNum      INT(2) NOT NULL
    )";
    $pdo->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS CourseSem
    (
        courseSemID INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        courseID    VARCHAR(6) NOT NULL,
        semID       INT(6) NOT NULL,

        FOREIGN KEY (courseID) REFERENCES Course(courseID),
        FOREIGN KEY (semID)    REFERENCES Semester(semID)
    )";
    $pdo->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS PubHol
    (
        pubHolID    INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        holName     VARCHAR(30) NOT NULL,
        holDate     DATE
    )";
    $pdo->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS Assignment
    (
        assignmentID INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        name        VARCHAR(30) NOT NULL,
        courseID    VARCHAR(6) NOT NULL,
        weekDue     INT(6) NOT NULL,
        dayDue      VARCHAR(10) NOT NULL,
        duration    INT(6) NOT NULL,

        FOREIGN KEY (courseID) REFERENCES Course(courseID)
    )";
    $pdo->exec($sql);

    //Put in some initial data
    $sql = "INSERT INTO Course (courseID, courseName)
    VALUES (:courseID, :courseName)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':courseID', $ID);
    $stmt->bindParam(':courseName', $name);

    $ID = "IN501"; // a string: the course code
    $name = "Professional Practice 1";
    $stmt->execute();

    $sql = "INSERT INTO Semester (startDate, endDate, breakStart, breakEnd, semNum)
    VALUES (:start, :end, :hStart, :hEnd, :num)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':start', $start);
    $stmt->bindParam(':end', $end);
    $stmt->bindParam(':hStart', $hStart);
    $stmt->bindParam(':hEnd', $hEnd);
    $stmt->bindParam(':num', $num);

    $start = '2017-07-17'; // a date
    $end = '2017-11-17'; // a date
    $hStart = '2017-10-02'; // a date
    $hEnd = '2017-10-13'; // a date
    $num = 2; // a number (semester 1 or 2)
    $stmt->execute();

    $sql = "INSERT INTO CourseSem (courseID, semID)
    VALUES (:course, :semester)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':course', $course);
    $stmt->bindParam(':semester', $semester);

    $course = "IN501"; // a course code
    $semester = 1; // the semester ID
    $stmt->execute();

    $sql = "INSERT INTO PubHol (holName, holDate)
    VALUES (:name, :hDate)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':hDate', $hDate);

    $name = "Dale's Day";
    $hDate = '2017-08-25';
    $stmt->execute();

    $sql = "INSERT INTO Assignment (name, courseID, weekDue, dayDue, duration)
    VALUES (:name, :course, :week, :day, :duration)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':course', $course);
    $stmt->bindParam(':week', $week);
    $stmt->bindParam(':day', $day);
    $stmt->bindParam(':duration', $duration);

    $name = "Essay";
    $course = "IN501"; // a course code
    $week = 10; 
    $day = "Friday"; 
    $duration = 14; 
    $stmt->execute();

    //Confirm data
    $sql = "SELECT * FROM Course c
            JOIN CourseSem cs
            ON c.courseID = cs.courseID
            JOIN Semester s
            ON cs.semID = s.semID";
    $stmt1 = $pdo->prepare($sql);
    $stmt1->execute();

    $stmt1->bindColumn(1, $courseCode);
    $stmt1->bindColumn(2, $courseName);
    $stmt1->bindColumn(11, $semNum);
    $stmt1->bindColumn(7, $start);
    $stmt1->bindColumn(8, $end);
    $stmt1->bindColumn(9, $hStart);
    $stmt1->bindColumn(10, $hEnd);
    
    $sql = "SELECT * FROM PubHol";
    $stmt2 = $pdo->prepare($sql);
    $stmt2->execute();
    
    $stmt2->bindColumn(2, $pName);
    $stmt2->bindColumn(3, $pDate);
    
    $sql = "SELECT a.name, c.courseName, a.weekDue, a.dayDue, a.duration  FROM Course c
            JOIN Assignment a
            ON c.courseID = a.courseID";
    $stmt3 = $pdo->prepare($sql);
    $stmt3->execute();
    
    $stmt3->bindColumn(1, $aName); 
    $stmt3->bindColumn(2, $aCourseName);
    $stmt3->bindColumn(3, $aWeek);
    $stmt3->bindColumn(4, $aDay);
    $stmt3->bindColumn(5, $duration);

    $due = 0; // start date plus $sWeek weeks
    $aStart = 0; //due date minus $duration days
    
    //Display successful output
    include 'output.html.php';
    
} catch (PDOException $e) {
    $error = 'Something failed';
    include 'inc/error.html.php';
    exit();
}