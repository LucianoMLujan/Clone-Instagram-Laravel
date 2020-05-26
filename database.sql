CREATE DATABASE IF NOT EXISTS clone_instagram;
USE clone_instagram;

CREATE TABLE IF NOT EXISTS users (
    id int not null auto_increment,
    rol VARCHAR(20),
    name VARCHAR(100),
    surname VARCHAR(200),
    nick VARCHAR(100),
    email VARCHAR(255),
    password VARCHAR(255),
    image VARCHAR(255),
    created_at DATETIME,
    updated_at DATETIME,
    remember_token VARCHAR(255),
    CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDb;

INSERT INTO users VALUES(null, 'user', 'tablon', 'lujan', 'Tabli von tabli', 'tablon@tablon.com', 'tabli', null, CURTIME(), CURTIME(), null);
INSERT INTO users VALUES(null, 'user', 'tux', 'lujan', 'Tuzi von tuzi', 'tux@tux.com', 'tuzi', null, CURTIME(), CURTIME(), null);

CREATE TABLE IF NOT EXISTS images (
    id int not null auto_increment,
    user_id int not null,
    image_path VARCHAR(255),
    description text,
    created_at DATETIME,
    updated_at DATETIME,
    CONSTRAINT pk_images PRIMARY KEY(id),
    CONSTRAINT fk_images_users FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDb;

INSERT INTO images VALUES(null, 1, 'test.jpg', 'descripcion de prueba', CURTIME(), CURTIME());
INSERT INTO images VALUES(null, 1, 'recital.jpg', 'descripcion de prueba', CURTIME(), CURTIME());
INSERT INTO images VALUES(null, 1, 'otra.jpg', 'descripcion de prueba', CURTIME(), CURTIME());
INSERT INTO images VALUES(null, 2, 'test.jpg', 'descripcion de prueba', CURTIME(), CURTIME());
INSERT INTO images VALUES(null, 2, 'mar.jpg', 'descripcion de prueba', CURTIME(), CURTIME());

CREATE TABLE IF NOT EXISTS comments (
    id int not null auto_increment,
    user_id int not null,
    image_id int not null,
    content text,
    created_at DATETIME,
    updated_at DATETIME,
    CONSTRAINT pk_comments PRIMARY KEY(id),
    CONSTRAINT fk_comments_users FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_comments_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDb;

INSERT INTO comments VALUES(null, 2, 1, 'Buena foto tabli', CURTIME(), CURTIME());
INSERT INTO comments VALUES(null, 1, 5, 'Hay que volver al mar tuzi', CURTIME(), CURTIME());

CREATE TABLE IF NOT EXISTS likes (
    id int not null auto_increment,
    user_id int not null,
    image_id int not null,
    created_at DATETIME,
    updated_at DATETIME,
    CONSTRAINT pk_likes PRIMARY KEY(id),
    CONSTRAINT fk_likes_users FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_likes_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDb;

INSERT INTO likes VALUES(null, 2, 2, CURTIME(), CURTIME());
INSERT INTO likes VALUES(null, 1, 4, CURTIME(), CURTIME());