<?php
session_start();
include "./db_conn.php";

$searchUser = trim($_POST["search_user"]);

if (strlen($searchUser) > 30) {
    alertAndBack("입력 값이 너무 깁니다."); // alertBack 에 참조대로 아래 메시지 변수에서 출력
}

if (preg_match('/[\'";#-]/', $searchUser) ) {
    echo "<script>alert('pleas don't try');</script>";
    exit;
}

$ppstm = $conn->prepare("SELECT * FROM users WHERE user_id=?");
$ppstm->bind_param("s", $searchUser);

if (!$ppstm->execute()) {
    error_log("SQL Error: " . mysqli_error($conn));
    alertAndBack("시스템 오류가 발생했습니다.");
}

$result = $ppstm->get_result();
if ($result->num_rows == 0) {
    alertAndBack("일치하는 아이디가 없습니다.");
} else {
    alertAndBack("사용자가 존재합니다.");
}

function alertAndBack($message) { // 위에서 정항대로 출력된다. 
    echo "<script>
            alert(\"$message\");
            history.back();
          </script>";
    exit;
}
?>

