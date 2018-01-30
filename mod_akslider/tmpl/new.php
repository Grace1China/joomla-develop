<?php
/**
 * Torbara Maxx-Fitness Template for Joomla, exclusively on Envato Market: http://themeforest.net/user/torbara
 * @encoding     UTF-8
 * @version      1.0
 * @copyright    Copyright (C) 2015 Torbara (http://torbara.com). All rights reserved.
 * @license      GNU General Public License version 2 or later, see http://www.gnu.org/licenses/gpl-2.0.html
 * @author       Alexandr Khmelnytsky (support@torbara.com)
 */

defined('_JEXEC') or die;

JHtml::_('jquery.framework');
JFactory::getDocument()->addStyleSheet(JUri::base()."/modules/mod_akslider/css/style.css");

// UIkit Slideshow configuration
$slideshow_cfg = array ();
$slideshow_cfg[] = "height: '".$params->get('height')."'";
$slideshow_cfg[] = "animation: '".$params->get('animations')."'";
$slideshow_cfg[] = "duration: '".$params->get('duration')."'";
if($params->get('autoplay')=="1"){$slideshow_cfg[] = "autoplay: true";}else{$slideshow_cfg[] = "autoplay: false";}
$slideshow_cfg[] = "autoplayInterval: '".$params->get('autoplayInterval')."'";
if($params->get('videoautoplay')=="1"){$slideshow_cfg[] = "videoautoplay: true";}else{$slideshow_cfg[] = "videoautoplay: false";}
if($params->get('videomute')=="1"){$slideshow_cfg[] = "videomute: true";}else{$slideshow_cfg[] = "videomute: false";}
if($params->get('kenburns')=="1"){$slideshow_cfg[] = "kenburns: true";}else{$slideshow_cfg[] = "kenburns: false";} ?>

<div class="akslider-module <?php echo $moduleclass_sfx; ?>">
    <div class="uk-slidenav-position" data-uk-slideshow="{<?php echo implode(", ", $slideshow_cfg); ?>}">
        <ul class="uk-slideshow uk-overlay-active">
            <?php foreach ($list as $item) : ?>
                <li class="uk-height-viewport"><?php echo $item->introtext; ?></li>
            <?php endforeach; ?>
        </ul>
        <?php if($params->get('slidenav_btn')) : ?>
            <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slideshow-item="previous"></a>
            <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slideshow-item="next"></a>
        <?php endif; ?>
        <?php if($params->get('slidenav')) : ?>
            <ul class="uk-dotnav uk-dotnav-contrast uk-position-bottom uk-text-center">
                <?php $counter = 0; ?>
                <?php foreach ($list as $item) : ?>
                    <?php $image_intro = json_decode($item->images); ?>
                    <?php $image_intro = $image_intro->image_intro; ?>
                    <?php if($image_intro) : ?>
                        <li data-uk-slideshow-item="<?php echo $counter; ?>"><a href="" style="background-image: url(<?php echo $image_intro; ?>)"><?php echo $counter; $counter++; ?></a></li>
                    <?php else :?>
                        <li data-uk-slideshow-item="<?php echo $counter; ?>"><a href=""><?php echo $counter; $counter++; ?></a></li>
                    <?php endif;?>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>