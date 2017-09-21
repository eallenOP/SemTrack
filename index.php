<?php
/*
Semester Tracker
Home page controller
Author: Elise Allen
Date: September 2017

Required includes:
inc/connect.inc.php
inc/error.html.php
homepage.php
*/

<<<<<<< HEAD
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
=======
<div class="row">
    <h2>Semester dates</h2>
    <table>
        <tr>
            <th>Semester</th>
            <th>Start date</th>
            <th>End date</th>
            <th>Holidays</th>
        </tr>
        <?php
            $stmt1->fetch(PDO::FETCH_BOUND);
            do { ?>
                <tr>
                    <td><?= $semNum; ?>, <?= $startYear; ?></td>
                    <td><?= $startDay; ?></td>
                    <td><?= $endDay;?></td>
                    <td><?= $theseHols; ?></td>
                </tr>
        <?php } while ($stmt1->fetch(PDO::FETCH_BOUND)); ?>
    </table>
    <h2>Assignments</h2>
    <table>
        <tr>
            <th>Course</th>
            <th>Assignment</th>
            <th>Start date</th>
            <th>Due day</th>
            <th>Due date</th>
        </tr>
        <?php
        $stmt2->fetch(PDO::FETCH_BOUND);
        //Build table
        do { 
            //Use day of the week and week number to find due date
            $dateString = $startDate->format('d-m-Y') . '+' . ($aWeek - 1) . ' weeks'; // start date plus assignment week due
            $aDueWeek = new DateTime($dateString);
            if ($aDueWeek->getTimestamp() > $breakEnd->getTimestamp()) {
                $aDueWeek->modify('+ 2 weeks');
            } 
            if ($aDayDue != 'Monday') {
                //Find the next $aDayDue after $aDueWeek 
                $dateString = 'first '. $aDayDue . " " . $aDueWeek->format('d-m-Y');
                $dueDate = new DateTime($dateString);
            } else {
                $dueDate = $aDueWeek;
            }
            $dueDate = $dueDate->format('d M Y');
            $dateString = $aDueWeek->format('d-m-Y') . '-' . $aStart . ' days';
            $aStart = new DateTime($dateString);
            $aStart = $aStart->format('l, d M');
            ?>
                <tr>
                    <td><?= $cName; ?></td>
                    <td><?= $aName; ?></td>
                    <td><?= $aStart; ?></td>
                    <td><?= $aDayDue . ", week " . $aWeek ?></td>
                    <td><?= $dueDate ?></td>
                </tr>
        <?php } while ($stmt2->fetch(PDO::FETCH_BOUND)); ?>
    </table>
    <h2>Semester weeks</h2>
    <table>
        <tr>
            <th>Week</th>
            <th>Mon date</th>
            <th>Holiday</th>
        </tr>
        <?php 
        //Loop over weeks of the semester
        for ($i = $startDate; $i < $end; $i->modify('+7 days')) { 
            //only deal with teaching weeks
            if ($i->getTimestamp() < $breakStart->getTimestamp() || $i->getTimestamp() > $breakEnd->getTimestamp()) { 
                $week ++; //New week ?>
                <tr>
                    <td><?= $week; ?></td>
                    <td><?= $i->format('d M'); //Print out Monday's date ?></td>
                    <td>
                        <?php 
                        //Check if there's a public holiday this week
                        $iEnd = new DateTime($i->format('d-m-Y') . ' + 7 days'); //Set Sunday
                        foreach ($arrayHol as $holName => $holDate) { 
                            $holiday = new DateTime($holDate);
                            if ($holiday->getTimestamp() >= $i->getTimestamp() && $holiday->getTimestamp() < $iEnd->getTimestamp()) {
                               echo "{$holName}, {$holiday->format('l d M')} "; // give the name and date of the holiday
                           }
                        } ?>
                    </td>
                <?php 
                } else { ?>
                    <td></td>
                    <td><?= $i->format('d M'); //Print out Monday's date ?></td>
                    <td>Semester holidays</td>
                <?php } ?>
                </tr>
        <?php } ?>
    </table>
</div>
>>>>>>> f2f695ff174a5860e3b94bf43132269839f6355b

    //Set up assignments table
    $sql = "SELECT c.courseName, a.name, a.duration, a.weekDue, a.dayDue  FROM Assignment a
            JOIN Course c
            ON a.courseID = c.courseID
            ORDER BY a.weekDue";
    $stmt2 = $pdo->prepare($sql);
    $stmt2->execute();

    $stmt2->bindColumn(1, $cName);
    $stmt2->bindColumn(2, $aName);
    $stmt2->bindColumn(3, $aStart); //duration
    $stmt2->bindColumn(4, $aWeek);
    $stmt2->bindColumn(5, $aDayDue);

    //Build data for weeks table
    $sql = "SELECT holName, holDate FROM PubHol";
    $stmt3 = $pdo->prepare($sql);
    $stmt3->execute();

    $stmt3->bindColumn(1, $holName);
    $stmt3->bindColumn(2, $holDate);

 
    // $holiday = new DateTime($holDate);

    //Set up semester pick drop down
    $sql = "SELECT semID, YEAR(startDate), semNum FROM Semester";
    $stmt4 = $pdo->prepare($sql);
    $stmt4->execute();

    $stmt4->bindColumn(1, $semID);
    $stmt4->bindColumn(2, $semDate);
    $stmt4->bindColumn(3, $semNumber);
    
    include 'homepage.php';

} catch (PDOException $e) {
    $error = 'Something failed';
    include 'inc/error.html.php';
    exit();
}