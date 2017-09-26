if (!dokify) {
    var dokify = {};
}

dokify.AgreementLanding = function (_objLayout) {

    var _buttonClear = '.js-btn-clear';
    var _buttonApply = '.js-btn-filter';
    var _buttonView = '.js-btn-view';
    var _fieldCompany = '.js-company';
    var _fieldCompanyCustomer = '.js-company-customer';
    var _fieldCompanyProvider = '.js-company-provider';
    var _refTable = '.js-table';

    var _objTable;

    /*************************************************************************/

    var init = function () {
        widgetFilters();
        widgetTable();
    };

    /*************************************************************************/
    /* PRIVATE METHODS */
    /*************************************************************************/

    var cellAction = function (id) {
        return '<button type="button"' +
            ' class="js-btn-view btn btn-default"' +
            ' data-ajax="/agreement/' + id + '/detail"' +
            ' data-target="#js-popup-agreement"' +
            ' data-toggle="modal">' +
            ' View</button>' +
            ' &nbsp;<a type="button"' +
            ' class="js-btn-view btn btn-default"' +
            ' href="/agreement/' + id + '/edit">' +
            ' Edit</a>';
    };

    var widgetFilters = function () {

        // -- Carga de filtros

        $('.selectpicker').selectpickerAjax();

        $('.selectpicker').on('change', function() {
            var text = [];

            $(this).find(':selected').each(function() {
                text.push($(this).text());
            });

             $($(this).attr('data-rel')).html(text.join(', '));
        });

        // -- Limpiar filtros

        $(_buttonClear).on('click', function () {
            _objLayout.loading('run');
            $('.selectpicker').each(function() {
                $(this).find('option:selected').attr('selected', false);
                $(this).selectpicker('val', '');
            });
            $('.js-filter-label').html('-');
            _objTable.clear().draw();

            widgetTableControls();

            _objLayout.loading('stop');

            return false;
        });

        // -- Búsqueda de datos

        $(_buttonApply).on('click', function () {
            _objLayout.loading('run');

            // -- Datos para el listado

            $.ajax({
                url: $(this).attr('data-ajax-list'),
                method: 'POST',
                data: {
                    company: $(_fieldCompany).selectpicker('val'),
                    companyCustomer: $(_fieldCompanyCustomer).selectpicker('val'),
                    companyProvider: $(_fieldCompanyProvider).selectpicker('val')
                },
                dataType: 'json'
            }).done(function (response) {
                _objTable.clear().draw();

                $.each(response, function (key, value) {
                    data = [
                        value.id,
                        value.name,
                        ''
                    ];

                    _objTable.row.add(data).draw();
                });

                widgetTableControls();

                _objLayout.loading('stop');
            });

            return false;
        });
    };

    var widgetTable = function () {

        // -- Inicialización de la tabla

        _objTable = $(_refTable).DataTable({
            columnDefs: [
                {targets: 'no-sort', orderable: false}
            ],
            createdRow: function (row, data, index) {
                $('td', row).eq(2).html(cellAction(data[0]));

                widgetTableControls();
            },
            order: [[0, 'asc']]
        });
    };

    var widgetTableControls = function() {

        // -- Botón View

        $(_buttonView).off().on('click', function() {
            var popup = $(this).attr('data-target');

            $(popup).find('.modal-body').html('<div class="overlay text-center"><i class="fa fa-refresh fa-spin"></i></div>');

            $.ajax({
                url: $(this).attr('data-ajax'),
                method: 'POST',
                dataType: 'html'
            }).done(function (response) {
                $(popup).find('.modal-body').html(response);
            });
        })
    };

    /*************************************************************************/

    return {
        init: init
    };

};