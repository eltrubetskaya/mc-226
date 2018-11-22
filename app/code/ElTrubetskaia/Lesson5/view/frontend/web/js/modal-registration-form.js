define([
    'jquery',
    'Magento_Ui/js/modal/modal'
], function ($, modal) {
    'use strict';

    var options = {
        type: 'popup',
        responsive: true,
        innerScroll: true,
        title: '',
        buttons: [{
            text: $.mage.__('Close'),
            class: '',
            click: function () {
                this.closeModal();
            }
        }]
    };

    var popup = modal(options, $('#registration-for-dealer-modal'));

    $('#registration-for-dealer').on('click', function () {
        $('#registration-for-dealer-modal').modal('openModal').trigger('contentUpdated');
    });
});
