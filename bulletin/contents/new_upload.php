<?php
include '/var/www/html/db_conn.php';

session_start();

if (!isset($_SESSION['name'])) {
    echo "<script>alert('로그인이 필요합니다.'); window.location.href='../../index.php';</script>";
    exit();
}

$current_user = $_SESSION['name'];

$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($post_id == 0) {
    echo "<script>alert('잘못된 접근입니다.'); window.location.href='../free_bulletin.php';</script>";
    exit();
}

$_SESSION['current_post_id'] = $post_id;


// 댓글 입력 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_content'])) {
    $post_id = intval($_POST['post_id']);
    $parent_id = isset($_POST['parent_id']) ? intval($_POST['parent_id']) : null;
    $username = $current_user;
    $contents = htmlspecialchars($_POST['comment_content'], ENT_QUOTES, 'UTF-8');

    $comment_sql = "INSERT INTO comments (post_id, writer, contents, parent_id) VALUES (?, ?, ?, ?)";
    $stmt_comment = $conn->prepare($comment_sql);
    $stmt_comment->bind_param("issi", $post_id, $username, $contents, $parent_id);
    $stmt_comment->execute();
    $stmt_comment->close();
}

// 댓글 수정 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_comment_id'])) {
    $comment_id = intval($_POST['edit_comment_id']);
    $contents = htmlspecialchars($_POST['edit_comment_content'], ENT_QUOTES, 'UTF-8');

    $update_sql = "UPDATE comments SET contents = ? WHERE id = ? AND writer = ?";
    $stmt_update = $conn->prepare($update_sql);
    $stmt_update->bind_param("sis", $contents, $comment_id, $current_user);
    $stmt_update->execute();
    $stmt_update->close();
}

// 게시물 조회
$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($post_id == 0) {
    echo "<script>alert('잘못된 접근입니다.'); window.location.href='../free_bulletin.php';</script>";
    exit();
}

