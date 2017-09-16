<?php
include 'inc/head.html.php';
?>

<div class="row">
    <h1>Semester Calendar</h1>
</div>
<div class="row">
    <form action="semControl.php" method="POST">
        <div class="large-4 columns">
            <div class="row collapse">
                <div class="small-10 columns">
                    <select name="semester">
                        <option value="none">Select semester</option>
                        <?php $stmt4->fetch(PDO::FETCH_BOUND);
                            do { 
                                ?>
                                <option value="<?= $semID ?>"><?= $semDate . " - " . $semNumber; ?></option>
                        <?php } while ($stmt4->fetch(PDO::FETCH_BOUND)); ?>
                    </select>
                </div>
                <div class="small-2 columns">
                    <button type="submit" class="button postfix" name="pickSem" value="pickSem">Go</button>
                </div>
            </div>
        </div>
    </form>
</div>

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
            if ($aDueWeek->getTimestamp() > $holEnd->getTimestamp()) {
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
        $week = 0;
        $arrayHol = array();
        while ($stmt3->fetch(PDO::FETCH_BOUND)) {
            $arrayHol[$holName] = $holDate;
        }
        //echo $holDate;
        for ($i = $startDate; $i < $end; $i->modify('+7 days')) { //loop over weeks of the semester
            if ($i->getTimestamp() < $holStart->getTimestamp() || $i->getTimestamp() > $holEnd->getTimestamp()) { //only deal with teaching weeks
                $week ++; //New week ?>
                <tr>
                    <td><?= $week; ?></td>
                    <td><?= $i->format('d M'); //Print out Monday's date ?></td>
                    <td>
                        <?php 
                        $iEnd = new DateTime($i->format('d-m-Y') . ' + 7 days');

                        foreach ($arrayHol as $holName => $holDate) { //Check if there's a public holiday this week
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

<?php
include 'inc/foot.html.php';
?>