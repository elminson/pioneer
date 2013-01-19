<?
function init(&$template, $args)
{
    global $core;

    /*if (!$core->nav->folder){
             $core->nav->folder = site::fetch('about');
         }

         if ($core->nav->folder->level == 2 && !$core->nav->folder->publications && $core->nav->folder->children){
             $core->nav->folder = $core->nav->folder->children()->item(0);
         }

         $args->folder = $core->nav->folder;*/

    pagemeta($args, $template);
}

function pagemeta($args, &$template)
{
    return;
    global $core;

    $title = $core->nav->site->description . ' - ' . $args->folder->description;

    $template->templates_head_title = $title . ($title && $args->folder->header_statictitle ? ' - ' : '') . $args->folder->header_statictitle;
    $template->templates_head_metakeywords = $args->folder->header_keywords;
    $template->templates_head_metadescription = $args->folder->header_description;
    $template->templates_head_aditionaltags .= $args->folder->header_aditionaltags;
}

function get_pubs($folder, $is_text = false)
{
    $type = $is_text ? '' : 'catalogue'; //template_default

    $list = array();
    $pubs = $folder->publications();

    while ($item = $pubs->fetchNext()) {
        if ($item->template == $type) {
            $list[] = $item;
        }
    }

    return $list;
}

/*content utils*/
function annotation($html, $words = 50, $ellipsis = "...", $raw = false)
{
    if ($raw) {
        $val = mb_substr($html = html_strip($html), 0, $words, mb_detect_encoding($html));
        return $val . (strlen($html) > strlen($val) ? $ellipsis : '');
    }

    return FirstNWords(html_strip($html), $words, $ellipsis);
}

function split_by($text, $count)
{
    if (!$text || !$count) {
        return;
    }

    $str = array();

    $text = str_replace('\r\n', '', $text);
    $cells = ceil(mb_strlen($text, 'utf-8') / $count);
    $start = 0;

    for ($i = 0; $i < $cells; $i++) {
        $_ = mb_substr($text, $start, $count, 'utf-8');

        if ($i < $cells - 1) {
            $__ = preg_split('/[^\s]*$/i', $_);

            if (!count($__)) {
                continue;
            }

            $start = $start + mb_strlen($__[0], 'utf-8');

            $_ = $__[0];
        } else {
            $start = $i * $count;
        }

        $str[] = $_;
    }

    return $str;
}

function fdate($start, $end = '', $format = 'd/m/Y')
{
    $start = strtotime($start);
    $end = $end ? strtotime($end) : '';

    $dmys = date('d.m.y', $start);
    $dmye = $end ? date('d.m.y', $end) : $dmys;

    return date($format, $start) . ($dmye != $dmys ? ' - ' . date($format, $end) : '');
}

function fadate($start, $end = '')
{
    $start = strtotime($start);
    $end = $end ? strtotime($end) : '';

    $dmys = date('d.m.y', $start);
    $dmye = $end ? date('d.m.y', $end) : $dmys;

    $ms = date('m', $start);
    $me = date('m', $end);

    return '<span>' . date('d', $start) . '</span>' . ($ms < $me ? strftime_hmon($ms) : '')
        . ($dmye != $dmys ? '<span>-' . date('d', $end) . '</span>' : '')
        . ($me >= $ms ? ' ' . strftime_hmon($me) : '');
}

/*utils*/
function monthlength($min, $max)
{
    $miny = date('Y', $min);
    $maxy = date('Y', $max);
    $minm = date('m', $min);
    $maxm = date('m', $max);

    $duration = ($maxy - $miny - 1) * 12 + (12 - $minm + 1) + $maxm;
    if ($duration < 0)
        $duration = 0;

    return $duration;
}

function getpage()
{
    global $core;
    return !$core->rq->pg || intval($core->rq->pg) < 0 ? 1 : $core->rq->pg;
}

/*visual*/

function menumain($root, $current)
{
    global $core;

    //$core->nav->folder->children()

    $menu = $root->children();

    $place = array();
    $selected_place = null;
    $s = '';

    foreach ($menu as $item) {
        if (!$item->published) {
            continue;
        }

        if ($item->is_place) {
            if ($current->isChildOf($item)) {
                $selected_place = $item;
            }

            $place[] = $item;
        }
    }

    if (count($place)) {
        if (!$selected_place) {
            $selected_place = $place[0];
        }

        if ($selected_place && $selected_place->children) {
            $s .= '<div class="place"><h3>' . $selected_place->description . '</h3><ul>';
            foreach ($selected_place->children() as $item) {
                $url = $item->children ? $item->children()->first()->url() : $item->url();
                $s .= '<li' . ($current->isChildOf($item) ? ' class="selected"' : '') . '><a href="' . $url . '">' . $item->description . '</a></li>';
            }
            $s .= '</ul></div>';
        }
    }

    $s .= '<div class="base"><ul>';
    foreach ($menu as $item) {
        if ($item->id == $selected_place->id || !$item->published) { //$item->is_place
            continue;
        }
        $url = $item->url ? $item->url : ($item->children ? $item->children()->first()->url() : $item->url());
        $s .= '<li><a href="' . $url . '"' . ($current->isChildOf($item) ? ' class="selected"' : '') . '>' . $item->description . '</a></li>';
    }
    $s .= '</ul></div>';

    return '<div class="menumain">' . $s . '</div>';
}

function menu($folder)
{
    $s = '';
    foreach ($folder->children() as $item) {
        $s .= '<li><a href="' . $item->url() . '">' . $item->description . '</a></li>';
    }
    return '<ul>' . $s . '</ul>';
}

