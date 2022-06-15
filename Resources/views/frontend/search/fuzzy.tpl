{extends file="parent:frontend/search/fuzzy.tpl"}

{block name="frontend_search_info_messages"}
    {include file="frontend/nlx_facebook_tracking/events/search.tpl"}
    {$smarty.block.parent}
{/block}
