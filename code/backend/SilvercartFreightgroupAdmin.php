<?php
/**
 * Copyright 2017 pixeltricks GmbH
 *
 * This file is part of SilverCart.
 *
 * @package SilvercartFreightgroup
 * @subpackage ModelAdmins
 */

/**
 * ModelAdmin for SilvercartProductAttributes.
 * 
 * @package SilvercartFreightgroup
 * @subpackage ModelAdmins
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2017 pixeltricks GmbH
 * @since 16.02.2017
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */
class SilvercartFreightgroupAdmin extends SilvercartModelAdmin {

    /**
     * The code of the menu under which this admin should be shown.
     * 
     * @var string
     */
    public static $menuCode = 'handling';

    /**
     * The section of the menu under which this admin should be grouped.
     * 
     * @var string
     */
    public static $menuSortIndex = 21;

    /**
     * The URL segment
     *
     * @var string
     */
    public static $url_segment = 'silvercart-freightgroups';

    /**
     * The menu title
     *
     * @var string
     */
    public static $menu_title = 'Freightgroups';

    /**
     * Managed models
     *
     * @var array
     */
    public static $managed_models = array(
        'SilvercartFreightgroup',
    );
    
}



