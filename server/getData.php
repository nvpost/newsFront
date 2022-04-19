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


$frontData = json_decode(file_get_contents("php://input"));

$limit = $frontData->limit ? " LIMIT ".$frontData->limit : "";
$offset = $frontData->offset ? " OFFSET ".$frontData->offset : "";



$active_tags = $frontData->tags ? implode(' OR group_id LIKE ', $frontData->tags) : false;

$where_like = $active_tags ? "WHERE group_id LIKE ".$active_tags : "";

$site = false;
if($frontData->site){
    $site = $db->query("SELECT * from news_donor WHERE name='".$frontData->site."'")
        ->fetchAll();

    $where_like =  "WHERE site_id='".$frontData->site."'";
}



$all_data = $db->query("SELECT * from news ".$where_like." ORDER BY parse_date DESC, news_date DESC".$limit.$offset)
    ->fetchAll();
$newsInSet = $db->query("SELECT COUNT(*) from news ".$where_like." ORDER BY news_date DESC")
    ->fetchColumn();

//получаем теги
//$tags_res = $db->query('SELECT group_id from news GROUP BY group_id')
//    ->fetchAll(PDO::FETCH_COLUMN);
//$tags = array_values(array_unique(explode(', ', implode(', ', $tags_res))));
//
//
//$sites = $db->query('SELECT * from news_donor GROUP BY name ORDER BY category')
//    ->fetchAll();
//$langs = $db->query('SELECT lang from news_donor GROUP BY lang')
//    ->fetchAll();




echo json_encode([
    'data' => $all_data,
//    'tags' => $tags,
//    'sites'=> $sites,
//    'langs' => $langs,
    'frontData' => $frontData,

    'newsInSet'=>$newsInSet,
    'site'=> $site
    ]);
