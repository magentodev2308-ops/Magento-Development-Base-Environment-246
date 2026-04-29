define([
    'jquery',
    'ko',
    'uiComponent',
    'jquery-ui-modules/datepicker'
], function ($, ko, Component) {
    'use strict';

    /**
     * Define custom binding once
     */
    if (!ko.bindingHandlers.zeodatepicker) {
        ko.bindingHandlers.zeodatepicker = {
            init: function (element) {

                var config = window.checkoutConfig.shipping &&
                             window.checkoutConfig.shipping.delivery_date
                             ? window.checkoutConfig.shipping.delivery_date
                             : {};

                var disabled = config.disabled || '';
                var noday = config.noday || false;
                var format = config.format || 'yy-mm-dd';

                var disabledDays = disabled
                    ? disabled.split(',').map(function (item) {
                        return parseInt(item, 10);
                    })
                    : [];

                var options = {
                    minDate: 0,
                    dateFormat: format
                };

                // Disable specific weekdays if configured
                if (!noday && disabledDays.length) {
                    options.beforeShowDay = function (date) {
                        var day = date.getDay();
                        return [disabledDays.indexOf(day) === -1];
                    };
                }

                $(element).datepicker(options);
            }
        };
    }

    return Component.extend({
        defaults: {
            template: 'Zeo_CheckoutAdditionalFields/delivery-date-block'
        },

        initialize: function () {
            this._super();
            return this;
        }
    });
});