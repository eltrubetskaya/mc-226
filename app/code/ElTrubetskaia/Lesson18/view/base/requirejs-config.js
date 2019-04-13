var config = {
    'config': {
        'mixins': {
            'Magento_Checkout/js/view/shipping': {
                'ElTrubetskaia_Lesson18/js/view/shipping-payment-mixin': true
            },
            'Magento_Checkout/js/view/payment': {
                'ElTrubetskaia_Lesson18/js/view/shipping-payment-mixin': true
            }
        }
    }
}
