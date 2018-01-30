<?php
/**
 * @version     $Id$
 * @package     Nooku_Modules
 * @subpackage  Default
 * @copyright   Copyright (C) 2007 - 2012 Johan Janssens. All rights reserved.
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.nooku.org
 */

/**
 * Default Module View
 *
 * @author      Johan Janssens <johan@nooku.org>
 * @package     Nooku_Modules
 * @subpackage  Default
 */
class ModDefaultTemplateDefault extends ComDefaultTemplateAbstract
{
    /**
     * Override the Nooku caching mechanism to avoid having all the Ohanah views 
     * showing the same content
     */
    protected function _parse(&$content)
    {
        KTemplateAbstract::_parse($content);
    }
}