<?php
require_once("vendor/autoload.php");

use app\config\RedisConfig;
use app\facade\FactoryFacade;
use app\i\FactoryInterface;
use QL\QueryList;


$redis = new Redis();
$redis->connect(RedisConfig::$host, RedisConfig::$port);
$redis->auth(RedisConfig::$auth);

while($one = $redis->lPop("spider_txt")){
    $one = json_decode($one, true);
    /** @var FactoryInterface $factory */
    [$factory, $bookId] = FactoryFacade::parser($one['link']);

    $writer = '';
    for ($page = 1; $page <= $factory::needPages(); $page++){
        $url = $factory::buildContentPagesUrl($one['link'], $page);

        if ($factory::needJS()){
            $ql = QueryList::getInstance()->use(\QL\Ext\PhantomJs::class, __DIR__."\phantomjs\bin\phantomjs.exe")->browser(function (\JonnyW\PhantomJs\Http\RequestInterface $r) use($url){
                $r->setMethod('GET');
                $r->setUrl($url);
                $r->setTimeout(10000); // 10 seconds
                $r->setDelay(0.01); // 3 seconds
                return $r;
            });
        }else{
            $ql = QueryList::get($url);
        }
        $rules = $factory::buildContentRules();
        $rt = $ql->rules($rules)->query()->getData()->all();

        if ($page == 1){
            $writer .=  $rt['title']."\n\n";
        }
        $writer .= $rt['content']."\n";
    }

    $dir = __DIR__."/store/{$one['bookName']}/";
    if (!is_dir($dir)) mkdir($dir);

    file_put_contents($dir."{$one['chapter']}_{$one['title']}.txt", $writer);
    echo "{$one['chapter']}_{$one['title']}.txt ---- ok\n";
}