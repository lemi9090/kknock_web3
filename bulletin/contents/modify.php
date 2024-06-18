<?php

include '../../db_conn.php';

session_start();

if (!isset($_SESSION['name'])) {
    echo "<script>alert('로그인이 필요합니다.'); window.location.href='../../index.php';</script>";
    exit();
}

$username = $_SESSION['name'];

if (isset($_SESSION['board_id'])) {
    $boardid = $_SESSION['board_id']; //세션값 게시판 선택
  }
  
if (isset($_SESSION['current_post_id'])) {
    $post_id = $_SESSION['current_post_id']; // 세션값에서 게시물 선택 
  }

// 게시물 작성자 확인 및 내용 불러오기
$sql = "SELECT subject, contents, writer, file_path FROM free_bulletin WHERE id = ? AND board_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $post_id, $boardid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('존재하지 않는 게시물입니다.'); window.location.href='../free_bulletin.php';</script>";
    exit();
}

$row = $result->fetch_assoc();
if (strcasecmp(trim($row['writer']), trim($username)) !== 0) {
    echo "<script>alert('게시물을 수정할 권한이 없습니다.'); window.location.href='../free_bulletin.php';</script>";
    exit();
}

$title = htmlspecialchars($row['subject'], ENT_QUOTES, 'UTF-8');
$content = htmlspecialchars($row['contents'], ENT_QUOTES, 'UTF-8');
$file_path = htmlspecialchars($row['file_path'], ENT_QUOTES, 'UTF-8');

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>글 수정</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Simple Sidebar - Start Bootstrap Template</title>
    <!-- Favicon-->
    <!-- Non!-->
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="../../css/styles.css" rel="stylesheet" />
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <div class="border-end bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-light">Post!!</div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../../index.php">Logout</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../../about.php">About</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../../search_user.html">SEARCH_USER</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../free_bulletin.php">자유게시판</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../new_bulletin.php">인사게시판</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../dictionary.php">용어사전</a>
            </div>
        </div>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Top navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle">Toggle Menu</button>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <li class="nav-item active"><a class="nav-link" href="../../main.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="https://www.google.com/finance/">Link</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Page content-->
            <div class="container-fluid">
                <h1 class="mt-4">글 수정</h1>
                <form enctype="multipart/form-data" action="post_modify.php" method="POST">
                    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                    <div id="in_title">
                        <textarea name="post_title" id="post_title" rows="1" cols="55" placeholder="제목" maxlength="100" required><?php echo $title; ?></textarea>
                    </div>
                    <div id="in_content">
                        <textarea name="post_content" id="post_content" placeholder="내용" required><?php echo $content; ?></textarea>
                    </div>
                    <input type="file" name="SelectFile" />
                    <?php
                    if (!empty($file_path)) {
                        echo '<p>첨부된 파일: ' . basename($file_path) . '</p>';
                    }
                    ?>
                    <div class="bt_se">
                        <button type="submit">글 수정</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
