<?php include(VIEWS_DIR .'/header.php'); ?>
</head>
<body>	
    <div id="content">

        <h1>HTML Library</h1>
        <?php
        //Escaping text
        $fromDB = "This is a example text <a href='#'>here</a>";
        echo "[esc: Escaped text] ". $this->html->esc($fromDB). "<br />";
        echo "[Unescaped text] ". $fromDB;
        echo "<br />";

        echo "[urlencode] ". $this->html->urlencode(["key1" => "action1","key2" => "action2","key3" => "action3"]);
        echo "<br />";

        echo "[splits] <pre>". var_dump($this->html->splits("2,34,45,23",",")) ."</pre>";
        echo "<br />";

        echo "[title_case] here comes the sun. : ". $this->html->title_case("here comes the sun.");
        echo "<br />";

        echo "[cap] purple haze. : ". $this->html->cap("purple haze.");
        echo "<br />";

        echo "[lcase] HELLO WORLD. : ". $this->html->lcase("HELLO WORLD.");
        echo "<br />";

        echo "[ucase] hello world. : ".$this->html->ucase("hello world.");
        echo "<br />";

        echo "[is_empty] '' :";
        if ($this->html->is_empty("")) {
            echo "Yes, it is empty.";
        }
        echo "<br />";
        echo "<br />";

        echo "<h4>Test List - element builder</h4>";
        echo "[el_list]". $this->html->el_list(["John","Jill","Ron"],'ul',["id"=>"styleone","class"=>"mystyle","style"=>"color:blue;font-size:16px"]);
        echo "<br />";

        echo "[el_list]". $this->html->el_list(["Jack","Jill","Ron"],'ol');
        echo "<br />";

        ?>

        
    </div>

<?php include(VIEWS_DIR .'/footer.php'); ?>