<?php
// 세션 시작
session_start();

// 현재 세션 id 확인
echo session_id();
echo '<br/><br/>';
// 세션 id 신규 발급
session_regenerate_id();

// 신규 발급된 id 확인
echo session_id();
?>
