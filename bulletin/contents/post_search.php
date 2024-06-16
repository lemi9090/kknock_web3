특정 게시물의 파일 경로 조회
예를 들어, 게시물의 ID가 주어졌다고 가정하고, 그 ID에 해당하는 게시물의 파일 경로만 조회하고자 한다면 다음과 같이 SQL 쿼리를 작성할 수 있습니다:

sql
코드 복사
SELECT file_path FROM free_bulletin WHERE id = 1;
이 쿼리는 id가 1인 게시물의 file_path를 조회합니다.

조건에 따른 다중 필드 조회
게시물의 작성자가 주어진 경우 작성자명으로 조회하는 쿼리는 다음과 같습니다:

sql
코드 복사
SELECT file_path FROM free_bulletin WHERE writer = 'username';
이 쿼리는 writer 컬럼 값이 'username'인 모든 레코드의 file_path를 조회합니다.

고급 조회
여러 조건을 조합하거나, 정렬, 그룹화 등 더 복잡한 쿼리가 필요한 경우에는 SQL의 다른 구문을 조합하여 사용할 수 있습니다. 예를 들어, 최근 날짜에 업로드된 파일 경로를 조회하려면 ORDER BY와 LIMIT를 사용할 수 있습니다:

sql
코드 복사
SELECT file_path FROM free_bulletin ORDER BY upload_date DESC LIMIT 1;
이 쿼리는 가장 최근에 업로드된 파일의 경로를 조회합니다.