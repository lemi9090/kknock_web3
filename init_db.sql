-- init_db.sql

CREATE DATABASE vuln_thang_thang;
USE vuln_thang_thang;


-- users 테이블
CREATE TABLE users (
    user_id VARCHAR(255) PRIMARY KEY,
    user_pw VARCHAR(255) NOT NULL,
    email_adr VARCHAR(255) NOT NULL
);

-- bulletin_boards 테이블
CREATE TABLE `bulletin_boards` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- 게시판 종류 추가
INSERT INTO bulletin_boards (name) VALUES
('자유게시판'),
('인사게시판'),
('용어게시판');

-- free_bulletin 테이블
CREATE TABLE `free_bulletin` (
    `id` int NOT NULL AUTO_INCREMENT,
    `subject` varchar(500) NOT NULL,
    `contents` text NOT NULL,
    `writer` varchar(50) NOT NULL,
    `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `update_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `delete_date` datetime DEFAULT NULL,
    `file_path` varchar(200) DEFAULT NULL,
    `board_id` int NOT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_free_bulletin_board` (`board_id`),
    CONSTRAINT `fk_free_bulletin_board` FOREIGN KEY (`board_id`) REFERENCES `bulletin_boards` (`id`)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- comments 테이블
CREATE TABLE comments (
    id INT NOT NULL AUTO_INCREMENT,
    post_id INT NOT NULL,
    parent_id INT DEFAULT NULL,
    writer VARCHAR(50) NOT NULL,
    contents TEXT NOT NULL,
    create_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    update_date DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    delete_date DATETIME DEFAULT NULL,
    PRIMARY KEY (id),
    KEY fk_comments_post (post_id),
    KEY fk_comments_parent_id (parent_id),
    CONSTRAINT comments_ibfk_1 FOREIGN KEY (post_id) REFERENCES free_bulletin (id) ON DELETE CASCADE,
    CONSTRAINT fk_comments_parent_id FOREIGN KEY (parent_id) REFERENCES comments (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
