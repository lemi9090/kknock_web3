<?php
include '/var/www/html/db_conn.php';

session_start();

if (!isset($_SESSION['name'])) {
    echo "<script>alert('비정상적인 접근입니다. 다시 로그인 해주세요.'); window.location.href='../../index.php';</script>";
    exit();
}

if (isset($_SESSION['board_id'])) {
    $boardid = $_SESSION['board_id'];
} elseif (isset($_POST['board_id'])) {
    $boardid = htmlspecialchars($_POST['board_id'], ENT_QUOTES, 'UTF-8'); // 세션에서 board_id 가져오기
}else {
    // board_id가 없을 경우의 처리
    echo "<script>alert('게시판 ID가 설정되지 않았습니다.'); history.back();</script>";
    exit();
}


$ppstm = $conn->prepare("INSERT INTO free_bulletin(subject, contents, writer, file_path, board_id) VALUES (?, ?, ?, ?, ?)");
$username = $_SESSION['name'];
$title = htmlspecialchars($_POST['post_title'], ENT_QUOTES, 'UTF-8'); // XSS 공격 방지
$content = htmlspecialchars($_POST['post_content'], ENT_QUOTES, 'UTF-8');
$date = date('Y-m-d');

$file_path = ''; // 파일 경로 초기화


// 파일이 업로드된 경우 처리
if (isset($_FILES['SelectFile']) && $_FILES['SelectFile']['error'] != UPLOAD_ERR_NO_FILE) {
    $tmpfile = $_FILES['SelectFile']['tmp_name'];
    $o_name = $_FILES['SelectFile']['name'];
    $image_type = $_FILES['SelectFile']['type'];

    $baseDir = '/var/www/html/bulletin/contents/';
    $uploadDir = $baseDir . 'upload/';

    $userFolderName = preg_replace("/[^a-zA-Z0-9]+/", "_", $username) ?: "default_user";
    $titleFolderName = preg_replace("/[^a-zA-Z0-9]+/", "_", $title) ?: "default_title";
    $userDir = $uploadDir . $userFolderName;
    $titleDir = $userDir . '/' . $titleFolderName;

    if (!is_dir($userDir) && !mkdir($userDir, 0755, true)) {
        error_log("사용자 이름으로 디렉토리 생성 실패!: " . error_get_last()['message']);
        echo '<script>alert("사용자 이름으로 디렉토리 생성 실패!"); history.back();</script>';
        exit();
    }

    if (!is_dir($titleDir) && !mkdir($titleDir, 0755, true)) {
        error_log("글 제목으로 디렉터리 만들기 실패! " . error_get_last()['message']);
        echo '<script>alert("글 제목으로 디렉터리 만들기 실패!"); history.back();</script>';
        exit();
    }

    // 최종 디렉터리 (유저 이름 + 게시물 제목)
    $upload_file = $titleDir . '/' . basename($_FILES['SelectFile']['name']); // 파일 디렉토리 공격 방지

    if (move_uploaded_file($_FILES['SelectFile']['tmp_name'], $upload_file)) {
        $image_type = $_FILES['SelectFile']['type'];
        if ($image_type == "image/png" || $image_type == "image/jpeg") {
          $file_path = $upload_file; 
          } else {
                echo '<script>
                    alert("올릴 수 있는 파일은 png, jpg 파일뿐입니다.");
                    history.back();</script>'; 
                exit();
            }

    } else {
        echo '<script>alert("파일 업로드 실패: ';
        switch ($_FILES['SelectFile']['error']) {
            case UPLOAD_ERR_INI_SIZE:
                echo 'php.ini 파일의 upload_max_filesize(' . ini_get("upload_max_filesize") . ')보다 큽니다.';
                break;
            case UPLOAD_ERR_FORM_SIZE:
                echo '업로드 한 파일이 Form의 MAX_FILE_SIZE 값보다 큽니다.';
                break;
            case UPLOAD_ERR_PARTIAL:
                echo '파일의 일부분만 전송되었습니다.';
                break;
            case UPLOAD_ERR_NO_FILE:
                echo '파일이 전송되지 않았습니다.';
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                echo '임시 디렉토리가 없습니다.';
                break;
            default:
                echo '알 수 없는 오류가 발생했습니다.';
                break;
        }
        echo '"); history.back();</script>';
        exit();
    }
}

// 게시물 작성
if ($username && $title && $content) {
  $ppstm->bind_param("ssssi", $title, $content, $username, $file_path, $boardid); // SQL 인젝션 방지
  if ($ppstm->execute()) {
        
        switch ($boardid) {
            case 1:
                header('Location: ../free_bulletin.php'); 
                break;
            case 2:
                header('Location: ../new_bulletin.php'); 
                break;
            default:
                header('Location: ../dictionary.php'); 
                break;
        }
        exit();
  }else {
      echo "<script>
      alert('글쓰기에 실패했습니다. 오류: " . $ppstm->error . "');
      history.back();</script>";
  }
} else {
  echo "<script>
  alert('모든 필드를 채워주세요.');
  history.back();</script>";
}

$ppstm->close();
$conn->close();
?>

