let tblOpenClose, tblExpenseHistory;

//New expense
const expenseForm = document.querySelector('#expenseForm');
const expenseAmount = document.querySelector('#expenseAmount');
const description = document.querySelector('#description');
const expensePhoto = document.querySelector('#expensePhoto');
const containerPreview = document.querySelector('#containerPreview');
const actualPhoto = document.querySelector('#actualPhoto');

const btnRegisterExpense = document.querySelector('#btnRegisterExpense');


//Modal input amount open cash register
const modalRegister = new bootstrap.Modal('#modalRegister');
const initialAmount = document.querySelector('#initialAmount');
const btnOpenRegister = document.querySelector('#btnOpenRegister');
const btnCancel = document.querySelector('#btnCancel');

//Modal btn open cash register
document.addEventListener('DOMContentLoaded', () => {
    btnOpenRegister.addEventListener('click', function () {
        if (initialAmount.value == '') {
            customAlert('warning', 'AMOUNT IS REQUIRED');
        } else {
            const url = base_url + 'CashRegister/openRegister';
            //instaciate the object XMLHttpRequest
            const http = new XMLHttpRequest();
            //open connection this time POST
            http.open('POST', url, true);
            //send data
            http.send(JSON.stringify({
                amount: initialAmount.value
            }));
            //verify status
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    //Just for testing
                    //console.log(this.responseText); 
                    const res = JSON.parse(this.responseText);
                    customAlert(res.type, res.msg);
                    window.location.reload();
                }
            }
        }
    });
    btnCancel.addEventListener('click', function () {
        modalRegister.hide();
        initialAmount.value = '';
    })
    //Load data with the plugin Datatable
    tblOpenClose = $('#tblOpenClose').DataTable({
        ajax: {
            url: base_url + '/CashRegister/listOpenClose',
            dataSrc: ''
        },
        columns: [
            { data: 'initial_amount' },
            { data: 'opening_date' },
            { data: 'closing_date' },
            { data: 'final_amount' },
            { data: 'total_sale' },
            { data: 'name' }
        ],
        dom,
        buttons,
        responsive: true,
        order: [[0, 'asc']]
    })

    //Inicialize the ckeditor5 editor
    ClassicEditor
        .create(document.querySelector('#description'), {
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
        .catch(error => {
            console.error(error);
        })

    //Register expense
    expenseForm.addEventListener('submit', function (e) {
        e.preventDefault();
        if (expenseAmount.value == '') {
            customAlert('warning', 'EXPENSE IS REQUIRED');
        } else if (description.value == '') {
            customAlert('warning', 'DESCRIPTION IS REQUIRED');
        } else {
            const url = base_url + 'CashRegister/registerExpense';
            insertRegistry(url, this, null, btnRegisterExpense, false, null);
            delPreview();
            // setTimeout(() => {
            //     window.location.reload();
            // }, 2000);
        }
    })

    //Preview selected photo
    expensePhoto.addEventListener('change', function (e) {
        if (e.target.files[0].type == 'image/png' ||
            e.target.files[0].type == 'image/jpg' ||
            e.target.files[0].type == 'image/jpeg') {

            const url = e.target.files[0];
            const tmpUrl = URL.createObjectURL(url);
            containerPreview.innerHTML = `<img class="img-thumbnail" src="${tmpUrl}" width="200">
                <button class="btn btn-danger" type="button" onclick="delPreview()"><i class="fas fa-trash"></i></button>`;
        } else {
            expensePhoto.value = '';
            customAlert('warning', 'ONLY JPG, JPEG AND PNG IMAGES ARE ACEPTED')
        }
    })




})

function delPreview() {
    expensePhoto.value = '';
    containerPreview.innerHTML = '';
    actualPhoto.value = '';
}