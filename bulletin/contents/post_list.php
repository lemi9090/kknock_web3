<?php
include '/var/www/html/db_conn.php';

session_start();

if (!isset($_SESSION['name'])) {
    echo "<script>alert('로그인이 필요합니다.'); window.location.href='login.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>자유게시판 입니다</title>
    <link href="../../css/styles.css" rel="stylesheet" />
    <style>
    /* 게시물 상세 보기에 맞는 스타일 */
    .post-content {
        max-width: 800px; /* 최대 너비 설정 */
        margin: 20px auto; /* 중앙 정렬과 상하 여백 */
        padding: 20px; /* 패딩 */
        background: #fff; /* 배경색 */
        border-radius: 8px; /* 테두리 둥글게 */
        box-shadow: 0 2px 4px rgba(0,0,0,0.1); /* 그림자 효과 */
    }
    
    .post-content h1 {
        color: #333; /* 제목 색상 */
        margin-bottom: 15px; /* 제목 아래 여백 */
    }
    
    .post-content p {
        color: #666; /* 게시일 및 작성자 정보 색상 */
        font-size: 0.9em; /* 폰트 크기 */
        margin-bottom: 20px; /* 내용과의 여백 */
    }
    
    .post-content div {
        font-size: 1.1em; /* 내용의 폰트 크기 */
        line-height: 1.6; /* 줄간격 */
        text-align: justify; /* 정렬 */
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
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../bulletin/new_bulletin.html">인사게시판</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../bulletin/k_bulletin.html">용어사전</a>
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
                            include '/var/www/html/db_conn.php';

                            session_start();
                            if (!isset($_SESSION['name'])) {
                                echo "<script>alert('로그인이 필요합니다.'); window.location.href='login.php';</script>";
                                exit();
                            }

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

                            if ($row = $result->fetch_assoc()) {
                                echo '<div class="post-content">';
                                echo '<h1>' . htmlspecialchars($row['subject']) . '</h1>';
                                echo '<p>Posted by ' . htmlspecialchars($row['writer']) . ' on ' . $row['create_date'] . '</p>';
                                echo '<div>' . nl2br(htmlspecialchars($row['contents'])) . '</div>';
                                if (!empty($row['file_path']) && file_exists($row['file_path'])) {
                                    echo '<a href="download.php?id=' . $post_id . '" class="btn btn-primary">Download File</a>';
                                }
                                echo '</div>';
                            } else {
                                echo "<p>게시물을 찾을 수 없습니다. <a href='../free_bulletin.php'>게시판으로 돌아가기</a></p>";
                            }

                            $stmt->close();
                            $conn->close();
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



















