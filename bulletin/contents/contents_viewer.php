<?php
include '../../db_conn.php';

if ($conn === false) {
    die("연결 실패: " . mysqli_connect_error()); 
}
$sql = "SELECT id, subject, contents, writer, create_date FROM free_bulletin ORDER BY create_date DESC LIMIT 10";  
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 결과 행을 출력
    while ($row = $result->fetch_assoc()) {
        echo '<div class="post-preview">';
        echo '<a href="post.php?id=' . $row["id"] . '">';
        echo '<h2 class="post-title">' . htmlspecialchars($row["subject"]) . '</h2>';  
        echo '<h3 class="post-subtitle">' . substr(htmlspecialchars($row["contents"]), 0, 150) . '...</h3>';  
        echo '</a>';
        echo '<p class="post-meta">Posted by <a href="#!">' . htmlspecialchars($row["writer"]) . '</a> on ' . $row["create_date"] . '</p>';  // 작성자와 작성 일자 출력
        echo '</div><hr class="my-4" />';
    }
} else {
    echo "No posts found.";  // 게시물이 없을 때 메시지 출력
}
$conn->close();  // 데이터베이스 연결 종료
?>
