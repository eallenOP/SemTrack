<?php
include 'inc/head.html.php';
$self = strip_tags($_SERVER['PHP_SELF']);
?>

<div class="row">
    <h1>Edit Semester details</h1>
</div>

<div class="row">
    <form action="<?= $self ?>" method="POST">
        <fieldset>
        <input type="hidden" name="id" value="<?= $semID; ?>"/>

            <legend>Add new semester</legend>
            <div class="large-2 columns">
                <label for="semNum">Semester:</label>
                <label><input type="radio" name="semNum" value="1"> One</label>
                <label><input type="radio" name="semNum" value="2"> Two</label>
            </div>
            <div class="large-3 large-offset-1 columns">
                <label>Start date (a Monday):
                    <input type="date" name="semStart" value="<?= $start ?>" />
                </label>
            </div>
            <div class="large-3 columns">
                <label>End date (a Friday):
                    <input type="date" name="semEnd" value="<?= $end ?>" />
                </label>
            </div>
            <div class="large-12 columns">
                <br>
                <p>Mid-semester break</p>
            </div>
            <div class="large-3 columns">
                <label>Start date (a Monday):
                    <input type="date" name="breakStart" value="<?= $breakStart ?>" />
                </label>
            </div>
            <div class="large-3 columns">
                <label>End date (a Friday):
                    <input type="date" name="breakEnd" value="<?= $breakEnd ?>" />
                </label>
            </div>
            <div class="large-3 large-offset-3 columns">
            <button type="submit" class="button small right" name="editSem" value="editSem">Submit</button>
            </div>
        </fieldset>
    </form>
</div>