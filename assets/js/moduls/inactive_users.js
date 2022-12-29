let tblInactiveUsers;
document.addEventListener('DOMContentLoaded', function () {
    //Load data with the plugin Datatable
    tblInactiveUsers = $('#tblInactiveUsers').DataTable({
        ajax: {
            url: base_url + '/Users/listInactiveUsers',
            dataSrc: ''
        },
        columns: [
            { data: 'name' },
            { data: 'email' },
            { data: 'phone_number' },
            { data: 'address' },
            { data: 'rol' },
            { data: 'actions' }
        ],
        dom,
        buttons,
        responsive: true,
        order: [[0, 'asc']]
    });

})
//Restore user function
function restoreUser(idUser) {
    const url = base_url + 'users/userRestore/' + idUser;
    restoreRegistry(url, tblInactiveUsers);
}