# kknock_web3

###### + whs project (purpose : web hacking test)

```
sudo apt update
sudo apt install apache2 -y
sudo apt install php libapache2-mod-php -y
sudo apt install mysql-server -y
sudo apt install php-mysqli -y

cd /etc/php/8.1/apache2
vi php.ini
post_max_size = 2M -> post_max_size = 12M 으로 수정
upload_max_filesize = 2M -> upload_max_filesize = 20M 으로 수정


# /var/www에서
git clone https://github.com/lemi9090/kknock_web3

rm -rf html
mv kknock_web3 html

# /var/www/html에서
mysql -u root -p < init_db.sql
```

#### mysql 설정 오류
db_conn.php에서 실제 환경에 맞게 수정했나요?

mysql에 초기 설정에 root 비밀번호를 수정했나요?

했다면 아래 설정 확인..
```
mysql> SELECT user, host, plugin FROM mysql.user WHERE user='root';
+------+-----------+-------------+
| user | host      | plugin      |
+------+-----------+-------------+
| root | localhost | auth_socket |
+------+-----------+-------------+
```
auth_socket 이면 외부 접근이 안됨.
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '[원하는비번]';하고 FLUSH PRIVILEGES;로 초기화
```
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'aaaaa';
FLUSH PRIVILEGES;
exit;

service mysql restart
```

#### upload 오류 해결
```
sudo chown -R www-data:www-data /var/www/html/bulletin/contents/upload
sudo chmod -R 777 /var/www/html/bulletin/contents/upload 
```
