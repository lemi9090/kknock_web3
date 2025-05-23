<?php

include "./db_conn.php";
if ($conn === false) {
    die("연결 실패: " . mysqli_connect_error());
}

$ppstm = $conn->prepare("INSERT INTO users(user_id, user_pw, email_adr) VALUES (?, ?, ?)");

$user_id = $_POST['user_id'];
$email_adr = $_POST['email'];
$hashpw = password_hash($_POST['password'], PASSWORD_DEFAULT);

if (preg_match('/[\'";#-]/', $user_id) || preg_match('/[\'";#-]/', $hashpw) || preg_match('/[\'";#-]/', $email_adr)) {
    echo "<script>alert('pleas don't try');</script>";
    exit;
}

$ppstm->bind_param("sss", $user_id, $hashpw , $email_adr);

if ($ppstm->execute()) {
    echo '<script>
            alert("회원가입이 완료되었습니다");
            location.href = "index.php";
          </script>';
} 
else {
    echo "저장 실패. 관리자에게 문의주세요.". mysqli_error($conn);
}

$ppstm->close();
$conn->close();
?>
