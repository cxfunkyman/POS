const tblQuotes = document.querySelector('#tblQuotes tbody');

const searchClient = document.querySelector('#searchClient');
const idClient = document.querySelector('#idClient');
const phoneClient = document.querySelector('#phoneClient');
const addressClient = document.querySelector('#addressClient');
const nameSeller = document.querySelector('#nameSeller');
const nameClient = document.querySelector('#nameClient');

const payMethod = document.querySelector('#payMethod');
const quoteValidate = document.querySelector('#quoteValidate');
const discount = document.querySelector('#discount');

document.addEventListener('DOMContentLoaded', function () {
    //Load products from localStorage
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

    //complete the quotes
    btnComplete.addEventListener('click', function () {

        const cartListRow = document.querySelectorAll('#tblQuotes tr').length;
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
        } else if (quoteValidate.value == '') {
            customAlert('warning', 'OFFER VALIDITY REQUIRED');
        }  else {
            const url = base_url + 'quotes/registerQuotes/';
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
                quoteValidate: quoteValidate.value
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
                                    const route = base_url + 'quotes/reports/tickets/' + res.idQuote;
                                    window.open(route, '_blank');
                                } else if (result.isDenied) {
                                    const route = base_url + 'quotes/reports/invoice/' + res.idQuote;
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
            url: base_url + '/Quotes/listQuotes',
            dataSrc: ''
        },
        columns: [
            { data: 'dates' },
            { data: 'time_day' },
            { data: 'total' },
            { data: 'name' },
            { data: 'validity' },
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
        //Just for test
        //console.log(localStorage.getItem(cartKey).length);
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
                    tblQuotes.innerHTML = html;
                    totalAmount.value = res.totalSale;
                    btnDeleteProductTbl();
                    inputChangeQuantity();
                } else {
                    tblQuotes.innerHTML = '';
                }
            }
        }
    } else {
        tblQuotes.innerHTML = `<tr>
        <td colspan="4" class="text-center">EMPTY CART</td>
    </tr>`;
    }
}
function showReport(idQuote) {
    Swal.fire({
        title: 'Do you want to generate an invoice?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ticket',
        denyButtonText: `Invoice`,
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            const route = base_url + 'quotes/reports/tickets/' + idQuote;
            window.open(route, '_blank');
        } else if (result.isDenied) {
            const route = base_url + 'quotes/reports/invoice/' + idQuote;
            window.open(route, '_blank');
        }
    })
}
