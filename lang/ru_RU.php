<?php
/**
 * Copyright 2012 pixeltricks GmbH
 *
 * This file is part of SilvercartPrepaymentPayment.
 *
 * SilvercartPaypalPayment is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * SilvercartPrepaymentPayment is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with SilvercartPrepaymentPayment.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Russian language pack
 *
 * @package SilvercartShipmentFreightgroups
 * @subpackage i18n
 * @ignore
 */

global $lang;

i18n::include_locale_file('silvercart_shipment_freightgroups', 'en_US');

if (array_key_exists('ru_RU', $lang) && is_array($lang['ru_RU'])) {
    $lang['ru_RU'] = array_merge($lang['en_US'], $lang['ru_RU']);
} else {
    $lang['ru_RU'] = $lang['en_US'];
}

$lang['ru_RU']['SilvercartFreightgroup']['PLURALNAME'] = 'Группы груза';
$lang['ru_RU']['SilvercartFreightgroup']['SINGULARNAME'] = 'Группа груза';
$lang['ru_RU']['SilvercartFreightgroup']['DESCRIPTION'] = 'Описание';
$lang['ru_RU']['SilvercartFreightgroup']['ISDEFAULT'] = 'стандарт';
$lang['ru_RU']['SilvercartFreightgroup']['PRIORITY'] = 'Приоритет';
$lang['ru_RU']['SilvercartFreightgroup']['PRODUCTHINT'] = 'Показать детальную информацию по артикулу';
$lang['ru_RU']['SilvercartFreightgroup']['PRODUCTHINTSHORT'] = 'замечание по артикулу';
$lang['ru_RU']['SilvercartFreightgroup']['SHIPMENTINFO'] = 'Информация по доставке';
$lang['ru_RU']['SilvercartFreightgroup']['SHOWSHIPMENTINFOONPRODUCTDETAIL'] = 'Показать информацию по доставке товара?';
$lang['ru_RU']['SilvercartFreightgroup']['TITLE'] = 'Имя';
$lang['ru_RU']['SilvercartFreightgroupLanguage']['PLURALNAME'] = '';
$lang['ru_RU']['SilvercartFreightgroupLanguage']['SINGULARNAME'] = '';
