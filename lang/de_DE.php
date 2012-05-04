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
 * German (Germany) language pack
 *
 * @package SilvercartFreightgroup
 * @subpackage i18n
 * @ignore
 */

global $lang;

i18n::include_locale_file('silvercart_shipment_freightgroups', 'en_US');

if (array_key_exists('de_DE', $lang) && is_array($lang['de_DE'])) {
    $lang['de_DE'] = array_merge($lang['en_US'], $lang['de_DE']);
} else {
    $lang['de_DE'] = $lang['en_US'];
}

$lang['de_DE']['SilvercartFreightgroup']['PLURALNAME']                          = 'Frachtgruppen';
$lang['de_DE']['SilvercartFreightgroup']['SINGULARNAME']                        = 'Frachtgruppe';

$lang['de_DE']['SilvercartFreightgroup']['DESCRIPTION']                         = 'Beschreibung';
$lang['de_DE']['SilvercartFreightgroup']['ISDEFAULT']                           = 'Ist Standard';
$lang['de_DE']['SilvercartFreightgroup']['PRIORITY']                            = 'Priorität';
$lang['de_DE']['SilvercartFreightgroup']['PRODUCTHINT']                         = 'Hinweis zur Anzeige an den Details eines verknüpften Artikels';
$lang['de_DE']['SilvercartFreightgroup']['PRODUCTHINTSHORT']                    = 'Artikel-Hinweis';
$lang['de_DE']['SilvercartFreightgroup']['SHIPMENTINFO']                        = 'Versandinformationen';
$lang['de_DE']['SilvercartFreightgroup']['SHOWSHIPMENTINFOONPRODUCTDETAIL']     = 'Versandinformationen an den Details eines verknüpften Artikels anzeigen?';
$lang['de_DE']['SilvercartFreightgroup']['TITLE']                               = 'Name';

$lang['de_DE']['SilvercartFreightgroupLanguage']['PLURALNAME']                  = _t('Silvercart.TRANSLATIONS');
$lang['de_DE']['SilvercartFreightgroupLanguage']['SINGULARNAME']                = _t('Silvercart.TRANSLATION');