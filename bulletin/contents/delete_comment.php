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
    $stmt_check->bind_param("i", $comment_id); //comment_id = 댓글들 번호 
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row = $result_check->fetch_assoc();
    
    if ($row['writer'] != $current_user) {
        error_log("Delete attempt failed: User does not have permission");
        echo "<script>alert('삭제 권한이 없습니다.'); window.history.back();</script>";
        exit();
    }

   
    
    // 댓글이 부모 댓글인지 자식 댓글인지 확인 후 삭제, 부모 댓글이면 자식 댓글들도 모두 한번에 삭제 되도록..
    $parent_check_query = "SELECT id FROM comments WHERE id = ? AND parent_id IS NULL";
    $parent_check_stmt = $conn->prepare($parent_check_query);
    $parent_check_stmt->bind_param("i", $comment_id);
    $parent_check_stmt->execute();
    $parent_result = $parent_check_stmt->get_result();

    if ($parent_result->num_rows > 0) { //만약 parent_id = NULL인 경우 부모 댓글이라고 생각해서 삭제 
        $delete_sql = "DELETE FROM comments WHERE id = ? OR parent_id = ?";
        $stmt_delete = $conn->prepare($delete_sql);
        $stmt_delete->bind_param("ii", $comment_id, $comment_id);
        $stmt_delete->execute();
        
        if ($stmt_delete->affected_rows > 0) {
            error_log("Parent comment and its replies deleted successfully: " . $comment_id);
            echo "<script>alert('부모 댓글과 자식 댓글들이 삭제되었습니다.'); window.location.href='post_list.php?id=$post_id';</script>";
        } else {
            error_log("Delete failed: " . $stmt_delete->error);
            echo "<script>alert('댓글 삭제 실패.'); window.history.back();</script>";
        }
    }
    else
    {
        $delete_sql = "DELETE FROM comments WHERE id = ?";
        $stmt_delete = $conn->prepare($delete_sql);
        $stmt_delete->bind_param("i", $comment_id);
        $stmt_delete->execute();

        if ($stmt_delete->affected_rows > 0) {
            error_log("Child comment deleted successfully: " . $comment_id);
            echo "<script>alert('댓글이 삭제되었습니다.'); window.location.href='post_list.php?id=$post_id';</script>";
        } else {
            error_log("Delete failed: " . $stmt_delete->error);
            echo "<script>alert('댓글 삭제 실패.'); window.history.back();</script>";
        }
    }
    $stmt_check->close();
    $stmt_delete->close();
    $parent_check_stmt->close();

}
?>
