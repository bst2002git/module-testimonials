define(["jquery"], function($) {
    'use strict';

    return function (config, element) {
        var currentPage = 1,
            viewMore = $('#viewMore');

        function makeAjaxCall() {
            if (viewMore.hasClass('disabled')) return;

            viewMore.addClass('disabled');
            ++currentPage;
            $.post(config.loadAction, { page: currentPage },
                function(data) {
                    $(element).append(data.outputHtml);
					$(element).trigger('contentUpdated');
                    viewMore.removeClass('disabled');
                    if (data.lastPage) viewMore.hide();
                },
                'json'
            );

            return false;
        }

        if (viewMore) {
            viewMore.on('click', makeAjaxCall);
        }
    };
});
