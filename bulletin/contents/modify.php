<?php
include "../../db_conn.php";

if ($conn === false) {
    die("연결 실패: " . mysqli_connect_error());
}

$sql = "SELECT id, subject, contents, writer, update_date FROM free_bulletin ORDER BY date_posted DESC LIMIT 10";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 결과 행을 출력
    while($row = $result->fetch_assoc()) {
        echo '<div class="post-preview">';
        echo '<a href="post.php?id=' . $row["id"] . '">';
        echo '<h2 class="post-title">' . htmlspecialchars($row["title"]) . '</h2>';
        echo '<h3 class="post-subtitle">' . htmlspecialchars($row["subtitle"]) . '</h3>';
        echo '</a>';
        echo '<p class="post-meta">Posted by <a href="#!">' . htmlspecialchars($row["author"]) . '</a> on ' . $row["date_posted"] . '</p>';
        echo '</div><hr class="my-4" />';
    }
} else {
    echo "No posts found.";
}
$conn->close();

