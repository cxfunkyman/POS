let tblInactiveMeasures;

document.addEventListener('DOMContentLoaded', function () {
    tblInactiveMeasures = $('#tblInactiveMeasures').DataTable({
        ajax: {
            url: base_url + '/Measures/listInactiveMeasures',
            dataSrc: ''
        },
        columns: [
            { data: 'measure' },
            { data: 'short_name' },
            { data: 'actions' }
        ],
        dom,
        buttons,
        responsive: true,
        order: [[0, 'asc']]
    });

})
//Restore user function
function restoreMeasure(idMeasure) {
    const url = base_url + 'measures/measureRestore/' + idMeasure;
    restoreRegistry(url, tblInactiveMeasures);
}