$sql = "SELECT id, subject, contents, writer, create_date, file_path FROM free_bulletin WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>자유게시판 입니다</title>
    <link href="../../css/styles.css" rel="stylesheet" />
    <style>
    .post-content {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .post-content h1 {
        color: #333;
        margin-bottom: 15px;
    }
    .post-content p {
        color: #666;
        font-size: 0.9em;
        margin-bottom: 20px;
    }
    .post-content div {
        font-size: 1.1em;
        line-height: 1.6;
        text-align: justify;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    .comments-section {
        margin-top: 40px;
    }
    .comment, .reply {
        margin-bottom: 20px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .comment-form, .reply-form {
        margin-top: 20px;
    }
    .reply {
        margin-left: 20px;
    }
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="border-end bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-light">자유게시판</div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../../index.php">Logout</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../../about.php">About</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../../search_user.html">SEARCH_USER</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../free_bulletin.php">자유게시판</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../new_bulletin.php">인사게시판</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../dictionary.php">용어사전</a>
            </div>
        </div>
        <!-- Page content wrapper -->
        <div id="page-content-wrapper">
            <!-- Top navigation -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle">Toggle Menu</button>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <li class="nav-item active"><a class="nav-link" href="../../main.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="https://www.google.com/finance/">Link</a></li>
                            <li class="nav-item"><a class="nav-link" href="write_post.php">게시물 등록</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Page content -->
            <div class="container-fluid">
                <div class="container px-4 px-lg-5">
                    <div class="row gx-4 gx-lg-5 justify-content-center">
                        <div class="col-md-10 col-lg-8 col-xl-7">
                        
                        <?php
                        if ($row = $result->fetch_assoc()) {
                            echo '<div class="post-content">';
                            echo '<h1>' . htmlspecialchars($row['subject']) . '</h1>';
                            echo '<p>작성자 : ' . htmlspecialchars($row['writer']) . ' - ' . $row['create_date'] . '</p>';
                            echo '<div>' . nl2br(htmlspecialchars($row['contents'])) . '</div>';
                            if (!empty($row['file_path']) && file_exists($row['file_path'])) {
                                echo '<a href="download.php?id=' . $post_id . '" class="btn btn-primary">Download File</a>';
                            }
                            // 게시물 수정 
                            if ($row['writer'] == $current_user) {
                                echo '<a href="modify.php?id=' . $post_id . '" class="btn btn-warning">수정</a>';
                            }
                            //게시물 삭제
                            if ($row['writer'] == $current_user){
                                echo '<a href="remove.php?id=' . $post_id . '" class="btn btn-warning">삭제</a>';
                            }
                            echo '</div>';
                        } else {
                            echo "<p>게시물을 찾을 수 없습니다. <a href='../free_bulletin.php'>게시판으로 돌아가기</a></p>";
                        }
                        ?>

                        <!-- 댓글 입력 폼 -->
                        <div class="comment-form">
                            <form action="" method="POST">
                                <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                                <textarea name="comment_content" rows="4" cols="50" placeholder="댓글을 입력하세요..." required></textarea><br>
                                <button type="submit" class="btn btn-primary">댓글 등록</button>
                            </form>
                        </div>

                        <!-- 댓글 조회 -->
                        <?php
                            $sql_comments = "SELECT id, writer, contents, create_date, parent_id FROM comments WHERE post_id = ? ORDER BY create_date ASC";
                            $stmt_comments = $conn->prepare($sql_comments);
                            $stmt_comments->bind_param("i", $post_id);
                            $stmt_comments->execute();
                            $comments_result = $stmt_comments->get_result();

                            echo '<div class="comments-section">';
                            if ($comments_result->num_rows > 0) {
                                while ($comment_row = $comments_result->fetch_assoc()) {
                                    if ($comment_row['parent_id'] == null) {
                                        echo '<div class="comment">';
                                    } else {
                                        echo '<div class="reply">';
                                    }
                                    echo '<p><strong>' . htmlspecialchars($comment_row['writer']) . ':</strong> ' . nl2br(htmlspecialchars($comment_row['contents'])) . '</p>';
                                    echo '<p>작성일: ' . $comment_row['create_date'] . '</p>';
                                    
                                    // 대댓글 입력 폼
                                    if ($comment_row['parent_id'] == null) {
                                        echo '<div class="reply-form">';
                                        echo '<form action="" method="POST">';
                                        echo '<input type="hidden" name="post_id" value="' . $post_id . '">';
                                        echo '<input type="hidden" name="parent_id" value="' . $comment_row['id'] . '">';
                                        echo '<textarea name="comment_content" rows="2" cols="50" placeholder="답글을 입력하세요..." required></textarea><br>';
                                        echo '<button type="submit" class="btn btn-secondary">답글 등록</button>';
                                        echo '</form>';
                                        echo '</div>';  
                                    }

                                    // 댓글 수정 및 삭제 버튼
                                    if ($comment_row['writer'] == $current_user) {
                                        echo '<form action="" method="POST" style="display: inline;">';
                                        echo '<input type="hidden" name="edit_comment_id" value="' . $comment_row['id'] . '">';
                                        echo '<textarea name="edit_comment_content" rows="2" cols="50" required>' . htmlspecialchars($comment_row['contents']) . '</textarea>';
                                        echo '<button type="submit" class="btn btn-warning">수정</button>';
                                        echo '</form>';
                                    }
                                    if ($comment_row['writer'] == $current_user) {
                                        echo '<form action="delete_comment.php" method="POST" style="display: inline;">';
                                        echo '<input type="hidden" name="delete_comment_id" value="' . $comment_row['id'] . '">';
                                        echo '<input type="hidden" name="post_id" value="' . $post_id . '">';
                                        echo '<button type="submit" class="btn btn-danger">삭제</button>';
                                        echo '</form>';
                                    }

                                    echo '</div>';
                                }
                            } else {
                                echo '<p>댓글이 없습니다.</p>';
                            }
                            echo '</div>';  // 전체 댓글 섹션을 닫는 태그

                            $stmt_comments->close();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/scripts.js"></script>
</body>
</html>
