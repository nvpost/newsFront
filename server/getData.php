<?php

$db = new PDO('mysql:host=localhost;dbname=news_site',
    'root',
    ''
);

$res = $db->query('SELECT * from news');

echo json_encode(['data'=>$res->fetchAll()]);
