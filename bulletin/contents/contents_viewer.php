<?php
include '/var/www/html/db_conn.php';
//echo 'Current directory: ' . getcwd() . '<br>';
if ($conn === false) {
    die("연결 실패: " . mysqli_connect_error());
}
$sql = "SELECT id, subject, contents, writer, create_date FROM free_bulletin ORDER BY create_date DESC LIMIT 10";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($board = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($board['id']) . '</td>';
        echo '<td><a href="contents/post_list.php?id=' . $board['id'] . '">' . htmlspecialchars($board['subject']) . '</a></td>';
        echo '<td>' . htmlspecialchars($board['writer']) . '</td>';
        echo '<td>' . $board['create_date'] . '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="4">게시물이 없습니다.</td></tr>';
}
$conn->close();  // 데이터베이스 연결 종료
?>
