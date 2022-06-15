{extends file="parent:frontend/index/header.tpl"}

{block name="frontend_index_header_javascript_tracking"}
    {$smarty.block.parent}

    {if $nlxFacebookTrackingActive && isset($nlxFacebookTrackingPixelId)}
        {block name="frontend_index_header_javascript_tracking_facebook_pixel"}{/block}

        <script>
            window.nlxFacebookTracking = {literal}{
                pixelId: {/literal}'{$nlxFacebookTrackingPixelId}'{literal},
                currency: {/literal}'{$nlxFacebookTrackingCurrency}'{literal}
            {/literal}};
        </script>

        <!-- Facebook Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s) {literal} {
                if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)
            } {/literal} (window, document,'script','https://connect.facebook.net/de_DE/fbevents.js');
            fbq('init', '{$nlxFacebookTrackingPixelId}');
            fbq('track', 'PageView');
        </script>

        <noscript>
            <img height="1" width="1" style="display:none"
                 src="https://www.facebook.com/tr?id={$nlxFacebookTrackingPixelId}&ev=PageView&noscript=1"/>
        </noscript>
        <!-- End Facebook Pixel Code -->
    {/if}
{/block}
