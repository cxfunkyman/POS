let tblInactiveClient;

document.addEventListener('DOMContentLoaded', function () {
    tblInactiveClient = $('#tblInactiveClient').DataTable({
        ajax: {
            url: base_url + '/Clients/listInactiveClients',
            dataSrc: ''
        },
        columns: [
            { data: 'identification' },
            { data: 'num_identity' },
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
function restoreClient(idClient) {
    const url = base_url + 'clients/clientRestore/' + idClient;
    restoreRegistry(url, tblInactiveClient);
}