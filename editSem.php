<?php
/*
Semester Tracker
Edit semester controller
Author: Elise Allen
Date: September 2017

Required includes:
inc/connect.inc.php
inc/error.html.php
editSemForm.html.php
*/

include 'inc/connect.inc.php'; //connection details (keep secure)

try {
    //Get the right ID from GET

    //Retrieve information from database

    //Populate the edit form with the current details

    //If submit clicked, update the database with form contents

    include 'editSemForm.html.php';

} catch (PDOException $e) {
    $error = 'Something failed';
    include 'inc/error.html.php';
    exit();
}