(function ($, window) {
    $.plugin('nlxFacebookTracking', {
        init: function () {
            $.subscribe('plugin/swAjaxWishlist/onTriggerRequestFinished', this.onArticleAddedToWishlist);
            $.subscribe('plugin/swAddArticle/onAddArticle', this.onArticleAddedToCart);
        },

        onArticleAddedToWishlist: function (event, plugin, addToWishlistBtn) {
            fbq('track', 'AddToWishlist', {
                currency: window.nlxFacebookTracking.currency,
                contents: [{
                    id: addToWishlistBtn.attr('data-ordernumber'),
                    name: addToWishlistBtn.attr('data-articleName'),
                    price: parseFloat(addToWishlistBtn.attr('data-price'))
                }]
            });
        },

        onArticleAddedToCart: function (event, plugin) {
            var buyForm = plugin.$el;
            fbq('track', 'AddToCart', {
                currency: window.nlxFacebookTracking.currency,
                contents: [{
                    id: buyForm.attr('data-ordernumber'),
                    name: buyForm.attr('data-articleName'),
                    price: parseFloat(buyForm.attr('data-price')),
                    quantity: parseInt($('#sQuantity').val())
                }]
            });
        }
    });

    $(function () {
        if (window.nlxFacebookTracking) {
            window.StateManager.addPlugin('body', 'nlxFacebookTracking');
        }
    });
}) (jQuery, window);
