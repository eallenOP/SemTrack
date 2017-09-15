<?php
include 'inc/head.html.php';
?>

<div class="row">
    <h1>Public Holiday Management</h1>
</div>

<div class="row">
    <form action="pubHolControl.php" method="POST">
        <fieldset>
            <legend>Add new holiday</legend>
            <div class="large-3 columns">
                <label>Date:
                    <input type="date" name="holDate" value="" />
                </label>
            </div>
            <div class="large-6 columns">
                <label>Holiday name:
                    <input type="text" name="holName" value="" />
                </label>
                <button type="submit" class="button small" name="addHol" value="addHol">Add Holiday</button>
            </div>
        </fieldset>
    </form>
</div>

<div class="row">
    <h3>Holidays added</h3>
    <table>
        <tr>
            <th>Holiday nae</th>
            <th>Date</th>
            <th>Edit</th>
        </tr>
        <?php
            $stmt1->fetch(PDO::FETCH_BOUND);
            do { 
                $hDate = new DateTime($hDate);
                $holDay = $hDate->format('l, d M, Y');
                ?>
                <tr>
                    <td><?= $holName; ?></td>
                    <td><?= $holDay;?></td>
                    <td>Edit / Delete</td>
                </tr>
        <?php } while ($stmt1->fetch(PDO::FETCH_BOUND)); ?>
    </table>
    </div>

<?php
include 'inc/foot.html.php';
?>