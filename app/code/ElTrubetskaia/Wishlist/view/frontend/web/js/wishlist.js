define([
    'jquery',
    'Magento_Wishlist/js/wishlist'
], function ($) {
    'use strict';

    $.widget('elTrubetskaia.wishlist', $.mage.wishlist, {
        /** @inheritdoc */
        _create: function () {
            this._super();

            console.log(JSON.parse(localStorage.getItem('mage-cache-storage')).wishlist);
            // JSON.parse(localStorage.getItem('mage-cache-storage')).wishlist.items[0]
        },
    });

    return $.elTrubetskaia.wishlist;
});
