<?php
require("config/db.php");

$query = "SET @autoid :=0";
mysqli_query($db, $query);
$query = "UPDATE tasks SET id = @autoid := (@autoid+1)";
mysqli_query($db, $query);
$query = "ALTER TABLE tasks AUTO_INCREMENT = 1";
mysqli_query($db, $query);

if (isset($_POST['submit'])) {
    $task_id = $_POST['task_id'];
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];
    $task_due_date = $_POST['task_due_date'];
    $task_status = $_POST['task_status'];

    $query = "UPDATE tasks SET task_name='$task_name', task_description='$task_description', task_due_date='$task_due_date', task_status='$task_status' WHERE id='$task_id'";
    mysqli_query($db, $query);

    header("Location: index.php");
    exit();
} else {
    $task_id = $_GET['id'];
    $query = "SELECT * FROM tasks WHERE id='$task_id'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);

    echo "<form action='index-edit.php' method='post'>";
    echo "<input type='hidden' name='task_id' value='" . $row['id'] . "'>";
    echo "<label>Task Name:</label>";
    echo "<input type='text' name='task_name' value='" . $row['task_name'] . "'>";
    echo "<label>Task Description:</label>";
    echo "<textarea name='task_description'>" . $row['task_description'] . "</textarea>";
    echo "<label>Task Due Date:</label>";
    echo "<input type='date' name='task_due_date' value='" . $row['task_due_date'] . "'>";
    echo "<label>Task Status:</label>";
    echo "<select name='task_status'>";
    echo "<option value='Incomplete'" . ($row['task_status'] == 'Incomplete' ? ' selected' : '') . ">Incomplete</option>";
    echo "<option value='In Progress'" . ($row['task_status'] == 'In Progress' ? ' selected' : '') . ">In Progress</option>";
    echo "<option value='Completed'" . ($row['task_status'] == 'Completed' ? ' selected' : '') . ">Completed</option>";
    echo "</select>";
    echo "<button type='submit' name='submit'>Save Changes</button>";
    echo "</form>";
}
?>