function menupath($path = null, $raw = false)
{
    global $core;

    if (!$path) {
        $path = $core->nav->folder->path();
    }

    $i = 0;
    $c = $path->count();
    $s = '';
    foreach ($path as $item) {
        if ($item instanceof Site || !$item->published)
            continue;

        $cls = array();

        if ($i++ == 0) {
            $cls[] = 'first';
        }

        if ($i == $c) {
            $cls[] = 'last';
        }

        $cls = count($cls) ? ' class="' . implode(' ', $cls) . '"' : '';

        $s .= $core->nav->folder->id == $item->id
            ? ' | <span' . $cls . '>' . $item->description . '</span>'
            : ' | <a href="' . $item->url() . '"' . $cls . '>' . $item->description . '</a>';
    }

    if ($raw)
        return $s;

    return $s ? '<div class="menu_path">' . substr($s, 3) . '</div>' : '';
}

function pagetop($folder, $publications)
{
    global $core;

    $title = $folder->level > 3 ? $folder->parent() : $folder;

    $menu = '';
    if ($folder->level >= 3) {
        foreach ($folder->parent()->children() as $item) {
            $menu .= '<li><a href="' . $item->url() . '"' . ($folder->isChildOf($item) ? ' class="selected"' : '') . '>'
                . $item->description . '</a></li>';
        }
    }

    $pager = null;
    if (!$core->nav->publication && $publications->affected() > $core->sts->pagesize) {
        $pager = pager($publications->affected(), $core->rq->pg ? $core->rq->pg : 1, $core->sts->pagesize, 10);
    }

    return '<div class="page_top"><h1 class="title">' . $title->description . ($pager ? $pager->render() : '') . '</h1>'
        . ($menu ? '<ul class="menu">' . $menu . '</ul>' : '').'</div>';

    /*global $core;

$root = $core->nav->folder->level > 2 ? $core->nav->folder->parent() : $core->nav->folder;

return '<div class="page_top"><h1>' . $root->description . '</h1>' . menupath($root->children()) . '</div>';*/
}

function pagebottom($folder, $publications)
{
    global $core;

    if (!$core->nav->publication && $publications->affected() > $core->sts->pagesize) {
        $pager = pager($publications->affected(), $core->rq->pg ? $core->rq->pg : 1, $core->sts->pagesize, 10);
        return '<div class="page_bottom"><div class="page_bottom_wrp">'.$pager->render().'</div></div>';
    }
}

function pager($total, $page = '', $pagesize = '', $pagersize = '', $prefix = '', $arg = 'pg')
{
    if ($total < 0) $total = 0;
    if ($pagesize <= 0) $pagesize = 20;
    if ($pagersize <= 0) $pagersize = 5;

    $page = $page ? $page : site::$i->url->pg * 1;
    $pg = $page;

    if (ceil($total / $pagesize) < $page)
        $pg = ceil($total / $pagesize);

    if ($page <= 0)
        $pg = 1;

    $pager = new Pager($pg, $total, $pagesize, $pagersize, $prefix, $arg);

    $pager->btag = new PagerItemFormat('<div class="pager">');
    $pager->etag = new PagerItemFormat('</div>');

    $pager->prev = new PagerItemFormat('', '', '');
    $pager->next = new PagerItemFormat('', '', '');

    $pager->first = new PagerItemFormat('');
    $pager->last = new PagerItemFormat('');

    /*$pager->first = new PagerItemFormat('<td>{{Html}}</td>', '&laquo; первая', '');
         $pager->last = new PagerItemFormat('<td>{{Html}}</td>', 'последняя &raquo;', '');*/

    $pager->decimals = new PagerItemFormat('{{Html}}', '', '');
    $pager->selected = new PagerItemFormat('<span>{{Html}}</span>', '', ''); //<a href="#">
    $pager->ellipsis = new PagerItemFormat('{{Html}}', '...', '');
    //$pager->sep = new PagerItemFormat('');

    $pager->return = true;

    return $pager;
}

function imagetext($string, $color, $bgcolor = null, $attrs = '')
{
    $font = new Font('MyriadPro-Semibold.otf', '/resources/fonts/');
    return Text2Image::t2iImg(mb_convert_encoding($string, 'cp1251', 'utf-8'), $bgcolor, $color, null, null, $font, $attrs);
}

function extractby($list, $prefix)
{
    $l = array();
    $len = strlen($prefix);

    foreach ($list as $k => $v)
        if (substr($k, 0, $len) == $prefix)
            $l[substr($k, $len)] = $v;

    return $l;
}

function sout()
{
    foreach (func_get_args() as $arg) {
        $s[] = json_encode($arg); //'JSON.parse('.json_encode($arg).')';
    }
    echo '<script type="text/javascript">console.log(' . implode(', ', $s) . ')</script>';
}

global $strings, $strings_time, $strings_tickets_count, $strings_order;

$strings = array(
    'email' => 'E-mail',
    'name' => 'Имя',
    'phone' => 'Телефон',
    'tickets_count' => 'Сколько билетов',
    'tickets_date' => 'День',
    'tickets_time' => 'Время',
    'band' => 'Событие'
);
$strings_time = array(1 => 'Утро', 'День', 'Вечер');
$strings_tickets_count = array(1 => 'Один билет', 'Два билета', 'Три билета', 'Четыре билета', 'Много билетов'); //Я один, Нас двое, Нас трое
$strings_order = array(1 => 'Нас двое', 'Нас четверо', 'Нас шестеро', 'Большая компания');

?>