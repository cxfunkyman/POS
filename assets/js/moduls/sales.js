const tblSale = document.querySelector('#tblSale tbody');

const searchClient = document.querySelector('#searchClient');
const idClient = document.querySelector('#idClient');
const phoneClient = document.querySelector('#phoneClient');
const addressClient = document.querySelector('#addressClient');
const nameSeller = document.querySelector('#nameSeller');
const nameClient = document.querySelector('#nameClient');

const payMethod = document.querySelector('#payMethod');
const discount = document.querySelector('#discount');
const directPrint = document.querySelector('#directPrint');

document.addEventListener('DOMContentLoaded', function () {
    tblLoadProducts();

    //autocomplete clients
    $("#searchClient").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: base_url + 'clients/searchClients',
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
            phoneClient.value = ui.item.phone;
            addressClient.innerHTML = ui.item.address;
            nameClient.value = ui.item.label;
            idClient.value = ui.item.id;
            searchClient.value = '';
            //addClientData(ui.item.id);
        }
    });

    //complete the Sale
    btnComplete.addEventListener('click', function () {

        const cartListRow = document.querySelectorAll('#tblSale tr').length;
        // for test only
        // console.log(cartListRow);
        // return;
        if (cartListRow < 2) {
            customAlert('warning', 'CART EMPTY');
        } else if (idClient.value == '' &&
            phoneClient.value == '' &&
            nameClient.value == ''
        ) {
            customAlert('warning', 'CLIENT REQUIRED');
        } else if (payMethod.value == '') {
            customAlert('warning', 'PAYMENT METHOD REQUIRED');
        } else {
            const url = base_url + 'Sales/registerSale/';
            //instaciate the object XMLHttpRequest
            const http = new XMLHttpRequest();
            //open connection this time POST
            http.open('POST', url, true);
            //send data
            http.send(JSON.stringify({
                products: cartList,
                idClient: idClient.value,
                payMethod: payMethod.value,
                discount: discount.value,
                optionPrinter: directPrint.checked
            }));
            //generarte ticket or invoice alert
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    //for test
                    //console.log(this.responseText);
                    customAlert(res.type, res.msg);
                    if (res.type == 'success') {
                        localStorage.removeItem(cartKey);
                        setTimeout(() => {
                            Swal.fire({
                                title: 'Do you want to generate an invoice?',
                                showDenyButton: true,
                                showCancelButton: true,
                                confirmButtonText: 'Ticket',
                                denyButtonText: `Invoice`,
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                    const route = base_url + 'sales/reports/tickets/' + res.idSale;
                                    window.open(route, '_blank');
                                } else if (result.isDenied) {
                                    const route = base_url + 'sales/reports/invoice/' + res.idSale;
                                    window.open(route, '_blank');
                                }
                                window.location.reload();
                            })
                        }, 2000);
                    }
                }
            }
        }
    })
    //Load data with the plugin Datatable
    tblRecords = $('#tblRecords').DataTable({
        ajax: {
            url: base_url + '/Sales/listSales',
            dataSrc: ''
        },
        columns: [
            { data: 'dates' },
            { data: 'time_day' },
            { data: 'total' },
            { data: 'name' },
            { data: 'serie' },
            { data: 'pay_method' },
            { data: 'actions' }
        ],
        dom,
        buttons,
        responsive: true,
        order: [[0, 'desc']]
    });
})
//Load table with products
function tblLoadProducts() {
    if (localStorage.getItem(cartKey) != null) {
        console.log(localStorage.getItem(cartKey).length);
        const url = base_url + 'products/tblShowData/';
        //instaciate the object XMLHttpRequest
        const http = new XMLHttpRequest();
        //open connection this time POST
        http.open('POST', url, true);
        //send data
        http.send(JSON.stringify(cartList));
        //verify status
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                //Just for test
                //console.log(this.responseText);
                //addLocalProduct(res.id, 1);

                let html = '';
                if (res.products.length > 0) {
                    res.products.forEach(product => {

                        html += `<tr>
                        <td>${product.name}</td>
                        <td>${product.sale_price}</td>
                        <td width="125">
                        <input class="form-control inputQuantity" type="number" data-id="${product.id}" value="${product.quantity}" placeholder="Quantity">
                        </td>
                        <td>${product.subTotalSale}</td>
                        <td><button class="btn btn-danger btnDeleteProduct" data-id="${product.id}" type="button"><i class="fas fa-trash"></i></button></td>
                    </tr>`;
                    });
                    tblSale.innerHTML = html;
                    totalAmount.value = res.totalSale;
                    btnDeleteProductTbl();
                    inputChangeQuantity();
                } else {
                    tblSale.innerHTML = '';
                }
            }
        }
    } else {
        tblSale.innerHTML = `<tr>
        <td colspan="4" class="text-center">EMPTY CART</td>
    </tr>`;
    }
}
function showReport(idSale) {
    Swal.fire({
        title: 'Do you want to generate an invoice?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ticket',
        denyButtonText: `Invoice`,
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            const route = base_url + 'sales/reports/tickets/' + idSale;
            window.open(route, '_blank');
        } else if (result.isDenied) {
            const route = base_url + 'sales/reports/invoice/' + idSale;
            window.open(route, '_blank');
        }
    })
}
function deleteSale(idSale) {
    Swal.fire({
        title: 'Are you sure you want to cancel the order?',
        text: "Products stock will be modify!.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, cancel!'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + 'sales/cancelSale/' + idSale;
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
                    customAlert(res.type, res.msg)
                    if (res.type == 'success') {
                        tblRecords.ajax.reload();
                    }
                }
            }
        }
    })
}