<?php
include 'inc/head.html.php';
?>

<div class="row">
    <h1>Assignment Management</h1>
</div>

<div class="row">
    <form action="assignmentControl.php" method="POST">
        <fieldset>
            <legend>Add new assignment</legend>
            <div class="large-5 columns">
                <label>Assignment name:
                    <input type="text" name="aName" placeholder="e.g. Essay">
                </label>
            </div>
            <div class="large-3 columns">
                <label>Day due:
                    <select name="dayDue">
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                    </select>
                </label>
            </div>
            <div class="large-3 columns">
                <label>Week due:
                    <input type="number" name="weekDue">
                </label>
            </div>
            <div class="large-5 columns">
                <label>Select course:
                    <select name="courseID">
                        <?php $stmt1->fetch(PDO::FETCH_BOUND);
                            do { ?>
                                <option value="<?= $courseID ?>"><?= $courseName ?></option>
                            <?php } while ($stmt1->fetch(PDO::FETCH_BOUND)); ?>
                    </select>
                </label>
            </div>
                <div class="large-3 columns">
                    <label>Assignment duration (days):
                        <input type="number" name="duration">
                    </label>
                </div>
            <div class="large-3 columns">
                <button type="submit" class="button small" name="addAssignment" value="addAssignment">Add Assignment</button>
            </div>
        </fieldset>
    </form>
</div>

<div class="row">
    <h3>Assignments added</h3>
    <table>
        <tr>
            <th>Assignment name</th>
            <th>Course</th>
            <th>Week due</th>
            <th>Day due</th>
            <th>Duration</th>
            <th>Edit</th>
        </tr>
        <?php
            $stmt2->fetch(PDO::FETCH_BOUND);
            do { ?>
                <tr>
                    <td><?= $aName; ?></td>
                    <td><?= $courseID . " " . $courseName; ?></td>
                    <td><?= $weekDue; ?></td>
                    <td><?= $dayDue; ?></td>
                    <td><?= $duration; ?> days</td>
                    <td>Edit / Delete</td>
                </tr>
        <?php } while ($stmt2->fetch(PDO::FETCH_BOUND)); ?>
    </table>
    </div>

<?php
include 'inc/foot.html.php';
?>