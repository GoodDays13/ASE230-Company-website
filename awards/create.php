<?php
include_once '../lib/entities.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new AwardRepository();
    $database->create($_POST);
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Create award</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- favicon -->
    <link rel="shortcut icon" href="images/favicon.ico" />

    <!-- css -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
    <link href="../css/style.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="container">
        <h1>Create award</h1>
    </div>
    <div class="container">
        <form action="create.php" method="post">
            <div class="form-group">
                <label for="Year">Year</label>
                <input type="text" class="form-control" id="Year" name="Year">
            </div>
            <div class="form-group">
                <label for="Description">Description</label>
                <input type="text" class="form-control" id="Description" name="Description">
            </div>
            <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </form>
    </div>
</body>

</html>
