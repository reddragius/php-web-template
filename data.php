<?php
    $db = new PDO(
        "mysql:host=localhost;dbname=bistrolaza;charset=utf8",
        "root",
        "", // heslo
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ),
    );
    

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

        function getTitle() 
        {
            return $this->title;
        }

        function getMenu() 
        {
            return $this->menu;
        }

        function getContent() 
        {
            global $db;
            $query = $db->prepare("SELECT content FROM pages WHERE pageID = ?");
            $query->execute([$this->pageID]);

            $result = $query->fetch();

            // pokud by databaze nic nevratila, tak vratime prazdny obsah
            if ($result == false)
            {
                return "";
            }
            else
            {
                return $result["content"];
            }
        }

        function setContent($content) 
        {
            global $db;

            $query = $db->prepare("UPDATE pages SET content = ? WHERE pageID = ?");
            $query->execute([$content, $this->pageID]);
        }

        function save($originPageID)
        {          
            global $db;

            if ($originPageID != "")
            {
                // jde o aktualizaci existujici stranky
                $query = $db->prepare("UPDATE pages SET pageID = ?, title = ?, menu = ? WHERE pageID = ?");
                $query->execute([$this->pageID, $this->title, $this->menu, $originPageID]);
            }
            else
            {
                // jde o pridavani nove stranky
                // zjisteni maximalniho poradi
                $query = $db->prepare("SELECT MAX(orderPage) AS orderPage FROM pages");
                $query->execute();
                $result = $query->fetch();
                // vezmeme nejvysi poradi ktere je v tabulce a navysime o 1
                $orderPage = $result["orderPage"] + 1;

                $query = $db->prepare("INSERT INTO pages SET pageID = ?, title = ?, menu = ?, orderPage = ?");
                $query->execute([$this->pageID, $this->title, $this->menu, $orderPage]);
            }
        }

        function delete() 
        {
            //delete page
            global $db;

            $query = $db->prepare("DELETE FROM pages WHERE pageID = ?");
            $query->execute([$this->pageID]);
        }
    }

    $pageList = [];
    $query = $db->prepare("SELECT pageID, title, menu FROM pages ORDER BY orderPage");
    $query->execute();
    $pages = $query->fetchAll();
    // vezmeme pole radek, ktere nam vratila databaze a postupne
    // nakrmime pole $pageList jednotlivymi instancemi tridy Page
    foreach ($pages as $page)
    {
        $pageID = $page["pageID"];
        // pridame do pole novou instanci tridy Page
        $pageList[$pageID] = new Page($pageID, $page["title"], $page["menu"]);
    }