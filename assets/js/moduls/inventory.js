
let tblInventory;

const btnSearch = document.querySelector('#btnSearch');
const btnReport = document.querySelector('#btnReport');
const btnConfig = document.querySelector('#btnConfig');

const invMonth = document.querySelector('#invMonth');
const id = document.querySelector('#idMeasure');


document.addEventListener('DOMContentLoaded', function () {
    //Load data with the plugin Datatable
    loadInventory(base_url + 'inventory/listInvMovement');

    //Filter search by month
    btnSearch.addEventListener('click', function () {
        if (invMonth.value == '') {
            customAlert('warning', 'YOU MUST SELECT A MONTH');
        } else {
            //just for test
            // console.log(invMonth.value);
            // return;
            const url = base_url + 'inventory/listInvMovement/' + invMonth.value;
            loadInventory(url);
        }
    });
    //Inventory report
    btnReport.addEventListener('click', function () {
        if (invMonth.value == '') {
            window.open(base_url + 'inventory/report', '_blank');
        } else {
            //just for test
            // console.log(invMonth.value);
            // return;
            const url = base_url + 'inventory/report/' + invMonth.value;
            window.open(url, '_blank');
        }
    });
    function loadInventory(urlInventory) {
        //Load data with the plugin Datatable
        tblInventory = $('#tblInventory').DataTable({
            ajax: {
                url: urlInventory,
                dataSrc: ''
            },
            columns: [
                { data: 'product' },
                { data: 'movement' },
                { data: 'action' },
                { data: 'quantity' },
                { data: 'dates' },
                { data: 'time_day' },
                { data: 'code' },
                { data: 'photo' },
                { data: 'name' }
                //{ data: 'actions' }
            ],
            dom,
            buttons,
            responsive: true,
            destroy: true,
            order: [[4, 'desc']]
        });
    }
});