if (!dokify) {
    var dokify = {};
}

dokify.AgreementForm = function (_objLayout) {

    var _buttonDelete = '.js-btn-relation-delete';
    var _popupDelete = '#js-popup-delete';

    /*************************************************************************/

    var init = function () {
        widgetForm();
    };

    /*************************************************************************/
    /* PRIVATE METHODS */
    /*************************************************************************/

    var widgetForm = function () {

        // -- Carga de filtros

        $('.selectpicker').selectpickerAjax();

        // -- Borrar elemento

        $(_buttonDelete).on('click', function () {

            $(_popupDelete).find('.js-apply').attr('data-ajax', $(this).attr('data-ajax'));
            $(_popupDelete).find('.js-apply').attr('data-type', $(this).attr('data-type'));
            $(_popupDelete).find('.js-apply').attr('data-id', $(this).attr('data-id'));

            $(_popupDelete).modal('show');
        });

        $(_popupDelete).find('.js-apply').off().on('click', function () {
            var item = 'tr.' + $(this).attr('data-type') + '-' + $(this).attr('data-id');
            $(_popupDelete).modal('hide');
            _objLayout.loading('run');

            // -- Datos para el listado

            $.ajax({
                url: $(this).attr('data-ajax'),
                method: 'POST',
                dataType: 'json'
            }).done(function (response) {
                if (response.type == 'success') {
                    $(item).remove();
                }

                _objLayout.notification(response.type, response.message);

                _objLayout.loading('stop');
            });
        });
    };

    /*************************************************************************/

    return {
        init: init
    };

};