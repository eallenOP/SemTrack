<?php
include 'inc/head.html.php';
?>

<div class="row">
    <h1>Semester Management</h1>
</div>

<div class="row">
    <form action="semDates.php" method="POST">
        <fieldset>
            <legend>Add new semester</legend>
            <div class="large-2 columns">
                <label for="semNum">Semester:</label>
                <label><input type="radio" name="semNum" value="1"> One</label>
                <label><input type="radio" name="semNum" value="2"> Two</label>
            </div>
            <div class="large-3 columns">
                <label>Year:
                    <input type="number" name="year" value="<?= $thisYear ?>" />
                </label>
            </div>
            <div class="large-3 large-offset-1 columns">
                <label>Start date (a Monday):
                    <input type="date" name="semStart" value="" />
                </label>
            </div>
            <div class="large-3 columns">
                <label>End date (a Friday):
                    <input type="date" name="semEnd" value="" />
                </label>
            </div>
            <div class="large-12 columns">
                <br>
                <p>Mid-semester break</p>
            </div>
            <div class="large-3 columns">
                <label>Start date (a Monday):
                    <input type="date" name="holStart" value="" />
                </label>
            </div>
            <div class="large-3 columns">
                <label>End date (a Friday):
                    <input type="date" name="holEnd" value="" />
                </label>
            </div>
            <div class="large-3 large-offset-3 columns">
            <button type="submit" class="button small right" name="addSem" value="addSem">Add Semester</button>
            </div>
        </fieldset>
    </form>
</div>

<div class="row">
    <h3>Semesters added</h3>
    <table>
        <tr>
            <th>Semester</th>
            <th>Start date</th>
            <th>End date</th>
            <th>Holidays</th>
            <th>Edit</th>
        </tr>
        <?php
            $stmt1->fetch(PDO::FETCH_BOUND);
            do { 
                $startDate = new DateTime($startDate);
                $startDay = $startDate->format('l, d M');
                $startYear = $startDate->format('Y');
                $end = new DateTime($endDate);
                $endDay = $end->format('l, d M');
                $holStart = new DateTime($holStart);
                $holEnd = new DateTime($holEnd);
                $holFinish = $holEnd->format('l, d M Y');
                $theseHols = $holStart->format('l, d M') . " to {$holFinish}";
                ?>
                <tr>
                    <td><?= $semNum; ?>, <?= $startYear; ?></td>
                    <td><?= $startDay; ?></td>
                    <td><?= $endDay;?></td>
                    <td><?= $theseHols; ?></td>
                    <td>Edit / Delete</td>
                </tr>
        <?php } while ($stmt1->fetch(PDO::FETCH_BOUND)); ?>
    </table>
    </div>

<?php
include 'inc/foot.html.php';
?>