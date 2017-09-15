<!DOCTYPE html>
<head>
    <title>Error</title>
</head>
<body>
    <p>
        <?= $error ?><br><?= $e->getMessage(); ?>
    </p>
</body>
</html>
<!-- Goes with controller file containing:
catch (PDOException $e) {
    //Create my error message for creating table
    $error = 'Creating or populating table(s) failed';
    //Call the error page again
    include 'error.html.php';
    exit();
} -->