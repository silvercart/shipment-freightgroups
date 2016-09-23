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
class SilvercartFreightgroupProduct extends DataExtension {
    
    /**
     * has_one relations
     *
     * @var array
     */
    private static $has_one = array(
        'SilvercartFreightgroup' => 'SilvercartFreightgroup',
    );
    
    /**
     * Updates the CMS fields
     *
     * @param FieldList $fields Fields to update
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 16.03.2012
     */
    public function updateCMSFields(FieldList $fields) {
        $SilvercartFreightgroupsMap = array();
        $SilvercartFreightgroups    = SilvercartFreightgroup::get()->sort('IsDefault', 'DESC');
        if ($SilvercartFreightgroups->exists()) {
            $SilvercartFreightgroupsMap = $SilvercartFreightgroups->map();
        }
        $freightgroupField = new DropdownField('SilvercartFreightgroupID', $this->owner->fieldLabel('SilvercartFreightgroup'), $SilvercartFreightgroupsMap);
        $fields->insertAfter($freightgroupField, 'SilvercartManufacturerID');
    }

    /**
     * Updates the searchable fields
     *
     * @param FieldList $fields Fields to update
     *
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 07.07.2016
     */
    public function updateSearchableFields(FieldList $fields) {
        $fields['SilvercartFreightgroup.ID'] = array(
            'title'     => _t('SilvercartFreightgroup.SINGULARNAME'),
            'filter'    => 'ExactMatchFilter'
        );
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
     * @return ArrayList
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
    
    /**
     * Returns the allowed shipping fees dependant on freightgroup, country and
     * customer group
     * 
     * @param SilvercartCountry $country       Country to get fee for
     * @param Group             $customerGroup Customer group to get fee for
     *
     * @return ArrayList
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 09.11.2012 
     */
    public function getAllowedShippingFeesFor(SilvercartCountry $country, Group $customerGroup) {
        $allowedShippingFees = new ArrayList();
        if ($this->owner->SilvercartFreightgroupID) {
            $freightgroup   = $this->owner->SilvercartFreightgroup();
            $shippingFees   = SilvercartShippingMethod::getAllowedShippingFeesFor($this->owner, $country, $customerGroup);
            foreach ($shippingFees as $shippingFee) {
                if ($freightgroup->SilvercartShippingMethods()->find('ID', $shippingFee->SilvercartShippingMethodID)) {
                    $allowedShippingFees->push($shippingFee);
                }
            }
        }
        return $allowedShippingFees;
    }
    
    /**
     * Returns the lowest shipping fee dependant on freightgroup, country and
     * customer group
     * 
     * @param SilvercartCountry $country       Country to get fee for
     * @param Group             $customerGroup Customer group to get fee for
     *
     * @return SilvercartShippingFee
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 09.11.2012 
     */
    public function getLowestShippingFeeFor(SilvercartCountry $country, Group $customerGroup) {
        $allowedShippingFees    = $this->getAllowedShippingFeesFor($country, $customerGroup);
        $lowestShippingFee      = null;
        if ($allowedShippingFees->Count() > 0) {
            foreach ($allowedShippingFees as $shippingFee) {
                if (!$shippingFee->PostPricing) {
                    if (is_null($lowestShippingFee) ||
                        $lowestShippingFee->PriceAmount > $shippingFee->PriceAmount) {
                        $lowestShippingFee = $shippingFee;
                    }
                }
            }
        }
        return $lowestShippingFee;
    }
    
}
