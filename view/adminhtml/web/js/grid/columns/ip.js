/**
 * @author:  MonishTrivedi
 * @package: TrainingMonish_LoginIP
 */


define([
    'Magento_Ui/js/grid/columns/column'
], function (Column) {
    'use strict';

    return Column.extend({
        defaults: {
            bodyTmpl: 'ui/grid/cells/html'
        },
        getLabel: function (record) {
            var label = this._super(record);

            if (label !== '') {
                label = '<a href="http://www.traceip.net/?query=' + label + '" target="_blank">' + label + '</a>';
            }

            return label;
        }
    });
});