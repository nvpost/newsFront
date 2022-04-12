<?php
function deb($v){
    echo "<pre>";
    print_r($v);
    echo "</pre>";
}
$frontData = json_decode(file_get_contents("php://input"));

$limit = $frontData->limit ? " LIMIT ".$frontData->limit : "";

$db = new PDO('mysql:host=localhost;dbname=news_site',
    'root',
    ''
);

$all_data = $db->query('SELECT * from news ORDER BY news_date DESC'.$limit)
    ->fetchAll();

//получаем теги
$tags_res = $db->query('SELECT group_id from news GROUP BY group_id')
    ->fetchAll(PDO::FETCH_COLUMN);
$tags = array_values(array_unique(explode(', ', implode(', ', $tags_res))));


$sites = $db->query('SELECT * from news_donor GROUP BY name ORDER BY category')
    ->fetchAll();
$langs = $db->query('SELECT lang from news_donor GROUP BY lang')
    ->fetchAll();

echo json_encode([
    'data'=>$all_data,
    'tags'=>$tags,
    'sites'=>$sites,
    'langs' => $langs,
    'frontData'=>$frontData->limit
    ]);
