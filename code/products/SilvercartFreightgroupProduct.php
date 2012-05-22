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
class SilvercartFreightgroupProduct extends DataObjectDecorator {
    
    /**
     * Extra statics
     *
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 28.03.2012 
     */
    public function extraStatics() {
        return array(
            'has_one' => array(
                'SilvercartFreightgroup'    => 'SilvercartFreightgroup',
            ),
        );
    }
    
    /**
     * Updates the CMS fields
     *
     * @param FieldSet &$fields Fields to update
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 16.03.2012
     */
    public function updateCMSFields(FieldSet &$fields) {
        $SilvercartFreightgroupsMap = array();
        $SilvercartFreightgroups    = DataObject::get('SilvercartFreightgroup', "", "`SilvercartFreightgroup`.`IsDefault` DESC");
        if ($SilvercartFreightgroups) {
            $SilvercartFreightgroupsMap = $SilvercartFreightgroups->map();
        }
        $freightgroupField = new DropdownField('SilvercartFreightgroupID', $this->owner->fieldLabel('SilvercartFreightgroup'), $SilvercartFreightgroupsMap);
        $fields->insertAfter($freightgroupField, 'SilvercartManufacturerID');
    }
    
    /**
     * Updates the field labels
     *
     * @param array &$labels Labels to update
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 28.03.2012
     */
    public function updateFieldLabels(&$labels) {
        $labels = array_merge(
                $labels,
                array(
                    'SilvercartFreightgroup'    => _t('SilvercartFreightgroup.SINGULARNAME'),
                )
        );
    }
    
    /**
     * Returns the allowed shipping methods dependant on freightgroup and default
     * permission criteria of SilvercartShippingMethod
     *
     * @return DataObjectSet
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 19.04.2012 
     */
    public function getAllowedShippingMethods() {
        $allowedShippingMethods = null;
        if ($this->owner->SilvercartFreightgroupID) {
            $freightgroup = $this->owner->SilvercartFreightgroup();
            $shippingMethods        = $freightgroup->SilvercartShippingMethods();
            $allowedShippingMethods = SilvercartShippingMethod::filterShippingMethods($shippingMethods);
        }
        return $allowedShippingMethods;
    }
    
}
