<?
$publications = $args->folder->publications()->fetchAll();
?>

<script type="text/javascript">
    $(function () {
//        var img = new Image();
//        img.onload = function() {
//            console.log(this.width + 'x' + this.height);
//        }
//        img.src = 'image1.jpg';
    });
    $(window).load(function () {
        function bindHover ($el) {
            $('.slider img.after').unbind('mouseover').unbind('mouseout');
            $('.slider img.before').unbind('mouseover').unbind('mouseout');

            $('img.after', $el).bind('mouseover', function () {
//            $(this).fadeOut();
//                $(this).next().fadeIn();
                $('img.before', $el).fadeIn();
                $(this).hide();
            });
            $('img.before', $el).bind('mouseout', function () {
//            $(this).fadeOut();
//                $(this).prev().fadeIn();
                $('img.after', $el).fadeIn();
                $(this).hide();
            });
        }

        $('.scroll-pane').jScrollPane({animateTo: true});
        $('.scroll-pane img').click(function () {
            $('.slider div.item').hide();
            $('.slider').attr('data-current-id', $(this).attr('data-id'));

            var $el = $('.slider div[data-id=' + $(this).attr('data-id') + ']');
            $el.fadeIn(); //blind

            $('.desc', $el).show();

            $('#text-description .item').hide();
            $('#text-description #' + $(this).attr('data-id')).fadeIn();

            bindHover($el);
        });

        var doPrevNavigation = function () {
            var $prev = $('.slider div[data-id=' + $('.slider').attr('data-current-id') + ']').prev('div.item');
            if (!$prev.length) {
                return false;
            }

            $('.slider div.item').hide();
            $('.slider').attr('data-current-id', $prev.attr('data-id'));
            $prev.fadeIn();
            $('.desc', $prev).show();

            bindHover($prev);

            var $preview = $('.scroll-pane img[data-id=' + $prev.attr('data-id') + ']');
            $('.scroll-pane')[0].scrollTo('#' + $prev.attr('data-id')); //$preview.offset().top

            $('#text-description .item').hide();
            $('#text-description #' + $prev.attr('data-id')).fadeIn();

            return false;
        };
        var doNextNavigation = function () {
            var $next = $('.slider div[data-id=' + $('.slider').attr('data-current-id') + ']').next('div.item');
            if (!$next.length) {
                return false;
            }

            $('.slider div.item').hide();
            $('.slider').attr('data-current-id', $next.attr('data-id'));
            $next.fadeIn();
            $('.desc', $next).show();

            bindHover($next);

            var $preview = $('.scroll-pane img[data-id=' + $next.attr('data-id') + ']');
            $('.scroll-pane')[0].scrollTo('#' + $next.attr('data-id'));

            $('#text-description .item').hide();
            $('#text-description #' + $next.attr('data-id')).fadeIn();

            return false;
        };

        $('.slider .prev').click(doPrevNavigation);
        $('.slider .next').click(doNextNavigation);

        $('.slider').attr('data-current-id', $('.slider div.item:first').attr('data-id'));
        $('.slider div.item:first .desc').show();
        bindHover($('.slider div.item:first'));

        $('#text-description div.item:first').show();

        var bindKeyboard = function () {
            var LEFT_KEY = 37;
            var RIGHT_KEY = 39;
            $(document).keydown(function(e){
                if (e.keyCode == LEFT_KEY) {
                    doPrevNavigation();
                    return false;
                }
            });
            $(document).keydown(function(e){
                if (e.keyCode == RIGHT_KEY) {
                    doNextNavigation()
                    return false;
                }
            });
        }

        bindKeyboard();

        $('a.lightbox').lightBox({
            imageLoading:			'/resources/lightbox/images/lightbox-ico-loading.gif',
            imageBtnPrev:			'',
            imageBtnNext:			'',
            imageBtnClose:			'/resources/lightbox/images/lightbox-btn-close.gif',
            imageBlank:				'/resources/lightbox/images/lightbox-blank.gif',
            onClose: function () {
                bindKeyboard();
            }
        });
    });
</script>
<div id="root" class="index-page">
    <div id="aside">
        <a href="/" id="logo"></a>
        <div class="logo-description"><?= $core->sts->logo_description; ?></div>
    </div>
    <div id="content">
        <div id="top">
            <div class="menu">
            <?
//                $context->out('<div><a href="/">Главная</a><span></span></div>');
                foreach (site::fetch('site')->children() as $item) {
                    $context->out('<div><a href="'.$item->url().'">'.$item->description.'</a><span></span></div>');
                }
            ?>
            </div>
            <div class="phone"><?= $core->sts->phone; ?></div>
        </div>
        <div class="images">
            <div class="slider">
                <?
                $previews = array();
                $psize = new Size(110);
//                $size = new Size(900, 600);
                foreach ($publications as $i=>$pub) {
                    if (!$pub->datarow->files || $pub->datarow->files->count() < 2) {
                        continue;
                    }

                    $after = $pub->datarow->files->item(0);
                    $before = $pub->datarow->files->item(1);

                    $previews[$pub->id] = $after;

                    $context->out('<div data-id="item'.$pub->id.'" id="item'.$pub->id.'" class="item">
                        <img src="'.$after->src(/*$size*/).'" alt="" class="after" />'
                        //.'<a href="'.$after->src().'" class="lightbox">'
                        .'<img src="'.$before->src(/*$size*/).'" alt="" class="before" />'
                        //.'</a>'
                        .($pub->datarow->description ? '<div class="desc">
                            <div class="wrap">'.annotation($pub->datarow->description).'</div>
                        </div>' : '').
                        ($pub->datarow->author ? '<div class="author">Фото: '.$pub->datarow->author.'</div>' : '').
                    '</div>');
                }
                ?>
                <div class="pager">
                    <a href="#" class="prev"></a>
                    <a href="#" class="next"></a>
                </div>
            </div>
            <div class="scroll-pane">
                <?
                foreach ($previews as $id=>$preview) {
                    $context->out('<img src="'.$preview->src($psize).'" alt="" data-id="item'.$id.'" id="item'.$id.'" />');
                }
                ?>
            </div>
        </div>
        <div id="text-description">
        <?
            foreach ($publications as $pub) {
                $context->out('<div id="item'.$pub->id.'" class="item">'.$pub->datarow->text.'</div>');
            }
        ?>
        </div>
    </div>
</div>
