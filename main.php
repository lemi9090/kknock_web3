<?php
session_start(); //login_sql.php 와 연동된 세션을 이용해야함. 

if (!isset($_SESSION['name'])) { //세션값 확인 일치하지 않으면 다시 돌아가야함. 
    echo "<script>alert('비정상적인 접근입니다. 다시 로그인 해주세요.'); window.location.href='index.php';</script>";
    exit();
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>메인화면 입니다</title>
        <style>
        body{
                background-color: blanchedalmond;
        }
        h1 {
            color: chocolate;
            font-size: x-large;
        }
        h2 {
            font-weight: bold;
            font-size: large;
        }
        ol {
            color: darkgoldenrod;
        }
        </style>
</head>

<body>
    <button type ='button' id = 'logout_button' class="btn btn-primary mb-3"> 로그아웃 </button>
        <h1>
            Welcome to Kknock Server
        </h1>
        <h2>
            Team:KknockKnock
        </h2>
        <ol>
            <li>Kong</li>
            <li>Lee</li>
            <li>Jung</li>
            <li>Bong</li>
        </ol>
    <script>
    const logoutButton = document.querySelector('#logout_button');

    logoutButton.addEventListener("click", function(){
        window.location.href = 'logout.php';
    });
</script>
</body>
</html>