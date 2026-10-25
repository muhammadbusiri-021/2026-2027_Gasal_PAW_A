<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Process Data</title>
</head>
<body>
    <h3>Posted data:</h3>
    <?php
    foreach ($_POST as $key => $value){
        echo "($key) => ($value) <br/>";
    }

    require 'validate.inc'; 
    $errors = array();
    validateName($errors, $_POST, 'surname'); 

    if ($errors) {
        echo 'Errors:<br/>';
        foreach ($errors as $field => $error) {
            echo "$field $error<br/>";
        }
    } else {
        echo 'Data OK!';
    }
    ?>
</body>
</html>