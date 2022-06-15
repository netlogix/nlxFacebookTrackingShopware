{block name="frontend_javascript_tracking_facebook_pixel_event_purchase"}
    {if $nlxFacebookTrackingActive && isset($nlxFacebookTrackingPixelId)}
        <script>
            fbq('track', 'Purchase', {literal}{
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
