{block name="frontend_javascript_tracking_facebook_pixel_event_initiate_checkout"}
    {if $nlxFacebookTrackingActive && isset($nlxFacebookTrackingPixelId)}
        <script>
            fbq('track', 'InitiateCheckout', {literal}{
                currency: {/literal}'{$nlxFacebookTrackingCurrency}'{literal},
                contents: [
                    {/literal}
                        {foreach $sBasket.content as $product}
                            {include file="frontend/nlx_facebook_tracking/product.tpl"}
                            {if !$product@last}
                                ,
                            {/if}
                        {/foreach}
                    {literal}
                ]
            }{/literal});
        </script>
    {/if}
{/block}
