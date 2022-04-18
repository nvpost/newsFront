<?php

$db = new PDO('mysql:host=localhost;dbname=news_site',
    'root',
    ''
);

$query=$db->query("SELECT COUNT(*) as count FROM news");
$query->setFetchMode(PDO::FETCH_ASSOC);
$row=$query->fetch();
$news_count=$row['count'];

$tagsArray =['agregator', 'Meyertec', 'Датчики', 'ОП', 'Кип', 'СПУ', 'ПЧВ', 'ПР'];

$tagsArrayCount= [];

foreach ($tagsArray as $t){
    $query=$db->query("SELECT COUNT(*) as count FROM news where group_id like '%".$t."%'");
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $row=$query->fetch();
    $tagsArrayCount[$t]=$row['count'];
}

$siteAndCountArray = [];
$sites = $db->query('SELECT * from news_donor')
    ->fetchAll();
$sitesArr = array_column($sites, 'name');

//Счетчик новосетей по сайтам
$siteAndCountArray=[];
foreach ($sites as $s){
    $site_id = $s['site_id'];
    $query=$db->query("SELECT COUNT(*) as count, lang, group_id FROM news where site_id='".$site_id."'");
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $row=$query->fetch();
    $siteAndCountArray[$site_id]['count']=$row['count'];
    $siteAndCountArray[$site_id]['lang']=$row['lang'];
    $siteAndCountArray[$site_id]['tags']=$row['group_id'];
}
ksort($siteAndCountArray);


echo json_encode([
    'count'=>$news_count,
    'tagCount'=>$tagsArrayCount,
    'siteAndCountArray'=>$siteAndCountArray
]);
