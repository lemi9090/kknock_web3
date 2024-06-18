<?php
include '/var/www/html/db_conn.php';

session_start();

if (!isset($_SESSION['name'])) {
    echo "<script>alert('로그인이 필요합니다.'); window.location.href='../index.php';</script>";
    exit();
}
$_SESSION['board_id'] = 2;

$board_id = isset($_SESSION['board_id']) ? $_SESSION['board_id'] : null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>자유게시판 입니다</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <style>
    .list-table th, .list-table td {
        padding: 12px; /* 셀 패딩 조정 */
        text-align: center; /* 텍스트 중앙 정렬 */
        border-bottom: 1px solid #ddd; /* 하단 테두리 선 */
    }
    .list-table th {
        background-color: #f8f9fa; /* 헤더 배경색 */
        color: #333; /* 헤더 글자색 */
    }
    .list-table tr:hover {
        background-color: #f1f1f1; /* 마우스 오버시 배경색 변경 */
    }
    .list-table {
        width: 100%; /* 테이블 전체 너비 */
        max-width: 1400px; /* 최대 너비 설정 */
        margin-left: -150px; /* 왼쪽 여백 설정 */
        margin-top: 20px; /* 상단 여백 */
        margin-bottom: 20px; /* 하단 여백 */
    }
    .container-fluid {
        padding: 20px; /* 컨테이너 패딩 조정 */
    }
    /* 열 너비 조정 */
    .list-table th:nth-child(1), .list-table td:nth-child(1) { width: 5%; } /* 번호 */
    .list-table th:nth-child(2), .list-table td:nth-child(2) { width: 72%; } /* 제목 */
    .list-table th:nth-child(3), .list-table td:nth-child(3) { width: 8%; } /* 글쓴이 */
    .list-table th:nth-child(4), .list-table td:nth-child(4) { width: 15%; } /* 작성일 */
    </style>



