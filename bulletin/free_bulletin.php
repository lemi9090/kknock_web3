<?php

include '../../db_conn.php';

session_start(); 

if (!isset($_SESSION['name'])) { 
    echo "<script>alert('비정상적인 접근입니다. 다시 로그인 해주세요.'); window.location.href='index.php';</script>";
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
            <!-- Top navigation-->
                <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                        <div class="container-fluid">
                            <button class="btn btn-primary" id="sidebarToggle">Toggle Menu</button>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                                    <li class="nav-item active"><a class="nav-link" href="../main.php">Home</a></li>
                                    <li class="nav-item"><a class="nav-link" href="https://www.google.com/finance/">Link</a></li>
                                    <li class="nav-item"><a class="nav-link" href="contents/write_post.php">게시물 등록</a></li>
                                </ul>
                            </div>
                        </div>
                </nav>
            <!-- Page content -->
            <div class="container-fluid">
                <div class="container px-4 px-lg-5">
                    <div class="row gx-4 gx-lg-5 justify-content-center">
                        <div class="col-md-10 col-lg-8 col-xl-7">
                            <!-- PHP to display posts -->
                            <?php include 'contents/contents_viewer.php'; ?>
                        </div>
                    </div>
                </div>
            </div>
        
    </div>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>
