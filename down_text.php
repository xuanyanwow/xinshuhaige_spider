<?php
require_once("vendor/autoload.php");

use QL\QueryList;


$book_id = 78156;
$url = "https://mm.xinshuhaige.org/";

$redis = new Redis(); 
$redis->connect('127.0.0.1', 6379);
$redis->auth('123');
$zcad = $redis->ZCARD($book_id);
for($i =1;$i<=$zcad;$i++){
    $link = $redis->zrange($book_id, $i-1, $i-1);
    
    $ql = QueryList::get($url.$link[0]);
    $rules = [
        'title' => ['h1.headline','text'],
        'content' => ['div.content','text'],
    ];
    $rt = $ql->rules($rules)->query()->getData()->all();
    
    // 生成txt
    file_put_contents(__DIR__."/{$book_id}.txt", $rt['title']."\n\n".$rt['content']."\n\n",FILE_APPEND);
}