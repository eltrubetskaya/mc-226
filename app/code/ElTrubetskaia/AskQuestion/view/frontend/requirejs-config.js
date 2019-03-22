var config = {
    map: {
        '*': {
            askQuestionFormValidator: 'ElTrubetskaia_AskQuestion/js/form-custom-validator',
            askQuestion: 'ElTrubetskaia_AskQuestion/js/ask_question'
        }
    },
    config: {
        mixins: {
            'Magento_Checkout/js/action/set-shipping-information': {
                'ElTrubetskaia_AskQuestion/js/action/set-shipping-information-mixin': true
            }
        }
    }
};
