<?php
session_start(); //login_sql.php 와 연동된 세션을 이용해야함.

if (!isset($_SESSION['name'])) { //세션값 확인 일치하지 않으면 다시 돌아가야함.
    echo "<script>alert('비정상적인 접근입니다. 다시 로그인 해주세요.'); window.location.href='index.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>메인화면 입니다</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Simple Sidebar - Start Bootstrap Template</title>
        <!-- Favicon-->
            <!--Non!-->
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar-->
            <div class="border-end bg-white" id="sidebar-wrapper">
                <div class="sidebar-heading border-bottom bg-light">안녕하세요</div>
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="index.php">Logout</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="about.php">About</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="search_user.html">SEARCH_USER</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="bulletin/free_bulletin.php">자유게시판</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="bulletin/new_bulletin.php">방명록</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="bulletin/dictionary.php">용어사전</a>
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
                                <li class="nav-item active"><a class="nav-link" href="#!">Home</a></li>
                                <li class="nav-item"><a class="nav-link" href="#!">Link</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- Page content-->
                <div class="container-fluid">
                    <h1 class="mt-4">메인 게시판 입니다</h1>
                    <p>Team:KknockKnock</p>
                    <p>
                        template made by <code>Simple Sidebar - Start Bootstrap Template</code>
                        use this template <code>#LEMI</code>

                    </p>
                </div>
            </div>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
