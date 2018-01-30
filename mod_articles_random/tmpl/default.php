<?php
/**
 * Random articles module
 */

defined('_JEXEC') or die;

$doc = JFactory::getDocument();
$js = <<<JS
(function ($) {
    $(document).on('click', 'button.refresh-random', function() {
        var catids = $(this).data('categories'),
            count = $(this).data('count'),
            request = {
                'option' : 'com_ajax',
                'module' : 'articles_random',
                'format' : 'json',
                'catids' : catids,
                'count'  : count
            };

        $.ajax({
            type      : 'POST',
            data      : request,
            success   : function (response) {
                var newlist = '';
                if(response.data) {
                    $.each(response.data, function (index, value) {
                        newlist = newlist + '<li><a href="' + value.link + '">' + value.title + '</a></li>';
                    });

                    $('ul.random-articles').html(newlist);
                }
            },
            error     : function (response) {
                console.log(response);
            }
        });
    });
})(jQuery)
JS;

$doc->addScriptDeclaration($js);

?>

<ul class="random-articles">
<?php foreach($articles as $article): ?>
    <li>
        <a href="<?php echo $article->link; ?>">
            <?php echo $article->title; ?>
        </a>
    </li>
<?php endforeach; ?>
</ul>

<button class="refresh-random" data-categories="<?php echo implode(',', $params->get('catid')); ?>" data-count="<?php echo $params->get('count', 5); ?>"><?php echo JText::_('MOD_ARTICLES_RANDOM_REFRESH'); ?></button>