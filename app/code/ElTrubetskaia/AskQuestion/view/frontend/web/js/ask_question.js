define([
    'jquery',
    'Magento_Ui/js/modal/alert',
    'mage/cookies',
    'mage/translate',
    'jquery/ui',
    'askQuestionFormValidator'
], function ($, alert) {
    'use strict';

    $.widget('elTrubetskaia.askQuestion', {
        options: {
            cookieName: 'el_trubetskaia_ask_question_was_requested'
        },

        /** @inheritdoc */
        _create: function () {
            $(this.element).submit(this.submitForm.bind(this));
            this.checkBtnSubmit(this.options.cookieName);
        },

        /**
         * Validate request and submit the form if able
         */
        submitForm: function () {
            if (!this.validateForm()) {
                return;
            }

            this.ajaxSubmit();
        },

        /**
         * Submit request via AJAX. Add form key to the post data.
         */
        ajaxSubmit: function () {
            var formData = new FormData($(this.element).get(0));

            formData.append('form_key', $.mage.cookies.get('form_key'));
            formData.append('isAjax', 1);

            $.ajax({
                url: $(this.element).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                type: 'post',
                dataType: 'json',
                context: this,

                /** @inheritdoc */
                beforeSend: function () {
                    $('body').trigger('processStart');
                },

                /** @inheritdoc */
                success: function (response) {
                    $('body').trigger('processStop');
                    alert({
                        title: $.mage.__(response.status),
                        content: $.mage.__(response.message)
                    });

                    if (response.status === 'Success') {
                        // Prevent from sending requests too often
                        var self = this
                        $.mage.cookies.set(
                            self.options.cookieName,
                            true,
                            {
                                lifetime: 120
                            }
                        );
                        $('#btn-ask-question').attr('disabled', 'disabled');
                        this.checkBtnSubmit(self.options.cookieName);
                    }
                },

                /** @inheritdoc */
                error: function () {
                    $('body').trigger('processStop');
                    alert({
                        title: $.mage.__('Error'),
                        /*eslint max-len: ["error", { "ignoreStrings": true }]*/
                        content: $.mage.__('Your request can not be submitted right now. Please, contact us directly via email or phone to get your Sample.')
                    });
                }
            });
        },

        /**
         * Validate request form
         */
        validateForm: function () {
            return $(this.element).validation().valid();
        },

        /**
         * Check enable/disable btn submit
         */
        checkBtnSubmit: function (cookieName) {
            var checkCookie = setInterval(function () {
                if (!$.mage.cookies.get(cookieName)) {
                    $('#btn-ask-question').removeAttr('disabled');
                    clearInterval(checkCookie);
                } else {
                    $('#btn-ask-question').attr('disabled', 'disabled');
                }
            }, 1000);
        }
    });

    return $.elTrubetskaia.askQuestion;
});
