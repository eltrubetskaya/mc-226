define([
    'underscore',
    'Magento_Ui/js/grid/columns/select'
], function (_, Select) {
    'use strict';

    return Select.extend({
        defaults: {
            additionalCustomClass: '',
            customClasses: {
                processed: 'green',
                pending: 'red'
            },
            bodyTmpl: 'ElTrubetskaia_AskQuestion/grid/cells/text'
        },

        getCustomClass: function (row) {
            var customClass = this.customClasses[row.status] || '';

            return customClass + ' ' + this.additionalCustomClass;
        }
    });
});
