<?php
require_once '../conf.php';

//Передалть fetch


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
$f = false;
if($date_field == 'news_date'){
    $f = 'news_date';
    //Округлить старт день до 00 стоп до 23:59
    $start=null;
    if($frontData->dates->news_dates->start!==null){
        $prefix_for_invalid_date = " AND news_date!='Invalid Date'";
        $start = new DateTime($frontData->dates->news_dates->start);
        $start = $start->format('Y-m-d');
    }
    $stop_full = new DateTime($frontData->dates->news_dates->stop);
    $stop_full->modify('+1 day');
    $stop = $stop_full->format('Y-m-d');


} else {
    $f = 'parse_date';
    $start = new DateTime($frontData->dates->parse_dates->start);
    $start = $start->format('Y-m-d');

    $stop_full = new DateTime($frontData->dates->parse_dates->stop);
    $stop_full->modify('+1 day');
    $stop = $stop_full->format('Y-m-d');
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

//deb($all_data);

echo json_encode([
    'data' => $all_data,
    'frontData' => $frontData,
    'newsInSet'=> $newsInSet,
    'site' => $site,
    'start'=> $start,
    'stop'=> $stop,
//    'date_field'=>$date_field,
//'f'=>$f
//    'news_dates' => $frontData->dates->news_dates,
    ]);
