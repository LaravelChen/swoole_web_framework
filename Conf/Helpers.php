<?php
use Illuminate\Support\HtmlString;

if ( !function_exists('app')) {
    /**
     * 获取Di容器
     *
     * @param  string $abstract
     * @return mixed|\Core\Component\Di
     */
    function app($abstract = null)
    {
        if (is_null($abstract)) {
            return \Core\Component\Di::getInstance();
        }

        return \Core\Component\Di::getInstance()->get($abstract);
    }
}
if ( !function_exists('asset')) {
    /**
     * 转发静态文件
     *      \Conf\Config::getInstance()->getConf('ForwardingDomain')  转发域名
     * @param string $path 静态文件路径
     * @return string
     */
    function asset($path = '')
    {
        return \Conf\Config::getInstance()->getConf('ForwardingDomain') . '/' . $path;
    }
}

if ( !function_exists('url')) {
    /**
     * @param $path 基本的url跳转
     * @return string
     */
    function url($path)
    {
        return 'http://' . \Core\Http\Request::getInstance()->getHeader('host')[0] . '/' . $path;
    }
}

if ( !function_exists('currentUrl')) {
    /**
     * 获取当前的url
     * @return \Core\Http\Message\Uri
     */
    function currentUrl()
    {
        return \Core\Http\Request::getInstance()->getUri();
    }
}

if ( !function_exists('method_field')) {
    /**
     * Generate a form field to spoof the HTTP verb used by forms.
     *
     * @param  string $method
     * @return \Illuminate\Support\HtmlString
     */
    function method_field($method)
    {
        return new HtmlString('<input type="hidden" name="_method" value="' . $method . '">');
    }
}

if ( !function_exists('paginator')) {
    /**
     * 自定义分页
     * @param string $paginator data
     * @return string
     */
    function paginator($paginator = '')
    {
        $request = \Core\Http\Request::getInstance();
        $page = $request->getRequestParam('page') ?: 1;
        $win = new \Illuminate\Pagination\UrlWindow($paginator);
        $url_arr = $win->get(3);
        $text = '<ul class="pagination">';
        if ($paginator->hasPages()) { //有结果集才显示啊
            if ( !$paginator->onFirstPage()) {
                $text .= "<li><a href=\"{$paginator->previousPageUrl()}\" rel=\"prev\" class=\"page-numbers previous\">«</a></li>";
            } else {
                $text .= "<li class='disabled'><a href=\"{$paginator->previousPageUrl()}\" rel=\"prev\" class=\"page-numbers previous\">«</a></li>";
            }

            if (isset($url_arr['first'])) {
                foreach ($url_arr['first'] as $k => $v) {
                    if ($k == $paginator->currentPage()) {
                        $style = "<span class=\"page-numbers active\">$k</span>";
                        $text .= "<li class='active'>$style</li>";
                    } else {
                        $style = "<a href=\"{$v}\" class=\"page-numbers\">$k</a>";
                        $text .= "<li>$style</li>";
                    }
                }
            }

            if (isset($url_arr['slider'])) {

                foreach ($url_arr['slider'] as $k => $v) {
                    if ($k == $paginator->currentPage()) {
                        $style = "<span class=\"page-numbers current\">$k</span>";
                    } else {
                        $style = "<a href=\"{$v}\" class=\"page-numbers\">$k</a>";
                    }
                    $text .= "<li>$style</li>";
                }
            } else {
                if ($url_arr['last'])
                    $text .= "<li class=\"disabled\"><span class=\"page-numbers\">...</span></li>";
            }

            if (isset($url_arr['last'])) {
                foreach ($url_arr['last'] as $k => $v) {
                    if ($k == $paginator->currentPage()) {
                        $style = "<span class=\"page-numbers current\">$k</span>";
                    } else {
                        $style = "<a href=\"{$v}\" class=\"page-numbers\">$k</a>";
                    }
                    $text .= "<li>$style</li>";
                }
            }

            if ($paginator->lastPage() != $page) {
                $text .= "<li><a href=\"{$paginator->nextPageUrl()}\" rel=\"prev\" class=\"page-numbers next\">»</a></li>";
            } else {
                $text .= "<li class='disabled'><a href=\"{$paginator->nextPageUrl()}\" rel=\"prev\" class=\"page-numbers next\">»</a></li>";

            }

        }
        $text .= '</ul>';
        return $text;
    }
}

if ( !function_exists('csrf_token')) {
    /**
     * 返回token
     * @return mixed|null
     */
    function csrf_token()
    {
        return \Core\Http\Request::getInstance()->session()->get('_token');
    }
}
