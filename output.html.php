<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="http://cdn.foundation5.zurb.com/foundation.css">
    <link rel="stylesheet" href="app.css">
    <title>Confirm data</title>
</head>
<body>
    <div class="row">
        <h1>All data</h1>
        <!-- Course-semester table -->
        <table class="full-width">
            <tr>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Semester</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Hols start</th>
                <th>Hols End</th>
            </tr>
            <?php
                $stmt1->fetch(PDO::FETCH_BOUND);
                do { ?>
                <tr>
                    <td><?= $courseCode; ?></td>
                    <td><?= $courseName; ?></td>
                    <td><?= $semNum; ?></td>
                    <td><?= $start; ?></td>
                    <td><?= $end; ?></td>
                    <td><?= $hStart; ?></td>
                    <td><?= $hEnd; ?></td>
                </tr>
            <?php } while ($stmt1->fetch(PDO::FETCH_BOUND)); ?>
        </table>
        <!-- Holidays table -->
        <table class="full-width">
            <tr>
                <th>Date</th>
                <th>Holiday Name</th>
            </tr>
            <?php
                $stmt2->fetch(PDO::FETCH_BOUND);
                do { ?>
                <tr>
                    <td><?= $pDate; ?></td>
                    <td><?= $pName; ?></td>
                </tr>
            <?php } while ($stmt2->fetch(PDO::FETCH_BOUND)); ?>
        </table>
        <!-- Assignments table -->
        <table class="full-width">
            <tr>
                <th>Assignment</th>
                <th>Course Name</th>
                <th>Due date</th>
                <th>Start Date</th>
            </tr>
            <?php
                $stmt3->fetch(PDO::FETCH_BOUND);
                do { ?>
                <tr>
                    <td><?= $aName; ?></td>
                    <td><?= $aCourseName; ?></td>
                    <td><?= $due; ?></td>
                    <td><?= $aStart; ?></td>
                </tr>
            <?php } while ($stmt3->fetch(PDO::FETCH_BOUND)); ?>
        </table>
    </div>
</body>
</html>