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

//$qwe = $db->query('SELECT * from news_donor ORDER BY news_date DESC ')
//    ->fetchAll();

$sites = $db->query('SELECT * from news_donor')
    ->fetchAll();


$siteAndCountArray=[];
foreach ($sites as $s){
    $site_id = $s['site_id'];
    $query=$db->query("SELECT COUNT(*) as count, lang FROM news where site_id='".$site_id."'");
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $row=$query->fetch();
//    deb($row);
    $siteAndCountArray[$site_id]['count']=$row['count'];
    $siteAndCountArray[$site_id]['lang']=$row['lang'];
}
ksort($siteAndCountArray);
deb($siteAndCountArray);

//foreach ($sitesArr as $k=>$s){
//    deb(array_unique($s));
//}

