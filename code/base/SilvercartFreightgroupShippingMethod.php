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
 * @subpackage Base
 */

/**
 * Attribute to relate to a product.
 *
 * @package SilvercartFreightgroup
 * @subpackage Base
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2012 pixeltricks GmbH
 * @since 28.03.2012
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */
class SilvercartFreightgroupShippingMethod extends DataExtension {
    
    /**
     * belongs_many_many relations
     *
     * @var array
     */
    private static $belongs_many_many = array(
        'SilvercartFreightgroups' => 'SilvercartFreightgroup',
    );
    
    /**
     * Updates the CMS fields
     *
     * @param FieldList $fields Fields to update
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 29.03.2012
     */
    public function updateCMSFields(FieldList $fields) {
        if ($this->owner->ID) {
            $freightgroupsTable = new GridField(
                    'SilvercartFreightgroups',
                    $this->owner->fieldLabel('SilvercartFreightgroups'),
                    $this->owner->SilvercartFreightgroups(),
                    SilvercartGridFieldConfig_RelationEditor::create()
            );
            $fields->findOrMakeTab('Root.SilvercartFreightgroups', $this->owner->fieldLabel('SilvercartFreightgroups'));
            $fields->addFieldToTab('Root.SilvercartFreightgroups', $freightgroupsTable);
        }
    }
    
    /**
     * Updates the field labels
     *
     * @param type &$labels Labels to update
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
                    'SilvercartFreightgroups'   => _t('SilvercartFreightgroup.PLURALNAME'),
                )
        );
    }
    
    /**
     * Updates the summary fields
     *
     * @param type &$fields Fields to update
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 28.03.2012
     */
    public function updateSummaryFields(&$fields) {
        $fields = array_merge(
                $fields,
                array(
                    'SilvercartFreightgroupsAsString'   => $this->owner->fieldLabel('SilvercartFreightgroups'),
                )
        );
    }
    
    /**
     * Updates the searchable fields
     *
     * @param type &$fields Fields to update
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 28.03.2012
     */
    public function updateSearchableFields(&$fields) {
        if (array_key_exists('SilvercartFreightgroupsAsString', $fields)) {
            unset($fields['SilvercartFreightgroupsAsString']);
        }
        return;
        $fields['SilvercartFreightgroups'] = array(
            'title'     => $this->owner->fieldLabel('SilvercartFreightgroups'),
            'filter'    => 'ExactMatchFilter',
        );
    }
    
    /**
     * Updates the allowed shipping methods
     *
     * @param SS_List $allowedShippingMethods Allowed shipping methods to update
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 28.03.2012
     */
    public function updateAllowedShippingMethods(SS_List $allowedShippingMethods) {
        if (Member::currentUser()) {
            $shippingMethodsToRemove    = array();
            $freightgroupToUse          = false;
            $cart                       = Member::currentUser()->SilvercartShoppingCart();
            $positions                  = $cart->SilvercartShoppingCartPositions();
            $freightgroups              = SilvercartFreightgroup::get()->sort('Priority', 'ASC');
            if ($positions->Count() > 0 &&
                $freightgroups) {
                foreach ($freightgroups as $freightgroup) {
                    foreach ($positions as $position) {
                        if ($position->SilvercartProduct()->SilvercartFreightgroupID == $freightgroup->ID) {
                            $freightgroupToUse = $freightgroup;
                            break;
                        }
                    }
                }
                
                if ($freightgroupToUse) {
                    foreach ($allowedShippingMethods as $allowedShippingMethod) {
                        if (!$allowedShippingMethod->SilvercartFreightgroups()->find('ID', $freightgroupToUse->ID)) {
                            $shippingMethodsToRemove[] = $allowedShippingMethod;
                        }
                    }
                    if (count($shippingMethodsToRemove) < $allowedShippingMethods->Count()) {
                        foreach ($shippingMethodsToRemove as $shippingMethod) {
                            $allowedShippingMethods->remove($shippingMethod);
                        }
                    }
                }
            }
        }
    }
    
    /**
     * Updates the allowed shipping fees for the given product
     *
     * @param SS_List           $allowedShippingMethods Allowed shipping methods to update
     * @param SilvercartProduct $product                 Product to check fees for
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 08.02.2013
     */
    public function updateAllowedShippingFeesFor(SS_List $allowedShippingMethods, $product) {
        $freightgroup               = $product->SilvercartFreightgroup();
        $shippingMethodsToRemove    = array();
        if ($freightgroup) {
            foreach ($allowedShippingMethods as $allowedShippingMethod) {
                if (!$allowedShippingMethod->SilvercartFreightgroups()->find('ID', $freightgroup->ID)) {
                    $shippingMethodsToRemove[] = $allowedShippingMethod;
                }
            }
            if (count($shippingMethodsToRemove) < $allowedShippingMethods->Count()) {
                foreach ($shippingMethodsToRemove as $shippingMethod) {
                    $allowedShippingMethods->remove($shippingMethod);
                }
            }
        }
    }

    /**
     * Returns the freightgroups as a comma separated string
     *
     * @return string
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 16.02.2017
     */
    public function getSilvercartFreightgroupsAsString() {
        $silvercartFreightgroupsAsString    = '---';
        $silvercartFreightgroupsAsArray     = $this->owner->SilvercartFreightgroups()->map();
        if ($silvercartFreightgroupsAsArray instanceof SS_Map) {
            $silvercartFreightgroupsAsArray = $silvercartFreightgroupsAsArray->toArray();
        }
        if (count($silvercartFreightgroupsAsArray) > 0) {
            $silvercartFreightgroupsAsString = implode(',', $silvercartFreightgroupsAsArray);
        }
        return $silvercartFreightgroupsAsString;
    }
    
}