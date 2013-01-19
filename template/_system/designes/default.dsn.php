<?
$publications = $args->folder->publications();
?>
<div id="root" class="page-default">
    <div id="aside">
        <a href="/" class="logo"></a>
        <div class="logo-description"><?= $core->sts->logo_description; ?></div>
    </div>
    <div id="content">
        <div class="content-top">
            <div class="menu">
                <?
//                $context->out('<div><a href="/">Главная</a><span></span></div>');
                foreach (site::fetch('site')->children() as $item) {
                    if ($item->published) {
                        $context->out('<div><a href="'.$item->url().'">'.$item->description.'</a><span></span></div>');
                    }
                }
                ?>
            </div>
            <div class="email"><a href="mailto:<?= $core->sts->email; ?>"><?= $core->sts->email; ?></a></div>
            <div class="phone"><?= $core->sts->phone; ?></div>
        </div>
        <div class="content-middle">
            <?= $publications->out(); ?>
        </div>
    </div>
</div>
