{extends file="parent:frontend/checkout/finish.tpl"}

{block name="frontend_index_content"}
    {include file="frontend/nlx_facebook_tracking/events/purchase.tpl"}
    {$smarty.block.parent}
{/block}
