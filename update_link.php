<?php
require_once("vendor/autoload.php");


use QL\QueryList;



$url = "https://www.xinshuhaige.org/";


$total_page = 4;// 章节列表总共几页
$book_id = 78156;// 书的id 从url分析

$redis = new Redis(); 
$redis->connect('127.0.0.1', 6379);
$redis->auth('123');
        
$now = 1;
for($i = 1 ;$i <= $total_page ; $i++){
    $ql = QueryList::get($url."/{$book_id}_{$i}/");
    $rules = [
        // 采集文章标题
        'title' => ['a','text'],
        // 采集链接
        'link' => ['a','href'],
    ];
    // 切片选择器
    $range = "#novel{$book_id} dd";
    $rt = $ql->rules($rules)->range($range)->query()->getData();


    foreach ($rt->all() as $one){
        $redis->zadd($book_id, $now, $one['link']);
        $now++;
    }
}