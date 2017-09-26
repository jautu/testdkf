if (!dokify) {
    var dokify = {};
}

dokify.CompanyLanding = function() {

    var _refTable = '.js-table';

    /*************************************************************************/

    var init = function () {
        widgetTable();
    };

    /*************************************************************************/
    /* PRIVATE METHODS */
    /*************************************************************************/

    var widgetTable = function () {

        // -- Inicialización de la tabla

        $(_refTable).DataTable({
            columnDefs: [
                { targets: 'no-sort', orderable: false }
            ]
        });
    };

    /*************************************************************************/

    return {
        init: init
    };

};