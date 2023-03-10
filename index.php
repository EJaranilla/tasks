<?php
    require("config/db.php");
    require("script/filter.js");
    require("css/index.css");


    if (!isset($_GET['mode']) || $_GET['mode'] == 'view') {
        $filter_options = array('All', 'Incomplete', 'In Progress', 'Completed');
        $filter_selected = isset($_GET['filter']) ? $_GET['filter'] : 'All';

        if ($filter_selected != 'All') {
            $query = "SELECT * FROM tasks WHERE task_status = '$filter_selected'";
        } else {
            $query = "SELECT * FROM tasks";
        }
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) > 0) {
            echo "<div style='display:flex; align-items: center; justify-content: space-between;'>";
            echo "<div id = 'label1'><strong>Filter:</strong> ";
            echo "<select id='filter' name='filter' onchange='filterTasks()'>";
            foreach ($filter_options as $option) {
                if ($filter_selected == $option) {
                    echo "<option value='$option' selected>$option</option>";
                } else {
                    echo "<option value='$option'>$option</option>";
                }
            }
            echo "</select></div>";
            echo "<div><button type='button' onclick=\"location.href='index-add.php'\">Add Task</button></div>";
            echo "</div>";

            echo "<table id = 'table1'>";
            echo "<tr>
                    <th>ID</th>
                    <th>Task Name</th>
                    <th>Task Description</th>
                    <th>Task Due Date</th>
                    <th>Task Status</th>
                    <th>Actions</th>
                </tr><br>";
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['task_name'] . "</td>";
                    echo "<td>" . $row['task_description'] . "</td>";
                    echo "<td>" . $row['task_due_date'] . "</td>";
                    echo "<td>" . $row['task_status'] . "</td>";
                    echo "<td>";
                        echo "<form style='display:inline-block' action='index-edit.php?id=" . $row['id'] . "' method='post'>";
                            echo "<button type='submit' name='edit'>Edit</button>";
                        echo "</form>";

                        echo "<form style='display:inline-block' action='index-delete.php' method='post' onsubmit='return confirm(\"Are you sure you want to delete this task?\")'>";
                            echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                            echo "<button type='submit' name='delete'>Delete</button>";
                        echo "</form>";
                    echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<script>alert('No task found'); window.location.href='index.php';</script>";
        }
    }
?>