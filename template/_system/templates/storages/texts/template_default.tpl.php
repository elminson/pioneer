<?
$context->out('<div class="texts-default">'
    .($args->datarow->photo->isValid ? '<img src="'.$args->datarow->photo->src().'" alt="" class="top-image" />' : '')
    .'<div class="text">'
    .($args->datarow->title ? '<h1>'.$args->datarow->title.'</h1>' : '')
    .$args->datarow->text
    .'</div>'
.'</div>');
?>