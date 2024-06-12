<?php
session_start();

if (!isset($_SESSION['name'])) {
    echo "<script>alert('비정상적인 접근입니다. 다시 로그인 해주세요.'); window.location.href='index.php';</script>";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>글 작성</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Simple Sidebar - Start Bootstrap Template</title>
        <!-- Favicon-->
            <!--Non!-->
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
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="free_bulletin.php">자유게시판</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="bulletin/new_bulletin.html">인사게시판</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="bulletin/k_bulletin.html">용어사전</a>
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
                    <h1 class="mt-4">글 작성</h1>
                    <form enctype="multipart/form-data" action="new_upload.php" method="POST">
                        <div id="in_title">
                            <textarea name="post_title" id="post_title" rows="1" cols="55" placeholder="제목" maxlength="100" required></textarea>
                        </div>
                        <div id="in_content">
                            <textarea name="post_content" id="post_content" placeholder="내용" required></textarea>
                        </div>
                        <input type="file" name="SelectFile"/>
                        <div class="bt_se">
                            <button type="submit">글 작성</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
