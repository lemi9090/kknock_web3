<?php
include '/var/www/html/db_conn.php';

session_start();

if (!isset($_SESSION['name'])) {
    echo "<script>alert('로그인이 필요합니다.'); window.location.href='../../index.php';</script>";
    exit();
}

$current_user = $_SESSION['name'];

// 댓글 삭제 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_comment_id'])) {
    $comment_id = intval($_POST['delete_comment_id']);
    $post_id = intval($_POST['post_id']);  

    // 댓글 작성자 검증
    $check_sql = "SELECT writer FROM comments WHERE id = ?";
    $stmt_check = $conn->prepare($check_sql);
    $stmt_check->bind_param("i", $comment_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row = $result_check->fetch_assoc();
    
    if ($row['writer'] != $current_user) {
        error_log("Delete attempt failed: User does not have permission");
        echo "<script>alert('삭제 권한이 없습니다.'); window.history.back();</script>";
        exit();
    }
    
    // 댓글 및 모든 하위 댓글 삭제
    $delete_sql = "DELETE FROM comments WHERE id = ? OR parent_id = ?";
    $stmt_delete = $conn->prepare($delete_sql);
    $stmt_delete->bind_param("ii", $comment_id, $comment_id);
    $stmt_delete->execute();
    
    if ($stmt_delete->affected_rows > 0) {
        error_log("Comment deleted successfully: " . $comment_id);
        echo "<script>alert('댓글이 삭제되었습니다.'); window.location.href='post_list.php?id=$post_id';</script>";
    } else {
        error_log("Delete failed: " . $stmt_delete->error);
        echo "<script>alert('댓글 삭제 실패.'); window.history.back();</script>";
    }
    
    $stmt_check->close();
    $stmt_delete->close();
}
?>
