if (!dokify) {
    var dokify = {};
}

dokify.RelationLanding = function (_objLayout) {

    var _buttonClear = '.js-btn-clear';
    var _buttonApply = '.js-btn-filter';
    var _buttonView = '.js-btn-view';
    var _fieldCompany = '.js-company';
    var _fieldCompanyRelated = '.js-company-related';
    var _fieldRelation = '.js-relation';
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
                    companyRelation: $(_fieldCompanyRelated).selectpicker('val'),
                    relation: $(_fieldRelation).selectpicker('val')
                },
                dataType: 'json'
            }).done(function (response) {
                _objTable.clear().draw();

                $.each(response, function (key, value) {
                    data = [
                        value.name,
                        value.nameCompany,
                        value.nameRelation,
                        value.nameCompanyRelation,
                        value.id
                    ];

                    _objTable.row.add(data).draw();
                });

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
            order: [[0, 'asc']]
        });
    };

    /*************************************************************************/

    return {
        init: init
    };

};