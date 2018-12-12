define([
    'jquery',
    'jquery/validate'
], function ($) {
    'use strict';

    $.each({
        'custom-validate-phone-number': [
            function (value) {
                return value.match(/^[+]{1}[380]+([1-9]){1}([0-9]){8}$/) && value.length <= 13;
            },
            $.mage.__('Please specify a valid ukrainian phone number with country code')
        ]
    }, function (i, rule) {
        rule.unshift(i);
        $.validator.addMethod.apply($.validator, rule);
    });

    $.validator.addClassRules({
        'custom-validate-phone-number': {
            required: true
        }
    });
});
