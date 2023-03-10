<?php
    require("config/db.php");

    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $query = "DELETE FROM tasks WHERE id = $id";
        mysqli_query($db, $query);
        header("Location: index.php");
        exit();
    }
?>