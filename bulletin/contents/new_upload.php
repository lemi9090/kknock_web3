
<?php
 
include '../../db_conn.php';

session_start(); 

if (!isset($_SESSION['name'])) { 
    echo "<script>alert('비정상적인 접근입니다. 다시 로그인 해주세요.'); window.location.href='index.php';</script>";
    exit();
}
  $ppstm = $conn->prepare("INSERT INTO free_bulletin(subject, contents, writer) VALUES (?, ?, ?)");
  $username = $_SESSION['name'];
  //$board_id = $_GET['board_id'];
  $title = $_POST['post_title'];
  $content = $_POST['post_content'];
  $date = date('Y-m-d');
  /////////////////////////////////////////////////////////////////////
  $tmpfile =  $_FILES['SelectFile']['tmp_name'];
  $o_name = $_FILES['SelectFile']['name'];
  $upload_dir = 'uploads/';
  $upload_file = $upload_dir . basename($_FILES['SelectFile']['name']); 
  $file_name = iconv("UTF-8", "EUC-KR",$upload_file);
  ////////////////////////
  print "<pre>";
  if (move_uploaded_file($_FILES['SelectFile']['tmp_name'], $file_name)) {
    print "[수신한 내용]<br><br>";
    print "PATH: " .$upload_file."<br>";
    print "제목 : ".$_POST['post_title']."<br>";
    print "내용 : ".$_POST['post_content']."<br>";
    print "파일 :".$_FILES['SelectFile']['type']."<br>";
    $image_type = $_FILES['SelectFile']['type'];
    if($image_type == "image/png" || $image_type == "image/jpeg"){
        print "<img src=$upload_file width='300'>";
    } else {
        echo '<script>
            alert("올릴 수 있는 파일은 png, jpg 파일뿐..");
            history.back();</script>";
          </script>';
    }
  }
  else {
    print "파일 업로드  실패 : ";
    switch ($_FILES['SelectFile']['error']) {
      case UPLOAD_ERR_INI_SIZE:
        print "php.ini 파일의 upload_max_filesize(".ini_get("upload_max_filesize").")보다 큽니다.<br>";
      break;
      case UPLOAD_ERR_FORM_SIZE:
        print "업로드 한 파일이 Form의 MAX_FILE_SIZE 값보다 큽니다.<br>";
      break;
      case UPLOAD_ERR_PARTIAL:
        print "파일의 일부분만 전송되었습니다.<br>";
      break;
      case UPLOAD_ERR_NO_FILE:
        print "파일이 전송되지 않았습니다.<br>";
      break;
      case UPLOAD_ERR_NO_TMP_DIR:
        print "임시 디렉토리가 없습니다.<br>";
      break;
    }
    print_r($_FILES);
  }
  print "</pre>";
 
  if($username && $title && $content){
    $ppstm->bind_param("sss", $title, $content, $username);


    if ($ppstm->execute()){
        echo '<script>
            alert("게시물 작성 완료");
            location.href = "../free_bulletin.php";
          </script>';
    } 
    else{
      echo "<script>
      alert('글쓰기에 실패했습니다.');
      history.back();</script>";
    }
}
$ppstm->close();
$conn->close();
?>