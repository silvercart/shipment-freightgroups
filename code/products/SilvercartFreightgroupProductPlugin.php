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
 * @subpackage Products
 */

/**
 * Attribute to relate to a product.
 *
 * @package SilvercartFreightgroup
 * @subpackage Products
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2012 pixeltricks GmbH
 * @since 28.03.2012
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */
class SilvercartFreightgroupProductPlugin extends DataObjectDecorator {
    
    /**
     * Adds a tab for shipment information
     *
     * @param SilvercartProduct $callingObject Product to add tab for
     * 
     * @return DataObject 
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 19.04.2012
     */
    public function pluginGetPluggedInTabs($callingObject) {
        $pluggedInTab = null;
        if ($callingObject->SilvercartFreightgroupID) {
            $name       = _t('SilvercartFreightgroup.SHIPMENTINFO');
            $content    = '';
            if (trim($callingObject->SilvercartFreightgroup()->ProductHint) != '') {
                $content .= $callingObject->SilvercartFreightgroup()->ProductHint;
            }
            if ($callingObject->SilvercartFreightgroup()->ShowShipmentInfoOnProductDetail) {
                $content .= $callingObject->renderWith('SilvercartProductShipmentInformation');
            }
            if (!empty($content)) {
                $data = array(
                    'Name'      => $name,
                    'Content'   => $content,
                );
                $pluggedInTab = new DataObject($data);
            }
        }
        return $pluggedInTab;
    }
    
}
