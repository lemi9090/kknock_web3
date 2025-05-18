<html>
<head>
    <meta charset = "UTF-8">
    <meta http-equiv="X-UA-Compatible" content = "IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
          background-color: #000;
          color: #00FF00;
          font-family: Arial, sans-serif;
          text-align: center;
        }
    </style>
</head>

<body>
    <form action="login_sql.php" method = "POST" id="input_info"> <!--폼을 만들어서 입력받고 다음 행선지 정하고~-->
    <div class="w-50 ml-auto mr-auto mt-5">
        
        <div class="mb-3">
            <label for ="input_id" class ="form-label">입력받은 아이디</label>
            <input type="text" name="input_id" class="form-control" id="input_id" placeholder="아이디를 입력해 주세요.">
        </div>
    
        <div class="mb-3">
            <label for="input_pw" class="form-label">입력받은 비밀번호</label>
            <input name="input_pw" type="password" class="form-control" id="input_pw" placeholder="비밀번호를 입력해 주세요.">
        </div>


        <button type='submit' id = 'Login_button' class="btn btn-primary mb-3">로그인 </button><!--폼내용을 전송해야 하니 섭및 타입-->
        <button type='button' id = 'Signup_button' class="btn btn-primary mb-3">회원가입 </button> <!--이동해야하니 버튼 타입-->

    </div>
    </form>
    <script>
        const inputinfo = document.querySelector('#input_info'); //입력받은 정보들 변수에 넣기.
        const LoginButton = document.querySelector('#Login_button');
        const SignupButton = document.querySelector('#Signup_button');
        const Inputid = document.querySelector('#input_id');
        const Inputpw = document.querySelector('#input_pw');

        LoginButton.addEventListener("click", function(e){
            if(!Inputid.value || !Inputpw.value) {//submit 조건이 중요함. 입력 안한게 있으면 알림창 생성
                alert("아이디와 비밀번호를 모두 입력해 주세요.");
                e.preventDefault(); // 폼 제출 방지
            }
        });

        SignupButton.addEventListener("click", function(){
            window.location.href = 'rgt_user.html'; // 회원가입 페이지로 리다이렉트
        });
    </script>
</body>
</html>
