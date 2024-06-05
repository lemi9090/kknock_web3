<?php
session_start(); //login_sql.php 와 연동된 세션을 이용해야함. 

if (!isset($_SESSION['name'])) { //세션값 확인 일치하지 않으면 다시 돌아가야함. 
    echo "<script>alert('비정상적인 접근입니다. 다시 로그인 해주세요.'); 
    window.location.href='index.php';</script>";
    exit();
}
?>

<html>
<head>
    <meta charset = 'UTF-8';>
    <title>about_php</title>
        <style>
            body{
                background-color: aqua;
            }
            h1{
                color : navy;
                font-size : x-large;
            }
            h2{
                color : black;
                font-weight: bold 300;
            }
            h3{
                color : aqua;
                font-size : small;
            }
        </style>


</head>

<body>
    <button type ='button' id = 'logout_button' class="btn btn-primary mb-3"> 로그아웃 </button>    
    <button type = "button" id ='back' class='btn btn-primary mb-3'>뒤로가기</button>

    <h1>
        만든 날짜 : 24.05.27
    </h1>
    <h2>
        만든 사람 : lemi
    </h2>
    <h3>
        보통 뭘 적지..?
    </h3>
    
    <script>
        const logoutButton = document.querySelector('#logout_button');
        const backButton = document.querySelector('#back');

        logoutButton.addEventListener("click", function(){
        window.location.href = 'logout.php';
        });

        backButton.addEventListener("click", function(){
            window.location.href = 'main.php';
        });


    </script>


</body>

</html>
