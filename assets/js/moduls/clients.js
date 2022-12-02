let tblClients, addressEditor;
const clientForm = document.querySelector('#clientForm');
const btnClientRegister = document.querySelector('#btnClientRegister');
const btnClientNew = document.querySelector('#btnClientNew');

const id = document.querySelector('#idClient');
const clientID = document.querySelector('#clientID');
const clientIDNumb = document.querySelector('#clientIDNumb');
const clientName = document.querySelector('#clientName');
const clientPhone = document.querySelector('#clientPhone');
const clientEmail = document.querySelector('#clientEmail');
const clientAddress = document.querySelector('#clientAddress');

const errorClientID = document.querySelector('#errorClientID');
const errorClientIDNumb = document.querySelector('#errorClientIDNumb');
const errorClientName = document.querySelector('#errorClientName');
const errorClientPhone = document.querySelector('#errorClientPhone');
const errorClientAddress = document.querySelector('#errorClientAddress');

document.addEventListener('DOMContentLoaded', function () {
    //Load data with the plugin Datatable
    tblClients = $('#tblClients').DataTable({
        ajax: {
            url: base_url + '/Clients/listClients',
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
    //Inicialize the ckeditor5 editor
    ClassicEditor
        .create(document.querySelector('#clientAddress'), {
            toolbar: {
                items: [
                    'selectAll', '|',
                    'heading', '|',
                    'bold', 'italic',
                    'outdent', 'indent', '|',
                    'undo', 'redo', '|',
                    'link', 'blockQuote', 'insertTable', 'mediaEmbed'
                ],
                shouldNotGroupWhenFull: true
            },
        })
        .then(editor => {
            addressEditor = editor;
        })
        .catch(error => {
            console.error(error);
        });

    btnClientNew.addEventListener('click', function () {
        id.value = '';
        btnClientRegister.textContent = 'Register';
        clientForm.reset();
        addressEditor.setData('');
    })
    //Send Clients data
    clientForm.addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrorFields();

        if (clientID.value == '') {
            errorClientID.textContent = 'CLIENT ID REQUIRED';
        } else if (clientIDNumb.value == '') {
            errorClientIDNumb.textContent = 'ID NUMBER REQUIRED';
        } else if (clientName.value == '') {
            errorClientName.textContent = 'CLIENT NAME REQUIRED';
        } else if (clientPhone.value == '') {
            errorClientPhone.textContent = 'PHONE NUMBER REQUIRED';
        } else if (clientAddress.value == '') {
            errorClientAddress.textContent = 'ADDRESS REQUIRED';
        } else {
            const url = base_url + 'Clients/registerClients';
            insertRegistry(url, this, tblClients, btnClientRegister, false, '#idClient');
            addressEditor.setData('');
        }
    })

})

function deleteClient(idClient) {
    const url = base_url + 'Clients/delClient/' + idClient;
    deleteRegistry(url, tblClients);
}

function editClient(idClient) {
    clearErrorFields();
    const url = base_url + 'Clients/modifyClients/' + idClient;
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
            clientID.value = res.identification;
            clientIDNumb.value = res.num_identity;
            clientName.value = res.name;
            clientPhone.value = res.phone_number;
            clientEmail.value = res.email;
            addressEditor.setData(res.address);
            btnClientRegister.textContent = 'Update';
            firstTab.show();

        }
    }
}
function clearErrorFields() {
    
    errorClientID.textContent = '';
    errorClientIDNumb.textContent = '';
    errorClientName.textContent = '';
    errorClientPhone.textContent = '';
    errorClientEmail.textContent = '';
    errorClientAddress.textContent = '';
}