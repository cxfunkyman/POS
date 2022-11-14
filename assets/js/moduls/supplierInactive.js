let tblInactiveSupplier;

document.addEventListener('DOMContentLoaded', function () {
    tblInactiveSupplier = $('#tblInactiveSupplier').DataTable({
        ajax: {
            url: base_url + '/Suppliers/listInactiveSuppliers',
            dataSrc: ''
        },
        columns: [
            { data: 'taxID' },
            { data: 'name' },
            { data: 'phone_number' },
            { data: 'email' },
            { data: 'address' },
            { data: 'actions' }
        ],
        dom,
        buttons,
        responsive: true,
        order: [[2, 'asc']]
    });

})
//Restore client function
function restoreSupplier(idSupplier) {
    const url = base_url + 'suppliers/supplierRestore/' + idSupplier;
    restoreRegistry(url, tblInactiveSupplier);
}