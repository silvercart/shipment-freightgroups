
<% if $AllowedShippingMethods %>
    <% loop $AllowedShippingMethods %>
        <% if $isActive %>
            <br/>
            <h3>{$TitleWithCarrier}</h3>
            <% if $Description %>
                {$Description}
            <% end_if %>
            <% if $DeliveryTime %><br/><small class="delivery-time-hint">{$fieldLabel(DeliveryTime)}: {$getDeliveryTime(true)}</small><% end_if %>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th><% _t('SilvercartProduct.WEIGHT') %> ({$MaximumWeightUnitAbreviation})</th>
                        <th><% _t('SilvercartZone.SINGULARNAME') %></th>
                        <th><% _t('SilvercartProduct.PRICE') %></th>
                    </tr>
                </thead>
                <tbody>
                <% loop $SilvercartShippingFees %>
                <tr class="{$EvenOdd}">
                    <td class="right"><% if $UnlimitedWeight %><% _t('SilvercartShippingFee.UNLIMITED_WEIGHT') %><% else %>{$MaximumWeightNice}<% end_if %></td>
                    <td>
                        <% with $SilvercartZone %>
                            <b>{$Title}:</b><br/>
                            <% loop $SilvercartCountries %>
                                <% if $Active %>{$Title}<br/><% end_if %>
                            <% end_loop %>
                        <% end_with %>
                        <% if $DeliveryTime %><br/><small class="delivery-time-hint">{$fieldLabel(DeliveryTime)}: {$getDeliveryTime(true)}</small><% end_if %>
                    </td>
                    <td class="right">{$PriceFormattedForDetailViewProduct} <% if $PostPricing %>*<% end_if %></td>
                </tr>
                <% end_loop %>
                </tbody>
            </table>
<% if $hasFeeWithPostPricing %>* <% _t('SilvercartShippingFee.POST_PRICING_INFO') %><% end_if %>
        <% end_if %>
    <% end_loop %>
<% end_if %>