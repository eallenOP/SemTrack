<?php
include 'inc/head.html.php';
?>

<div class="row">
    <h1>Course Management</h1>
</div>

<div class="row">
    <form action="courseControl.php" method="POST">
        <fieldset>
            <legend>Add new course</legend>
            <div class="large-3 columns">
                <label>Course Code:
                    <input type="text" name="courseID" placeholder="e.g. IN501">
                </label>
            </div>
            <div class="large-5 columns">
                <label>Course Name:
                    <input type="text" name="courseName" placeholder="e.g. Professional Practice 1">
                </label>
            </div>
            <div class="large-3 large-offset-1 columns">
            <button type="submit" class="button small right" name="addCourse" value="addCourse">Add Course</button>
            </div>
        </fieldset>
    </form>
</div>

<div class="row">
    <h3>Courses added</h3>
    <table>
        <tr>
            <th>Code</th>
            <th>Course name</th>
            <th>Edit</th>
        </tr>
        <?php
            $stmt1->fetch(PDO::FETCH_BOUND);
            do { ?>
                <tr>
                    <td><?= $courseCode; ?></td>
                    <td><?= $courseName; ?></td>
                    <td>Edit / Delete</td>
                </tr>
        <?php } while ($stmt1->fetch(PDO::FETCH_BOUND)); ?>
    </table>
    </div>

<?php
include 'inc/foot.html.php';
?>