
<?php
include '../../db_conn.php';

session_start(); 

if (!isset($_SESSION['name'])) { 
    echo "<script>alert('비정상적인 접근입니다. 다시 로그인 해주세요.'); window.location.href='index.php';</script>";
    exit();
}

$ppstm = $conn->prepare("INSERT INTO free_bulletin(subject, contents, writer, file_path) VALUES (?, ?, ?, ?)");
$username = $_SESSION['name'];
$title = htmlspecialchars($_POST['post_title'], ENT_QUOTES, 'UTF-8'); //xss 공격 방지 
$content = htmlspecialchars($_POST['post_content'], ENT_QUOTES, 'UTF-8');
$date = date('Y-m-d');

$tmpfile = $_FILES['SelectFile']['tmp_name'];
$o_name = $_FILES['SelectFile']['name'];

$baseDir = '/var/www/html/bulletin/contents/';
$uploadDir = $baseDir . 'upload/';


$userFolderName = preg_replace("/[^a-zA-Z0-9]+/", "_", $username); //파일 트래버셜 공격 방지 
$titleFolderName = preg_replace("/[^a-zA-Z0-9]+/", "_", $title);
$userDir = $uploadDir . $userFolderName;
$titleDir = $userDir . '/' . $titleFolderName;

// 각 디렉터리가 있는지 확인 
if (!is_dir($userDir) && !mkdir($userDir, 권한, true)) {
    error_log("사용자 이름으로 디렉토리 생성 실패!: " . error_get_last()['message']);
    echo '<script>alert("사용자 이름으로 디렉토리 생성 실패!"); history.back();</script>';
    exit한한
}

if (!is_dir($titleDir) && !mkdir($titleDir, 권한, true)) {
    error_log("글 제목으로 디렉터리 만들기 실패! " . error_get_last()['message']);
    echo '<script>alert("글 제목으로 디렉터리 만들기 실패!"); history.back();</script>';
    exit;
}

//최종 디렉터리 (유저 이름 + 게시물 제목)
$upload_file = $titleDir . '/' . basename($_FILES['SelectFile']['name']); //파일 디렉토리 공격 방지 

  echo "<pre>";

  if (move_uploaded_file($_FILES['SelectFile']['tmp_name'], $upload_file)) {
    echo "[수신한 내용]<br><br>";
    echo "PATH: " .$upload_file."<br>";
    echo "제목 : ".$_POST['post_title']."<br>";
    echo "내용 : ".$_POST['post_content']."<br>";
    echo "파일 :".$_FILES['SelectFile']['type']."<br>";
    $image_type = $_FILES['SelectFile']['type'];
    if($image_type == "image/png" || $image_type == "image/jpeg"){
        echo "<img src=$upload_file width='300'>";
    } else {
        echo '<script>
            alert("올릴 수 있는 파일은 png, jpg 파일뿐..");
            history.back();</script>';
    }
  }
  else {
    echo "파일 업로드  실패 : ";
    switch ($_FILES['SelectFile']['error']) {
      case UPLOAD_ERR_INI_SIZE:
        echo "php.ini 파일의 upload_max_filesize(".ini_get("upload_max_filesize").")보다 큽니다.<br>";
        break;
      case UPLOAD_ERR_FORM_SIZE:
        echo "업로드 한 파일이 Form의 MAX_FILE_SIZE 값보다 큽니다.<br>";
        break;
      case UPLOAD_ERR_PARTIAL:
        echo "파일의 일부분만 전송되었습니다.<br>";
        break;
      case UPLOAD_ERR_NO_FILE:
        echo "파일이 전송되지 않았습니다.<br>";
        break;
      case UPLOAD_ERR_NO_TMP_DIR:
        echo "임시 디렉토리가 없습니다.<br>";
        break;
    }
  }
  print "</pre>";
 
  if($username && $title && $content){
    $ppstm->bind_param("ssss", $title, $content, $username, $upload_file); //sql 인젝션 방지 
    if ($ppstm->execute()){
        echo '<script>
            alert("게시물 작성 완료");
            location.href = "../free_bulletin.php";
          </script>';
    } else{
      echo "<script>
      alert('글쓰기에 실패했습니다.');
      history.back();</script>";
    }
}
$ppstm->close();
$conn->close();
?>