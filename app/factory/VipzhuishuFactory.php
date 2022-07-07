<?php

namespace app\factory;

use app\i\FactoryInterface;

class VipzhuishuFactory implements FactoryInterface
{

    public static function buildListUrl($bookId, $i): string
    {
        return "http://www.vipzhuishu.com/book/{$bookId}.html";
    }

    public static function buildListRange(): string
    {
        return ".panel-chapterlist dd";
    }

    public static function buildListRules(): array
    {
        return [
            // 采集文章标题
            'title' => ['a', 'text'],
            // 采集链接
            'link'  => ['a', 'href'],
        ];
    }

    public static function buildContentRules(): array
    {
        return [
            'title'   => ['h1.readTitle', 'text'],
            'content' => ['#htmlContent','text'],
        ];
    }

    public static function buildContentPagesUrl($originUrl, $page): string
    {
        if ($page == 1) return $originUrl;
        // 第二页的翻页处理
        $newUrl = str_replace(".html", "_{$page}.html",$originUrl);
        $newUrl = str_replace("DidmDTp5","book", $newUrl);
        $newUrl = str_replace("t3fFtx6b","book", $newUrl);
        return $newUrl;
    }

    public static function needJS(): bool
    {
        return true;
    }

    public static function needPages(): int
    {
        return 2;
    }

    public static function beforeAddLinkToJob(&$one,$url)
    {
        $link        = explode("/", $one['link']);
        $link[3]     = 'book';
        $one['link'] = join("/", $link);
    }
}