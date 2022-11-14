let tblCredits;
const searchClientCredits = document.querySelector('#searchClientCredits');
const idCredits = document.querySelector('#idCredits');
const clientName = document.querySelector('#clientName');
const phoneClient = document.querySelector('#phoneClient');
const addressClient = document.querySelector('#addressClient');
const clientAbonate = document.querySelector('#clientAbonate');
const clientRemaining = document.querySelector('#clientRemaining');
const salesDates = document.querySelector('#salesDates');
const totalAmount = document.querySelector('#totalAmount');
const clientDeposit = document.querySelector('#clientDeposit');

const btnAddDeposit = document.querySelector('#btnAddDeposit');
const btnAddClean = document.querySelector('#btnAddClean');
const btnAddCancel = document.querySelector('#btnAddCancel');

const newModalDeposit = document.querySelector('#newModalDeposit');
const modalDeposit = new bootstrap.Modal('#modalDeposit');

document.addEventListener('DOMContentLoaded', function () {
    //Load data with the plugin Datatable
    tblCredits = $('#tblCredits').DataTable({
        ajax: {
            url: base_url + '/Credits/listCredits',
            dataSrc: ''
        },
        columns: [
            { data: 'amount' },
            { data: 'dates' },
            { data: 'name' },
            { data: 'remaining' },
            { data: 'deposit' },
            { data: 'sales' },
            { data: 'actions' }
        ],
        dom,
        buttons,
        responsive: true,
        order: [[5, 'asc']]
    });
    //autocomplete clients
    $("#searchClientCredits").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: base_url + 'credits/searchClients',
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        minLength: 2,
        select: function (event, ui) {
            //Just for test
            //console.log(ui.item);
            clientName.value = ui.item.label;
            phoneClient.value = ui.item.phone;
            addressClient.value = ui.item.address;
            clientAbonate.value = ui.item.deposit;
            clientRemaining.value = ui.item.remaining;
            salesDates.value = ui.item.dates;
            totalAmount.value = ui.item.amount;
            idCredits.value = ui.item.id;
            searchClientCredits.value = '';
            clientDeposit.focus();
            //addClientData(ui.item.id);
        }
    });
    //Lift modal to add deposit
    newModalDeposit.addEventListener('click', function () {
        clearFields();
        modalDeposit.show();
    });
    //clean fields of modal to add deposit
    btnAddClean.addEventListener('click', function () {
        clearFields();        
    });
    //Cancel and close modal to add deposit
    btnAddCancel.addEventListener('click', function () {
        clearFields();
        modalDeposit.hide();
    });

    //Add deposit
    btnAddDeposit.addEventListener('click', function () {
        //e.preventDefault();
        if (clientDeposit.value == '') {
            customAlert('warning', 'PLEASE ENTER A DEPOSIT AMOUNT');
        } else if (idCredits.value == '' &&
            phoneClient.value == '' &&
            clientName.value == '') {
            customAlert('warning', 'PLEASE SELECT A CLIENT');
        } else if (parseFloat(clientRemaining.value) < parseFloat(clientDeposit.value)) {
            customAlert('warning', 'THE DEPOSIT AMOUNT IS GREATER THAN REMAINING AMOUNT');

        } else if (clientDeposit.value == 0) {
            customAlert('warning', 'THE DEPOSIT AMOUNT MUST BE GREATER THAN ZERO');

        } else {
            const url = base_url + 'credits/addAbonateDeposit';
            //instaciate the object XMLHttpRequest
            const http = new XMLHttpRequest();
            //open connection this time POST
            http.open('POST', url, true);
            //send data
            http.send(JSON.stringify({
                idCredit: idCredits.value,
                depositAmount: clientDeposit.value
            }));
            //verify status
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    //For test
                    //console.log(this.responseText);
                    const res = JSON.parse(this.responseText);
                    if (res.type === 'success') {
                        customAlert(res.type, res.msg);
                        modalDeposit.hide();
                        tblCredits.ajax.reload();
                    }
                }
            }
        }
    });
});
function clearFields() {
    //for test
    //console.log('clear');
    searchClientCredits.value = "";
    idCredits.value = '';
    clientName.value = '';
    phoneClient.value = '';
    addressClient.value = '';
    clientAbonate.value = '';
    clientRemaining.value = '';
    salesDates.value = '';
    totalAmount.value = '';
    searchClientCredits.focus();
}