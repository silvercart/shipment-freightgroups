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
class SilvercartFreightgroup extends DataObject {
    
    /**
     * DB fields
     *
     * @var array
     */
    public static $db = array(
        'Title'         => 'Varchar(64)',
        'Description'   => 'Text',
        'Priority'      => 'Int',
        'IsDefault'     => 'Boolean',
    );
    
    /**
     * Many to one relations
     *
     * @var array
     */
    public static $has_many = array(
        'SilvercartProducts'    => 'SilvercartProduct',
    );
    
    /**
     * Many to many relations
     *
     * @var array
     */
    public static $many_many = array(
        'SilvercartShippingMethods' => 'SilvercartShippingMethod',
    );
    
    /**
     * Casting fields
     *
     * @var array
     */
    public static $casting = array(
        'IsDefaultString'   => 'Text',
    );


    /**
     * Default sort field and direction
     *
     * @var string
     */
    public static $default_sort = "`SilvercartFreightgroup`.`Priority` ASC";

    /**
     * Field labels for display in tables.
     *
     * @param boolean $includerelations A boolean value to indicate if the labels returned include relation fields
     *
     * @return array
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 28.03.2012
     */
    public function fieldLabels($includerelations = true) {
        $fieldLabels = array_merge(
            parent::fieldLabels($includerelations),
            array(
                'Title'                     => _t($this->ClassName . '.TITLE'),
                'Description'               => _t($this->ClassName . '.DESCRIPTION'),
                'Priority'                  => _t($this->ClassName . '.PRIORITY'),
                'IsDefault'                 => _t($this->ClassName . '.ISDEFAULT'),
                'SilvercartProducts'        => _t('SilvercartProduct.PLURALNAME'),
                'SilvercartShippingMethods' => _t('SilvercartShippingMethod.PLURALNAME'),
            )
        );

        $this->extend('updateFieldLabels', $fieldLabels);
        return $fieldLabels;
    }

    /**
     * Searchable fields
     *
     * @return array
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 29.03.2012
     */
    public function searchableFields() {
        $searchableFields = array(
            'Title' => array(
                'title'     => $this->fieldLabel('Title'),
                'filter'    => 'PartialMatchFilter'
            ),
            'Description' => array(
                'title'     => $this->fieldLabel('Description'),
                'filter'    => 'PartialMatchFilter'
            ),
            'Priority' => array(
                'title'     => $this->fieldLabel('Priority'),
                'filter'    => 'PartialMatchFilter'
            ),
            'IsDefault' => array(
                'title'     => $this->fieldLabel('IsDefault'),
                'filter'    => 'ExactMatchFilter'
            ),
        );
        $this->extend('updateSearchableFields', $searchableFields);
        return $searchableFields;
    }

    /**
     * Summaryfields for display in tables.
     *
     * @return array
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 28.03.2012
     */
    public function summaryFields() {
        $summaryFields = array(
            'Title'             => $this->fieldLabel('Title'),
            'Description'       => $this->fieldLabel('Description'),
            'Priority'          => $this->fieldLabel('Priority'),
            'IsDefaultString'   => $this->fieldLabel('IsDefault'),
        );

        $this->extend('updateSummaryFields', $summaryFields);
        return $summaryFields;
    }
    
    /**
     * Sets the priority of other freightgroups dependent on the own one
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 28.03.2012
     */
    protected function onAfterWrite() {
        parent::onAfterWrite();
        if ($this->ID > 0) {
            if ($this->isChanged('Priority') &&
                array_key_exists('Priority', $this->original)) {
                if ($this->original['Priority'] < $this->Priority) {
                    $incrementOrDecrement   = '-';
                    $operator               = '<=';
                    $operator2              = '>';
                } elseif ($this->original['Priority'] > $this->Priority) {
                    $incrementOrDecrement   = '+';
                    $operator               = '>=';
                    $operator2              = '<';
                }
                $query = sprintf(
                        "UPDATE
                            `SilvercartFreightgroup`
                        SET
                            `SilvercartFreightgroup`.`Priority` = `SilvercartFreightgroup`.`Priority` %s 1
                        WHERE
                            `SilvercartFreightgroup`.`Priority` %s %s
                        AND
                            `SilvercartFreightgroup`.`Priority` %s %s
                        AND
                            `SilvercartFreightgroup`.`ID` != %s",
                        $incrementOrDecrement,
                        $operator,
                        $this->Priority,
                        $operator2,
                        $this->original['Priority'],
                        $this->ID
                );
                DB::query($query);
            }
            if ($this->isChanged('IsDefault') &&
                $this->IsDefault) {
                $query = sprintf(
                        "UPDATE
                            `SilvercartFreightgroup`
                        SET
                            `SilvercartFreightgroup`.`IsDefault` = 0
                        WHERE
                            `SilvercartFreightgroup`.`ID` != %s",
                        $this->ID
                );
                DB::query($query);
            }
        }
    }
    
    /**
     * Sets the priority to lowest if not set
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 28.03.2012 
     */
    protected function onBeforeWrite() {
        parent::onBeforeWrite();
        if ($this->ID > 0) {
            if (!$this->Priority > 0) {
                $lowest = DataObject::get_one(
                        $this->ClassName,
                        "`SilvercartFreightgroup`.`Priority` > 0",
                        true,
                        "`SilvercartFreightgroup`.`Priority` DESC"
                );
                if ($lowest) {
                    $this->Priority = $lowest->Priority + 1;
                } else {
                    $this->Priority = 1;
                }
            }
        }
    }
    
    /**
     * Casting to get the IsDefault state as a readable string
     *
     * @return string
     */
    public function getIsDefaultString() {
        $IsDefaultString = _t('Boolean.NO');
        if ($this->IsDefault) {
            $IsDefaultString = _t('Boolean.YES');
        }
        return $IsDefaultString;
    }
}