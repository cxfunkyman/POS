let tblInactiveCategories;

document.addEventListener('DOMContentLoaded', function () {
    tblInactiveCategories = $('#tblInactiveCategories').DataTable({
        ajax: {
            url: base_url + '/Categories/listInactiveCategories',
            dataSrc: ''
        },
        columns: [
            { data: 'category' },
            { data: 'dates' },
            { data: 'actions' }
        ],
        dom,
        buttons,
        responsive: true,
        order: [[0, 'asc']]
    });

})
//Restore user function
function restoreCategory(idCategory) {
    const url = base_url + 'categories/categoryRestore/' + idCategory;
    restoreRegistry(url, tblInactiveCategories);
}