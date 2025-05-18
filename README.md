# kknock_web3

### + whs project 
### purpose : web hacking test

```
sudo apt update
sudo apt install apache2 -y
sudo apt install php libapache2-mod-php -y
sudo apt install mysql-server -y
sudo apt install php-mysqli -y


# /var/www에서
git clone https://github.com/lemi9090/kknock_web3

rm -rf html
mv kknock_web3 html

# /var/www/html에서
mysql -u root -p < init_db.sql
```



