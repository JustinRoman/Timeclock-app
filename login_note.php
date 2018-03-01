<?php
    session_start();
    require('connection.php');
    $login_note = $_POST['note_on_login'];

    if(empty($login_note)) {
        echo "
            <script>alert ('Empty Fields!') </script>
	        window.location.href = \"index.php\"
        ";
		die();
    } else {
        $insert_login_note = $conn->prepare("INSERT INTO notes VALUES ('', ?, '1', ?, now())");
        $insert_login_note->execute([$_SESSION['employee_id'], $login_note]);    

        header('location: index.php');
    }
?>
