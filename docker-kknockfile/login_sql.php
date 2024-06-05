<?php
    session_start();
    $conn = mysqli_connect("localhost", "root", "ajaJ3546!", "test_kknock");
    if ($conn === false) {
        error_log('MySQL 연결 실패: '.mysqli_connect_error());
        die("사이트에 문제가 발생했습니다. 관리자에게 문의하세요.");
    }

    $id = trim($_POST['input_id']); // 공백 제거 후 입력 받음
    $pw = $_POST['input_pw'];
    if (strlen($id) > 20 || strlen($pw) > 20) { //이상하게 긴 애들은 제한
            echo "<script>
                alert(\"입력 값이 너무 깁니다.\");
                history.back();
              </script>";
            exit;
        }

    
    $ppstm = $conn->prepare("SELECT * FROM users WHERE user_id=?");  //sql 방지를 위한 바인딩 작업
    $ppstm->bind_param("s", $id);
    $ppstm->execute();
    $result = $ppstm->get_result();

    if (!$result) {
        error_log("SQL Error: " . mysqli_error($conn)); // SQL 에러 로깅
    }

    if($result->num_rows==0){
        echo "<script> 
        alert(\"일치하는 아이디가 없습니다.\");
        history.back();
        </script>";
        exit;
    }else{
        $row = $result->fetch_assoc(); // fetch_assoc함수는 행의 이름을 키값으로 데이터를 value로 할당
        if (!password_verify($pw, $row['user_pw'])){ //row에서 user_pw라는 행(키)을 참조해 비교
            //passord_verify가 알아서 저장된 pw(암호화)와 입력된 pw(평문)을 비교해준다. 
            echo "<script>
                    alert(\"비밀번호가 일치하지 않습니다.\");
                    history.back();
                  </script>";
            exit;
        } else {
            session_regenerate_id(true); //세션 보안을 위해 추가 = 중복 세션 생성 방지 
            $_SESSION['name'] = $row['user_id'];
            mysqli_close($conn);
            header("Location: main.php");//html 폼의 action처럼 다음 행선지를 네비게이션 함.
            exit();
        }
    }
    ?>
