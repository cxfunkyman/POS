let tblUsers;
const newForm = document.querySelector('#newForm');
const fName = document.querySelector('#fName');
const lName = document.querySelector('#lName');
const email = document.querySelector('#email');
const phone = document.querySelector('#phone');
const address = document.querySelector('#address');
const password = document.querySelector('#password');
const rol = document.querySelector('#rol');
const btnAction = document.querySelector('#btnAction');
const btnNew = document.querySelector('#btnNew');
const id = document.querySelector('#idUser');

const errorFName = document.querySelector('#errorFName');
const errorLName = document.querySelector('#errorLName');
const errorEmail = document.querySelector('#errorEmail');
const errorPhone = document.querySelector('#errorPhone');
const errorAddress = document.querySelector('#errorAddress');
const errorPassword = document.querySelector('#errorPassword');
const errorRol = document.querySelector('#errorRol');

document.addEventListener('DOMContentLoaded', function () {
    //Load data with the plugin Datatable
    tblUsers = $('#tblUsers').DataTable({
        ajax: {
            url: base_url + '/Users/listUsers',
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
    //Clear tab new form fields
    btnNew.addEventListener('click', function (e) {
        cleanFields();
    })
    //Register users
    newForm.addEventListener('submit', function (e) {
        e.preventDefault();

        //Elements to demostrate the errors
        clearErrorFields();
        
        if (fName.value == '') {
            errorFName.textContent = 'FIRST NAME REQUIRED';
        }
        else if (lName.value == '') {
            errorLName.textContent = 'LAST NAME REQUIRED';
        }
        else if (email.value == '') {
            errorEmail.textContent = 'EMAIL REQUIRED';
        }
        else if (phone.value == '') {
            errorPhone.textContent = 'PHONE NUMBER REQUIRED';
        }
        else if (address.value == '') {
            errorAddress.textContent = 'ADDRESS REQUIRED';
        }
        else if (password.value == '') {
            errorPassword.textContent = 'PASSWORD REQUIRED';
        }
        else if (rol.value == '') {
            errorRol.textContent = 'ROL REQUIRED';
        }
        else {
            const url = base_url + 'users/signUp';
            insertRegistry(url, this, tblUsers, btnAction, true, '#idUser');
        }
    })
})
//Delete user function
function deleteUser(idUser) {
    const url = base_url + 'users/delUsers/' + idUser;
    deleteRegistry(url, tblUsers);
}
// Edit\Recover user function
function editUser(idUser) {
    clearErrorFields();
    const url = base_url + 'users/editedUser/' + idUser;
    //instaciate the object XMLHttpRequest
    const http = new XMLHttpRequest();
    //open connection this time POST
    http.open('GET', url, true);
    //send data
    http.send();
    //verify status
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);

            id.value = res.id;
            fName.value = res.first_name;
            lName.value = res.last_name;
            email.value = res.email;
            phone.value = res.phone_number;
            address.value = res.address;
            password.value = '0000000';
            password.setAttribute('readonly', 'readonly');
            rol.value = res.rol;
            btnAction.textContent = 'Update';

            const firstTabEl = document.querySelector('#nav-tab button:last-child')
            const firstTab = new bootstrap.Tab(firstTabEl)

            firstTab.show()
        }
    }
}
function cleanFields() {
    id.value = '';
    btnAction.textContent = 'Register';
    password.removeAttribute('readonly');
    newForm.reset();
    fName.focus();
}
function clearErrorFields() {
    errorFName.textContent = '';
    errorLName.textContent = '';
    errorEmail.textContent = '';
    errorPhone.textContent = '';
    errorAddress.textContent = '';
    errorPassword.textContent = '';
    errorRol.textContent = '';
}
