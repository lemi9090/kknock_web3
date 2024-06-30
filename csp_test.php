<?php
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com; style-src 'self' https://cdnjs.cloudflare.com;");
echo $_GET['csp'];
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SVG Interaction Test</title>
</head>
<body>
    <h1>External Resource Test</h1>
    
    <!-- 외부 스크립트 파일 포함 -->
    <script src="https://raw.githubusercontent.com/lemi9090/kknock_web3/main/xss_alert.svg"></script>
    <script>
        $(document).ready(function() {
            alert("jQuery is loaded and ready!");
        });
    </script>
</body>
</html>
</html>
