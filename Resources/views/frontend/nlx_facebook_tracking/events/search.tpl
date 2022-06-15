{block name="frontend_javascript_tracking_facebook_pixel_event_search"}
    {if $nlxFacebookTrackingActive && isset($nlxFacebookTrackingPixelId)}
        <script>
            fbq('track', 'Search', {literal}{
                search_string: {/literal}'{$sRequests.sSearchOrginal}'{literal}
            }{/literal});
        </script>
    {/if}
{/block}
