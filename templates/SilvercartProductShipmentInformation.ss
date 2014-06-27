
<% if AllowedShippingMethods %>
    <% control AllowedShippingMethods %>
        <% if isActive %>
            <br/>
            <h3>$TitleWithCarrier</h3>
            <% if Description %>
                $Description
            <% end_if %>
            <% if DeliveryTime %><br/><small class="delivery-time-hint">$fieldLabel(DeliveryTime): {$getDeliveryTime(true)}</small><% end_if %>
            <table class="full silvercart-default-table">
                <colgroup>
                    <col width="20%"></col>
                    <col width="65%"></col>
                    <col width="15%"></col>
                </colgroup>
                <tr>
                    <th><% _t('SilvercartProduct.WEIGHT') %> ({$MaximumWeightUnitAbreviation})</th><th><% _t('SilvercartZone.SINGULARNAME') %></th><th><% _t('SilvercartProduct.PRICE') %></th>
                </tr>
                <% control SilvercartShippingFees %>
                <tr class="$EvenOdd">
                    <td class="align_right align_top padding_right"><% if UnlimitedWeight %><% _t('SilvercartShippingFee.UNLIMITED_WEIGHT') %><% else %>{$MaximumWeightNice}<% end_if %></td>
                    <td>
                        <% control SilvercartZone %>
                            <b>$Title:</b><br/>
                            <% control SilvercartCountries %>
                                <% if Active %>
                                    $Title<br/>
                                <% end_if %>
                            <% end_control %>
                        <% end_control %>
                        <% if DeliveryTime %><br/><small class="delivery-time-hint">$fieldLabel(DeliveryTime): {$getDeliveryTime(true)}</small><% end_if %>
                    </td>
                    <td class="align_right align_top">$PriceFormattedForDetailViewProduct <% if PostPricing %>*<% end_if %></td>
                </tr>
                <% end_control %>
            </table>
<% if hasFeeWithPostPricing %>* <% _t('SilvercartShippingFee.POST_PRICING_INFO') %><% end_if %>
        <% end_if %>
    <% end_control %>
<% end_if %>