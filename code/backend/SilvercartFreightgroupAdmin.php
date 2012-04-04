<?php
/**
 * Copyright 2012 pixeltricks GmbH
 *
 * This file is part of SilverCart.
 *
 * SilverCart is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * SilverCart is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with SilverCart.  If not, see <http://www.gnu.org/licenses/>.
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
 * @copyright 2012 pixeltricks GmbH
 * @since 28.03.2012
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */
class SilvercartFreightgroupAdmin extends ModelAdmin {

    /**
     * The code of the menu under which this admin should be shown.
     * 
     * @var string
     */
    public static $menuCode = 'config';

    /**
     * The section of the menu under which this admin should be grouped.
     * 
     * @var string
     */
    public static $menuSortIndex = 79;

    /**
     * The section of the menu under which this admin should be grouped.
     * 
     * @var string
     */
    public static $menuSection = 'shipping';

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
    public static $menu_title = 'Silvercart freightgroups';

    /**
     * Managed models
     *
     * @var array
     */
    public static $managed_models = array(
        'SilvercartFreightgroup',
    );

    /**
     * Definition of the Importers for the managed model.
     *
     * @var array
     */
    public static $model_importers = array(
        'SilvercartFreightgroup'    => 'CsvBulkLoader',
    );

    /**
     * Constructor
     *
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 14.03.2012
     */
    public function __construct() {
        self::$menu_title = _t('SilvercartFreightgroup.PLURALNAME');
        foreach (self::$managed_models as $class => $options) {
            if (is_numeric($class)) {
                unset(self::$managed_models[$class]);
                $class      = $options;
                $options    = array();
            }
            $options['title']               = _t($class . '.TABNAME', singleton($class)->i18n_singular_name());
            self::$managed_models[$class]   = $options;
        }
        parent::__construct();
    }
    
    /**
     * Provides hook for decorators, so that they can overwrite css
     * and other definitions.
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 14.03.2012
     */
    public function init() {
        parent::init();
        $this->extend('updateInit');
    }
}



