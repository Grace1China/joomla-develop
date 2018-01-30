<?php
/**
 * Random articles module
 */

defined('_JEXEC') or die;

require_once JPATH_SITE . '/components/com_content/helpers/route.php';

abstract class ModArticlesRandomHelper
{

    public static function getArticles($params)
    {
        $categories = $params->get('catid');

        $count = $params->get('count', 5);

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('*');
        $query->from('#__content');

        if(is_array($categories) && count($categories)) {
            for($i=0; $i<count($categories); $i++)
            {
                if(empty($categories[$i])) {
                    unset($categories[$i]);
                }
            }

            if(count($categories)) {
                $query->where('catid IN (' . implode(',', $categories) . ')');
            }
        }

        $query->where('state = 1');

        $query->order('RAND()');

        $db->setQuery($query, $count);

        $articles = $db->loadObjectList();

        foreach($articles as $article)
        {
            $article->slug = $article->id . ':' . $article->alias;

            $article->link = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid, $article->language));
        }

        return $articles;
    }

    public function getAjax()
    {
        $app = JFactory::getApplication();

        $catids = $app->input->get('catids', '');
        $count = $app->input->get('count', 5);

        $params = new JRegistry();
        $params->set('catid', explode(',', $catids));
        $params->set('count', $count);

        $articles = ModArticlesRandomHelper::getArticles($params);

        return $articles;
    }

}