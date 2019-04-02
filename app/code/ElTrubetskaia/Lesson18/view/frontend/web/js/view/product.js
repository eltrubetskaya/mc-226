define([
    'jquery',
    'underscore',
    'uiComponent',
    'ko',
    'Magento_Checkout/js/model/step-navigator',
    'mage/translate',
    'ElTrubetskaia_Lesson18/js/model/product-service'
], function (
    $,
    _,
    Component,
    ko,
    stepNavigator,
    $t,
    productService
) {
    'use strict';

    return Component.extend({
        defaults: {
            products: [],
            listens: {
                responseData: 'updateProductsList',
                request: 'searchRequest'
            }
        },
        isVisible: ko.observable(false),

        /** @inheritdoc */
        initialize: function () {
            this._super();
            stepNavigator.registerStep(
                'product',
                null,
                $t('Product'),
                this.isVisible,
                _.bind(this.navigate, this),
                20
            );
            var self = this;
            this.initProductsList();

            return this;
        },

        initObservable: function () {
            return this._super()
                .observe([
                    'responseData',
                    'responseStatus',
                    'products',
                    'request'
                ]);
        },

        initProductsList: function (params) {
            productService.getProductsList(
                params,
                {
                    url: this.productsListUrl
                },
                {
                    data: this.responseData,
                    status: this.responseStatus
                }
            );
        },

        updateProductsList: function (data) {
            this.products(data.products);
        },

        searchRequest: function (request) {
            this.initProductsList({q:request});
        },

        /**
         * Navigate method.
         */
        navigate: function () {
            var self = this;
            self.isVisible(true);
        },

        nextAction: function () {
            stepNavigator.next();
        }
    });
});
