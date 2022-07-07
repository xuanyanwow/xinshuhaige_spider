<?php

namespace app\factory;

use app\i\FactoryInterface;

class XbiqugeFactory implements FactoryInterface
{

    public static function buildListUrl($bookId, $i): string
    {
        return "https://www.xbiquge.la/{$bookId}";
    }

    public static function buildListRange(): string
    {
        return "#list dd";
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
            'title'   => ['.bookname h1', 'text'],
            'content' => ['#content','text'],
        ];
    }

    public static function buildContentPagesUrl($originUrl, $page): string
    {
        return $originUrl;
    }

    public static function needJS(): bool
    {
        return false;
    }

    public static function needPages(): int
    {
        return 1;
    }

    public static function beforeAddLinkToJob(&$one,$url)
    {
        $one['link'] = "https://www.xbiquge.la/".$one['link'];
    }
}