</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="border-end bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-light">자유게시판</div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../index.php">Logout</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../about.php">About</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="../search_user.html">SEARCH_USER</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="free_bulletin.php">자유게시판</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="new_bulletin.php">인사게시판</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="dictionary.php">용어사전</a>
            </div>
        </div>
        <!-- Page content wrapper -->
        <div id="page-content-wrapper">
            <!-- Top navigation -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle">Toggle Menu</button>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <li class="nav-item active"><a class="nav-link" href="../main.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="https://www.google.com/finance/">Link</a></li>
                            <li class="nav-item"><a class="nav-link" href="contents/write_post.php">게시물 등록</a></li>
                            
                        </ul >
                    </div>
                </div>
            </nav>
            <!-- Page content -->
            <div class="container-fluid">
                <div class="container px-4 px-lg-5">
                    <div class="row gx-4 gx-lg-5 justify-content-center">
                        <div class="col-md-10 col-lg-8 col-xl-7">
                        
                             <!--정렬 옵션-->
                             <form method="GET">
                                <label for="order">정렬 방식:</label>
                                <select name="sort_order" onchange="this.form.submit()">
                                    <option value="create_date_desc" <?php if (isset($_GET['sort_order']) && $_GET['sort_order'] == 'create_date_desc') echo 'selected'; ?>>작성일 내림차순</option>
                                    <option value="create_date_asc" <?php if (isset($_GET['sort_order']) && $_GET['sort_order'] == 'create_date_asc') echo 'selected'; ?>>작성일 오름차순</option>
                                    <option value="writer_asc" <?php if (isset($_GET['sort_order']) && $_GET['sort_order'] == 'writer_asc') echo 'selected'; ?>>글쓴이 이름 순</option>
                                </select>
                            </form>

                            <!-- 게시물 검색 기능 -->
                            <form method="GET" action="">
                                <input type="text" name="search_query" placeholder="검색어 입력" value="<?php echo htmlspecialchars($_GET['search_query'] ?? ''); ?>" required>
                                <select name="search_type">
                                    <option value="subject" <?php if (isset($_GET['search_type']) && $_GET['search_type'] == 'subject') echo 'selected'; ?>>제목</option>
                                    <option value="writer" <?php if (isset($_GET['search_type']) && $_GET['search_type'] == 'writer') echo 'selected'; ?>>작성자</option>
                                    <option value="contents" <?php if (isset($_GET['search_type']) && $_GET['search_type'] == 'contents') echo 'selected'; ?>>내용</option>
                                </select>
                                <select name="search_order">
                                    <option value="create_date_desc" <?php if (isset($_GET['search_order']) && $_GET['search_order'] == 'create_date_desc') echo 'selected'; ?>>작성일 내림차순</option>
                                    <option value="create_date_asc" <?php if (isset($_GET['search_order']) && $_GET['search_order'] == 'create_date_asc') echo 'selected'; ?>>작성일 오름차순</option>
                                    <option value="writer_asc" <?php if (isset($_GET['search_order']) && $_GET['search_order'] == 'writer_asc') echo 'selected'; ?>>작성자 이름 순</option>
                                </select>
                                <button type="submit">검색</button>
                            </form>

                            <!-- 게시판 목록 표시 -->
                            <table class="list-table">
                                <thead>
                                    <tr>
                                        <th>번호</th>
                                        <th>제목</th>
                                        <th>글쓴이</th>
                                        <th>작성일</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <!--!!!!!!-->
                                        <?php
                                        $search_active = false;

                                        // 정렬 파라미터 확인
                                        $sort_order = $_GET['sort_order'] ?? 'create_date_desc'; // 정렬 파라미터가 없는 경우 기본값
                                        switch ($sort_order) {
                                            case 'create_date_asc':
                                                $order_by = "create_date ASC";
                                                break;
                                            case 'create_date_desc':
                                                $order_by = "create_date DESC";
                                                break;
                                            case 'writer_asc':
                                                $order_by = "writer ASC";
                                                break;
                                            default:
                                                $order_by = "create_date DESC";
                                                break;
                                        }

                                        // 검색 폼 처리
                                        if (isset($_GET['search_query']) && isset($_GET['search_type'])) {
                                            $search_query = $_GET['search_query'];
                                            $search_type = $_GET['search_type'];
                                            $search_order = $_GET['search_order'] ?? 'create_date_desc'; // 검색 정렬 파라미터

                                            switch ($search_order) {
                                                case 'create_date_asc':
                                                    $order_by = "create_date ASC";
                                                    break;
                                                case 'create_date_desc':
                                                    $order_by = "create_date DESC";
                                                    break;
                                                case 'writer_asc':
                                                    $order_by = "writer ASC";
                                                    break;
                                            }

                                            $search_active = true; //검색 진행 시 값 변경 

                                            $field = $search_type === "writer" ? "writer" : ($search_type === "contents" ? "contents" : "subject");
                                                                        //삼항연산자 : 조건 ? 참일때 값  : 거짓일 때 값 을 유도함. 

                                            $sql = "SELECT id, subject, writer, create_date FROM free_bulletin WHERE board_id = 2 AND $field LIKE ? ORDER BY $order_by";
                                            $stmt = $conn->prepare($sql);
                                            $like_query = "%" . $search_query . "%";
                                            $stmt->bind_param("s", $like_query);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            if ($result->num_rows > 0) {
                                                while ($board = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . htmlspecialchars($board['id']) . "</td>";
                                                    echo "<td><a href='contents/post_list.php?id=" . htmlspecialchars($board['id']) . "'>" . htmlspecialchars($board['subject']) . "</a></td>";
                                                    echo "<td>" . htmlspecialchars($board['writer']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($board['create_date']) . "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='4'>검색 결과가 없습니다.</td></tr>";
                                            }
                                            $stmt->close();
                                        }

                                        // 기본 게시물 목록 출력, 검색 안했을 때는 기본 모드.
                                        if($search_active==false){
                                            if ($board_id == 2) {
                                                $sql = "SELECT id, subject, writer, create_date FROM free_bulletin WHERE board_id = 2 ORDER BY $order_by LIMIT 10";
                                                $result = $conn->query($sql);
                                            
                                                if ($result->num_rows > 0) {
                                                    while ($board = $result->fetch_assoc()) {
                                                        echo "<tr>";
                                                        echo "<td>" . htmlspecialchars($board['id']) . "</td>";
                                                        echo "<td><a href='contents/post_list.php?id=" . htmlspecialchars($board['id']) . "'>" . htmlspecialchars($board['subject']) . "</a></td>";
                                                        echo "<td>" . htmlspecialchars($board['writer']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($board['create_date']) . "</td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='4'>게시물이 없습니다.</td></tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='4'>접근 권한이 없습니다.</td></tr>";
                                            }
                                        }
                                        ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/scripts.js"></script>
</body>
</html>