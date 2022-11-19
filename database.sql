CREATE DATABASE bistrolaza COLLATE utf8_czech_ci;

CREATE TABLE pages (
    pageID varchar(100) primary key,
    title text,
    menu text,
    content text,
    orderPage int
);

INSERT INTO pages SET
    pageID = "uvod",
    title = "BistroLaza | O nás",
    menu = "O nás",
    content = "...",
    orderPage = 1;

INSERT INTO pages SET
    pageID = "nabidka",
    title = "BistroLaza | Nabídka",
    menu = "Nabídka",
    content = "...",
    orderPage = 2;

INSERT INTO pages SET
    pageID = "kontakt",
    title = "BistroLaza | Kontakty",
    menu = "Kontakty",
    content = "...",
    orderPage = 3;

INSERT INTO pages SET
    pageID = "galerie",
    title = "BistroLaza | Galerie",
    menu = "Galerie",
    content = "...",
    orderPage = 4;

INSERT INTO pages SET
    pageID = "rezervace",
    title = "BistroLaza | Rezervace",
    menu = "Rezervace",
    content = "...",
    orderPage = 5;

INSERT INTO pages SET
    pageID = "404",
    title = "BistroLaza | Chyba 404",
    menu = "",
    content = "...",
    orderPage = 6;

INSERT INTO pages SET
    pageID = "blog",
    title = "BistroLaza | Blog",
    menu = "Blog",
    content = "...",
    orderPage = 7;

INSERT INTO pages SET
    pageID = "blog-clanek",
    title = "BistroLaza | Nejlepší Cheesecake",
    menu = "",
    content = "...",
    orderPage = 8;

SELECT * from pages ORDER BY `orderPage` asc;