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
 * @subpackage Order
 */

/**
 * Attribute to relate to a product.
 *
 * @package SilvercartFreightgroup
 * @subpackage Order
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2012 pixeltricks GmbH
 * @since 19.04.2012
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */
class SilvercartFreightgroupShoppingCartPositionPlugin extends DataExtension {

    /**
     * This method will add a string to SilvercartShoppingCartPosition's method 
     * "getTitle()".
     *
     * @param SilvercartShoppingCartPosition $callingObject The calling object
     * 
     * @return string
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 12.07.2017
     */
    public function pluginAddToTitle($callingObject) {
        $addToTitle     = '';
        $productHint    = trim($callingObject->SilvercartProduct()->SilvercartFreightgroup()->ProductHint);
        if (!empty($productHint)) {
            $addToTitle = sprintf(
                    '<div class="alert alert-info margin-top">%s</div>',
                    $productHint
            );
        }
        return $addToTitle;
    }
    
}
