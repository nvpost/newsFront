<?php
date_default_timezone_set('UTC');

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



$date_field = $frontData->dates->field;
$prefix_for_invalid_date = "";
if($date_field == 'news_date'){
    $start = $frontData->dates->news_dates->start;
    $stop = $frontData->dates->news_dates->stop;
    $prefix_for_invalid_date = " AND news_date!='Invalid Date'";
} else{
    $start = $frontData->dates->parse_dates->start;
    $stop = $frontData->dates->parse_dates->stop;
}


$where = "(".$date_field." BETWEEN '".$start."' AND '".$stop."')".$prefix_for_invalid_date;

if($where_like!=""){
    $where_like = $where_like .'AND'. $where;
}else{
    $where_like = 'WHERE '.$where;
}



$all_data = $db->query("SELECT * from news ".$where_like." ORDER BY parse_date DESC, news_date DESC".$limit.$offset)
    ->fetchAll();
$newsInSet = $db->query("SELECT COUNT(*) from news ".$where_like." ORDER BY news_date DESC")
    ->fetchColumn();



echo json_encode([
    'data' => $all_data,
    'frontData' => $frontData,
    'newsInSet'=> $newsInSet,
    'site' => $site,
//    'news_dates' => $frontData->dates->news_dates,
    ]);
