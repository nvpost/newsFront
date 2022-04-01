<?php

function deb($v){
    echo "<pre>";
    print_r($v);
    echo "</pre>";
}
$db = new PDO('mysql:host=localhost;dbname=news_site',
    'root',
    ''
);

$qwe = $db->query('SELECT * from news_donor ORDER BY news_date DESC ')
    ->fetchAll();
