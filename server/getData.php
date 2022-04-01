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

$all_data = $db->query('SELECT * from news ORDER BY news_date DESC ')
    ->fetchAll();

//получаем теги
$tags_res = $db->query('SELECT group_id from news GROUP BY group_id')
    ->fetchAll(PDO::FETCH_COLUMN);
$tags = array_values(array_unique(explode(', ', implode(', ', $tags_res))));


$sites = $db->query('SELECT * from news_donor')
    ->fetchAll();

echo json_encode([
    'data'=>$all_data,
    'tags'=>$tags,
    'sites'=>$sites,
    ]);
