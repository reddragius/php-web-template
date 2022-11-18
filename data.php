<?php
    class Page {
        public $pageID;
        public $title;
        public $menu;

        function __construct($pageID, $title, $menu)
        {
            $this->pageID = $pageID;
            $this->title = $title;
            $this->menu = $menu;
        }
    };

    $pageList = [
        "uvod" => new Page("uvod", "BistroLaza", "O nás"),
        "nabidka" => new Page("nabidka", "BistroLaza | Nabídka", "Nabídka"),
        "kontakt" => new Page("kontakt", "BistroLaza | Kontakty", "Kontakty"),
        "galerie" => new Page("galerie", "BistroLaza | Galerie", "Galerie"),
        "rezervace" => new Page("rezervace", "BistroLaza | Rezervace", "Rezervace"),
        "blog" => new Page("blog", "BistroLaza | Blog", ""),
        "blog-clanek" => new Page("blog-clanek", "BistroLaza | Nejlepší Cheesecake", ""),
        "404" => new Page("404", "BistroLaza | Chyba 404", "")
    ];
