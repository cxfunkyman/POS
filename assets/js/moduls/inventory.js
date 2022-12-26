
let tblInventory;

const btnSearch = document.querySelector('#btnSearch');
const btnReport = document.querySelector('#btnReport');
const btnInvAdjust = document.querySelector('#btnInvAdjust');

const invMonth = document.querySelector('#invMonth');
const id = document.querySelector('#idMeasure');

const modalInvAdjust = new bootstrap.Modal('#modalInvAdjust');

//Tab KARDEX
const searchBarcodeInput = document.querySelector('#searchBarcodeInput');
const searchNameInput = document.querySelector('#searchNameInput');
const radioBarcode = document.querySelector('#radioBarcode');
const radioName = document.querySelector('#radioName');
const barcodeContainer = document.querySelector('#barcodeContainer');
const nameContainer = document.querySelector('#nameContainer');

//Modal Adjust Inventory
const searchBarcodeFit = document.querySelector('#searchBarcodeFit');
const searchNameFit = document.querySelector('#searchNameFit');
const radioBarcodeFit = document.querySelector('#radioBarcodeFit');
const radioNameFit = document.querySelector('#radioNameFit');
const barcodeContainerFit = document.querySelector('#barcodeContainerFit');
const nameContainerFit = document.querySelector('#nameContainerFit');
const adjustQty = document.querySelector('#adjustQty');
const idAjustProduct = document.querySelector('#idAjustProduct');
const productNameFit = document.querySelector('#productNameFit');
const productStockFit = document.querySelector('#productStockFit');
const errorSearch = document.querySelector('#errorSearch');

const btnCancelProcess = document.querySelector('#btnCancelProcess');
const btnProcess = document.querySelector('#btnProcess');

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
    //Inventory adjustment modal
    btnInvAdjust.addEventListener('click', function () {
        modalInvAdjust.show();
        clearModalFields();
    });
    //Cancel process
    btnCancelProcess.addEventListener('click', function () {
        modalInvAdjust.hide();
    });

    //function to display the search by name input field
    radioNameFit.addEventListener('click', function () {
        barcodeContainerFit.classList.add('d-none');
        nameContainerFit.classList.remove('d-none');
        idAjustProduct.value = '';
        searchNameFit.value = '';
        searchNameFit.focus();
    })
    //function to display the search by code input field
    radioBarcodeFit.addEventListener('click', function () {
        nameContainerFit.classList.add('d-none');
        barcodeContainerFit.classList.remove('d-none');
        idAjustProduct.value = '';
        searchBarcodeFit.value = '';
        searchBarcodeFit.focus();
    })
    searchBarcodeFit.addEventListener('keyup', function (e) {
        //Just for test
        //console.log(radioBarcode.checked);
        //console.log(e.target.value);
        if (e.keyCode === 13) {
            searchByCode(e.target.value);
        }
        return;
    })
    //autocomplete products
    $("#searchNameFit").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: base_url + 'products/searchByName',
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
            idAjustProduct.value = ui.item.id;
            productNameFit.value = ui.item.label;
            productStockFit.value = ui.item.stock;
            searchNameFit.value = '';
            adjustQty.focus();
            return false;
        }
    });
    //Process inventory adjustment
    btnProcess.addEventListener('click', function () {
        if (idAjustProduct.value == '' || adjustQty.value == '') {
            customAlert('warning', 'YOU MUST SELECT A PRODUCT AND ENTER A QUANTITY');
        } else if (adjustQty.value == 0) {
            customAlert('warning', 'QUANTITY MUST BE DIFFERENT FROM ZERO');
        } else {
            const url = base_url + 'inventory/processAdjust/';
            //instaciate the object XMLHttpRequest
            const http = new XMLHttpRequest();
            //open connection this time POST
            http.open('POST', url, true);
            //send data
            http.send(
                JSON.stringify({
                    idProduct: idAjustProduct.value,
                    quantity: adjustQty.value
                })
            );
            //verify status
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    //Just for test
                    //console.log(this.responseText);
                    const res = JSON.parse(this.responseText);
                    customAlert(res.type, res.msg);
                    if (res.type == 'success') {
                        clearModalFields();
                        loadInventory(base_url + 'inventory/listInvMovement');
                    } else {
                        customAlert('warning', 'PRODUCT DOES NOT EXIST');
                    }

                }
            }
        }
    });
    //##### KARDEX #####
    //function to display the search by name input field
    radioName.addEventListener('click', function () {
        barcodeContainer.classList.add('d-none');
        nameContainer.classList.remove('d-none');
        searchNameInput.value = '';
        searchNameInput.focus();
    })
    //function to display the search by code input field
    radioBarcode.addEventListener('click', function () {
        nameContainer.classList.add('d-none');
        barcodeContainer.classList.remove('d-none');
        searchBarcodeInput.value = '';
        searchBarcodeInput.focus();
    })
    searchBarcodeInput.addEventListener('keyup', function (e) {
        //Just for test
        //console.log(radioBarcode.checked);
        //console.log(e.target.value);
        if (e.keyCode === 13) {
            searchCodeProduct(e.target.value);
        }
        return;
    })
    //autocomplete products
    $("#searchNameInput").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: base_url + 'products/searchByName',
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
            console.log(ui.item);
            reportKardex(ui.item.id);
        }
    });
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
            { data: 'stock' },
            { data: 'movement' },
            { data: 'action' },
            { data: 'quantity' },
            { data: 'dates' },
            { data: 'time_day' },
            { data: 'code' },
            { data: 'photo' },
            { data: 'name' }
        ],
        dom,
        buttons,
        responsive: true,
        destroy: true,
        order: [[5, 'asc']]
    });
}
function searchByCode(value) {
    const url = base_url + 'products/searchByBarcode/' + value;
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
            //Just for test
            //console.log(res);
            if (!res.status) {
                customAlert('warning', 'PRODUCT DOES NOT EXIST');
            } else {
                //Just for test
                // console.log(res);
                // return;
                idAjustProduct.value = res.data.id;
                productNameFit.value = res.data.product;
                productStockFit.value = res.data.quantity;
            }
            searchBarcodeFit.value = '';
            adjustQty.focus();
        }
    }
}
function searchCodeProduct(value) {
    const url = base_url + 'products/searchByBarcode/' + value;
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
            //Just for test
            //console.log(res);
            if (!res.status) {
                customAlert('warning', 'PRODUCT DOES NOT EXIST');
            } else {
                // Just for test
                // console.log(res);
                // return;
                reportKardex(res.data.id);
            }

        }
    }
}
function clearModalFields() {
    idAjustProduct.value = '';
    adjustQty.value = '';
    searchNameFit.value = '';
    searchBarcodeFit.value = '';
    productNameFit.value = '';
    productStockFit.value = '';
}
function reportKardex(idProduct) {
    let timerInterval
    Swal.fire({
        title: 'IN/OUT INVENTORY STOCK',
        html: 'Generating report in <b></b> milliseconds.',
        timer: 1500,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading()
            const b = Swal.getHtmlContainer().querySelector('b')
            timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft()
            }, 100)
        },
        willClose: () => {
            clearInterval(timerInterval)
        }
    }).then((result) => {
        /* Read more about handling dismissals below */
        if (result.dismiss === Swal.DismissReason.timer) {
            const route = base_url + 'inventory/kardex/' + idProduct;
            window.open(route, '_blank');
        }
    })
}
