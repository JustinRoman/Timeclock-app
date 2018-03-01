<?php
    require('connection.php');

    try {
        session_start();
          
        $time_out = $conn->prepare("UPDATE breaks SET break_end = now(), note = ? WHERE id = ? AND employee_id = ?");
        $time_out->execute([$_POST['note'], $_SESSION['temp_break_id'], $_SESSION['employee_id']]);

        header('location: index.php');

    } catch(PDOException $e) {
        echo $e->getMessage();
    }
?>