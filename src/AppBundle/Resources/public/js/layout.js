if (!dokify) {
    var dokify = {};
}

dokify.Layout = function () {


    /*************************************************************************/

    var init = function () {

    };

    var loading = function (action, section) {
        switch (action) {
            case 'run':
                var loading = '<div class="js-loading overlay"><i class="fa fa-refresh fa-spin"></i></div>';

                if ($(section) && $(section).hasClass('box')) {
                    $(section).append(loading);
                } else {
                    if (!section) {
                        section = '.js-page';
                    }

                    $(section).find('.box').each(function () {
                        $(this).append(loading);
                    });
                }
                break;
            case 'stop':
            default:
                if (!section) {
                    section = '.js-page';
                }

                $(section).find('.js-loading').each(function () {
                    $(this).remove();
                });
                break;
        }
    };

    var notification = function (type, message) {
        message = message || 'Oops! An error occurred. Please try again later.';
        var bubbleClass = 'alert-danger';

        switch (type) {
            case 'info':
                bubbleClass = 'alert-warning';
                break;
            case 'success':
                bubbleClass = 'alert-success';
                break;
            case 'error':
                bubbleClass = 'alert-danger';
                break;
        }

        var bubble = '<div class="alert ' + bubbleClass + ' alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-check"></i> ' + message + '</div>';

        $('.js-notification').html(bubble);
    };

    /*************************************************************************/

    return {
        init: init,
        loading: loading,
        notification: notification
    }
};