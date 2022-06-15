{extends file="parent:frontend/checkout/confirm.tpl"}

{block name="frontend_index_content"}
    {include file="frontend/nlx_facebook_tracking/events/initiate_checkout.tpl"}
    {$smarty.block.parent}
{/block}
