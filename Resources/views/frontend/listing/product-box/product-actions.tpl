{extends file="parent:frontend/listing/product-box/product-actions.tpl"}

{block name='frontend_listing_box_article_actions_save'}
    <form action="{url controller='note' action='add' ordernumber=$sArticle.ordernumber _seo=false}" method="post">
        {s name="DetailLinkNotepad" namespace="frontend/detail/actions" assign="snippetDetailLinkNotepad"}{/s}
        <button type="submit"
                title="{$snippetDetailLinkNotepad|escape}"
                aria-label="{$snippetDetailLinkNotepad|escape}"
                class="product--action action--note"
                data-ajaxUrl="{url controller='note' action='ajaxAdd' ordernumber=$sArticle.ordernumber _seo=false}"
                data-text="{s name="DetailNotepadMarked"}{/s}"
                data-ordernumber="{$sArticle.ordernumber}"
                data-articleName="{$sArticle.articleName}"
                data-price="{$sArticle.priceNumeric}"
        >
            <i class="icon--heart"></i> <span class="action--text">{s name="DetailLinkNotepadShort" namespace="frontend/detail/actions"}{/s}</span>
        </button>
    </form>
{/block}
