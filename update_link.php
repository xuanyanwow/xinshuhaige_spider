<?php
require_once("vendor/autoload.php");


use app\config\RedisConfig;
use app\facade\FactoryFacade;
use app\i\FactoryInterface;
use QL\QueryList;



$total_page = 1;// 章节列表总共几页
$bookName = "我有一座恐怖屋";
$url = "https://www.xbiquge.la/19/19653/";

/** ========================================= 以上参数手动填  =================================== */

/** @var FactoryInterface $factory */
[$factory, $bookId] = FactoryFacade::parser($url);


$redis = new Redis();
$redis->connect(RedisConfig::$host, RedisConfig::$port);
$redis->auth(RedisConfig::$auth);

$nowChapter = 0;

for ($i = 1; $i <= $total_page; $i++) {
    $ql    = QueryList::get($factory::buildListUrl($bookId, $i));
    $rules = $factory::buildListRules();
    $range = $factory::buildListRange(); // 切片选择器
    $rt    = $ql->rules($rules)->range($range)->query()->getData();

    foreach ($rt->all() as $item => $one) {
        $factory::beforeAddLinkToJob($one, $url);
        $nowChapter++;
        $one['chapter']  = $nowChapter;
        $one['bookName'] = $bookName;
        $redis->lpush("spider_txt", json_encode($one, 256));
    }
}