<?php
/**
 * Articles Newsflash Advanced
 *
 * @author    TemplateMonster http://www.templatemonster.com
 * @copyright Copyright (C) 2012 - 2013 Jetimpex, Inc.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 
 * Parts of this software are based on Articles Newsflash standard module
 * 
*/
defined('_JEXEC') or die;
$item_heading = $params->get('item_heading', 'h4');
$item_images = json_decode($item->images);
$urls    = json_decode($item->urls);
require_once (JPATH_BASE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'icon.php');
if($layout!='edit'){
	$canEdit = $item->params->get('access-edit');
	if ($canEdit) : ?>
	<!-- Icons -->
	<?php if ($canEdit || $item->params->get('show_print_icon') || $item->params->get('show_email_icon')) : ?>
		<?php echo html_entity_decode(JLayoutHelper::render('joomla.content.icons', array('params' => $item->params, 'item' => $item, 'print' => false))); ?>
	<?php endif;
	endif;
}

if ($params->get('intro_image')):
if (isset($item_images->image_intro) and !empty($item_images->image_intro)) :
$imgfloat = (empty($item_images->float_intro)) ? $params->get('float_intro') : $item_images->float_intro; ?>
<!-- Intro Image -->
<figure class="item_img img-intro img-intro__<?php echo htmlspecialchars($params->get('intro_image_align')); ?>"> 
	<?php if ((($params->get('item_title') && $params->get('link_titles')) || $params->get('readmore')) && $item->readmore) : ?>
	<a href="<?php echo $item->link;?>">
	<?php endif; ?>
		<img src="<?php echo htmlspecialchars($item_images->image_intro); ?>" alt="<?php echo htmlspecialchars($item_images->image_intro_alt); ?>">
		<?php if ($item_images->image_intro_caption): ?>
		<figcaption><?php echo htmlspecialchars($item_images->image_intro_caption); ?></figcaption>
		<?php endif;
	if ((($params->get('item_title') && $params->get('link_titles')) || $params->get('readmore')) && $item->readmore) : ?>
	</a>
	<?php endif; ?>
</figure>
<?php elseif ($item_images->image_intro_caption) : ?>
<i class="<?php echo $item_images->image_intro_caption; ?>"></i>
<?php endif;
endif; ?>
<div class="item_content">
	<!-- Item title -->
	<?php if ($params->get('item_title')) : ?>
	<<?php echo $item_heading; ?> class="item_title item_title__<?php echo $params->get('moduleclass_sfx'); ?>">
		<?php if ($params->get('link_titles') && $item->link != '') : ?>
		<a href="<?php echo $item->link;?>"><?php echo $item->title;?></a>
		<?php else :
		echo wrap_with_span($item->title);
		endif; ?>
	</<?php echo $item_heading; ?>>
	<?php endif;

	if (!$params->get('intro_only')) :
		echo $item->afterDisplayTitle;
	endif;

	if ($params->get('show_tags', 1) && !empty($item->tags)) :
	$item->tagLayout = new JLayoutFile('joomla.content.tags');

	echo $item->tagLayout->render($item->tags->itemTags);
	endif;

	if ($params->get('published')) : ?>
	<time datetime="<?php echo JHtml::_('date', $item->publish_up, 'Y-m-d H:i'); ?>" class="item_published">
		<?php echo JHtml::_('date', $item->publish_up, JText::_('DATE_FORMAT_LC1')); ?>
	</time>
	<?php endif;

	if ($params->get('createdby')) : ?>
	<div class="item_createdby">
		<?php $author = $item->author;
		$author = ($item->created_by_alias ? $item->created_by_alias : $author);
		echo JText::sprintf('MOD_ARTICLES_NEWS_ADV_BY', $author); ?>
	</div>
	<?php endif;

	echo $item->beforeDisplayContent;

	if ($params->get('show_introtext')) : ?>
	<!-- Introtext -->
	<div class="item_introtext">
		<?php echo $item->introtext; ?>
	</div>
	<?php endif; ?>

	<?php if (isset($urls) && (!empty($urls->urla) || !empty($urls->urlb) || !empty($urls->urlc))) :
		$urlarray = array(
		array($urls->urla, $urls->urlatext, $urls->targeta, 'a'),
		array($urls->urlb, $urls->urlbtext, $urls->targetb, 'b'),
		array($urls->urlc, $urls->urlctext, $urls->targetc, 'c')
		); ?>
		<div class="content-links">
			<ul>
				<?php foreach ($urlarray as $url) :
				$link = $url[0];
				$label = $url[1];
				$target = $url[2];
				$id = $url[3];

				if ( ! $link) :
					continue;
				endif;

				// If no label is present, take the link
				$label = ($label) ? $label : $link;

				// If no target is present, use the default
				$target = $target ? $target : $params->get('target'.$id); ?>
				<li class="content-links-<?php echo $id; ?>">
				<?php
					// Compute the correct link

					switch ($target)
					{
						case 1:
							// open in a new window
							echo '<a href="'. htmlspecialchars($link) .'" target="_blank"  rel="nofollow">'.
								htmlspecialchars($label) .'</a>';
							break;

						case 2:
							// open in a popup window
							$attribs = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600,height=600';
							echo "<a href=\"" . htmlspecialchars($link) . "\" onclick=\"window.open(this.href, 'targetWindow', '".$attribs."'); return false;\">".
								htmlspecialchars($label).'</a>';
							break;
						case 3:
							// open in a modal window
							JHtml::_('behavior.modal', 'a.modal');
							echo '<a class="modal" href="'.htmlspecialchars($link).'"  rel="{handler: \'iframe\', size: {x:600, y:600}}">'.
								htmlspecialchars($label) . ' </a>';
							break;

						default:
							// open in parent window
							echo '<a href="'.  htmlspecialchars($link) . '" rel="nofollow">'.
								htmlspecialchars($label) . ' </a>';
							break;
					}
				?>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>

	<!-- Read More link -->
	<?php if (isset($item->link) && $item->readmore != 0 && $params->get('readmore')) :
		$readMoreText = JText::_('MOD_ARTICLES_NEWS_READMORE');
			if ($item->alternative_readmore){
				$readMoreText = $item->alternative_readmore;
			}
		echo '<a class="btn btn-info readmore" href="'.$item->link.'"><span>'. $readMoreText .'</span></a>';
	endif; ?>
</div>
<div class="clearfix"></div>