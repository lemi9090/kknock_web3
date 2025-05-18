
<?php
$conn = mysqli_connect("localhost", "root", "", "tung");
if ($conn === false){
	error_log('mysql 연결실패: '.mysqli_connect_error());
	die("사이트에 문제가 발생했습니다. 관리자에게 문의하세요.");
	}
?>
