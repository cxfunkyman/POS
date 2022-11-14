let tblSuppliers, addressEditor;

const supplierForm = document.querySelector('#supplierForm');
const btnSRegister = document.querySelector('#btnSRegister');
const btnSNew = document.querySelector('#btnSNew');

const id = document.querySelector('#idSupplier');
const supplierTaxID = document.querySelector('#supplierTaxID');
const supplierName = document.querySelector('#supplierName');
const supplierPhone = document.querySelector('#supplierPhone');
const supplierEmail = document.querySelector('#supplierEmail');
const supplierAddress = document.querySelector('#supplierAddress');

const errorSupplierTaxID = document.querySelector('#errorSupplierTaxID');
const errorSupplierName = document.querySelector('#errorSupplierName');
const errorSupplierPhone = document.querySelector('#errorSupplierPhone');
const errorSupplierEmail = document.querySelector('#errorSupplierEmail');
const errorSupplierAddress = document.querySelector('#errorSupplierAddress');

document.addEventListener('DOMContentLoaded', function () {
    tblSuppliers = $('#tblSuppliers').DataTable({
        ajax: {
            url: base_url + '/Suppliers/listSuppliers',
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
        order: [[1, 'asc']]
    });
    //Inicialize the ckeditor5 editor
    ClassicEditor
        .create(document.querySelector('#supplierAddress'), {
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

    btnSNew.addEventListener('click', function () {
        id.value = '';
        btnSRegister.textContent = 'Register';
        supplierForm.reset();
        addressEditor.setData('');
        clearErrorFields();
    })
    //Send suppliers data
    supplierForm.addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrorFields();

        if (supplierTaxID.value == '') {
            errorSupplierTaxID.textContent = 'TAX ID REQUIRED';
        } else if (supplierName.value == '') {
            errorSupplierName.textContent = 'NAME REQUIRED';
        } else if (supplierPhone.value == '') {
            errorSupplierPhone.textContent = 'PHONE NUMBER REQUIRED';
        } else if (supplierEmail.value == '') {
            errorSupplierEmail.textContent = 'EMAIL REQUIRED';
        } else if (supplierAddress.value == '') {
            errorSupplierAddress.textContent = 'ADDRESS REQUIRED';
        } else {
            const url = base_url + 'suppliers/registerSuppliers';
            insertRegistry(url, this, tblSuppliers, btnSRegister, false, '#idSupplier');
            addressEditor.setData('');
        }
    })

})

function deleteSupplier(idSupplier) {
    const url = base_url + 'suppliers/delSupplier/' + idSupplier;
    deleteRegistry(url, tblSuppliers);
}

function editSupplier(idSupplier) {
    clearErrorFields();
    const url = base_url + 'suppliers/modifySuppliers/' + idSupplier;
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
            supplierTaxID.value = res.taxID;
            supplierName.value = res.name;
            supplierPhone.value = res.phone_number;
            supplierEmail.value = res.email;
            addressEditor.setData(res.address);
            btnSRegister.textContent = 'Update';
            firstTab.show();

        }
    }
}
function clearErrorFields() {
    errorSupplierTaxID.textContent = '';
    errorSupplierName.textContent = '';
    errorSupplierPhone.textContent = '';
    errorSupplierEmail.textContent = '';
    errorSupplierAddress.textContent = '';
}