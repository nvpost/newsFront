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
echo json_encode(['count'=>$news_count, 'tagCount'=>$tagsArrayCount]);
