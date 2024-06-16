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
    <link href="../css/styles.css" rel="stylesheet" />
    <style>
    .list-table th, .list-table td {
        padding: 12px; /* 셀 패딩 조정 */
        text-align: center; /* 텍스트 중앙 정렬 */
        border-bottom: 1px solid #ddd; /* 하단 테두리 선 */
    }
    .list-table th {
        background-color: #f8f9fa; /* 헤더 배경색 */
        color: #333; /* 헤더 글자색 */
    }
    .list-table tr:hover {
        background-color: #f1f1f1; /* 마우스 오버시 배경색 변경 */
    }
    .list-table {
        width: 100%; /* 테이블 전체 너비 */
        max-width: 1400px; /* 최대 너비 설정 */
        margin-left: -250px; /* 왼쪽 여백 설정 */
        margin-top: 20px; /* 상단 여백 */
        margin-bottom: 20px; /* 하단 여백 */
    }
    .container-fluid {
        padding: 20px; /* 컨테이너 패딩 조정 */
    }
    /* 열 너비 조정 */
    .list-table th:nth-child(1), .list-table td:nth-child(1) { width: 10%; } /* 번호 */
    .list-table th:nth-child(2), .list-table td:nth-child(2) { width: 75%; } /* 제목 */
    .list-table th:nth-child(3), .list-table td:nth-child(3) { width: 30%; } /* 글쓴이 */
    .list-table th:nth-child(4), .list-table td:nth-child(4) { width: 40%; } /* 작성일 */
</style>



</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="border-end bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-light">자유게시판</div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../index.php">Logout</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../about.php">About</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../search_user.html">SEARCH_USER</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="free_bulletin.php">자유게시판</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="bulletin/new_bulletin.html">인사게시판</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="bulletin/k_bulletin.html">용어사전</a>
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
                        <ui class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <li class="nav-item active"><a class="nav-link" href="../main.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="https://www.google.com/finance/">Link</a></li>
                            <li class="nav-item"><a class="nav-link" href="contents/write_post.php">게시물 등록</a></li>
                            <li class="nav-item"><a class="nav-link" href="contents/post_search.php">게시물 검색</a></li>
                        </ui >
                    </div>
                </div>
            </nav>
            <!-- Page content -->
            <div class="container-fluid">
                <div class="container px-4 px-lg-5">
                    <div class="row gx-4 gx-lg-5 justify-content-center">
                        <div class="col-md-10 col-lg-8 col-xl-7">
                            <!-- 게시판 목록 표시 -->
                            <table class="list-table">
                            <thead>
                                <tr>
                                    <th>번호</th>
                                    <th>제목</th>
                                    <th>글쓴이</th>
                                    <th>작성일</th>
                                </tr>
                            </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT id, subject, writer, create_date FROM free_bulletin ORDER BY create_date DESC LIMIT 10";
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
                                        echo '<tr><td colspan="4">No posts found.</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
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