const tblPurchase = document.querySelector('#tblPurchase tbody');

const searchSupplier = document.querySelector('#searchSupplier');
const idSupplier = document.querySelector('#idSupplier');
const phoneSupplier = document.querySelector('#phoneSupplier');
const addressSupplier = document.querySelector('#addressSupplier');
const nameBuyer = document.querySelector('#nameBuyer');

const purchaseNumber = document.querySelector('#purchaseNumber');
const nameSupplier = document.querySelector('#nameSupplier');

document.addEventListener('DOMContentLoaded', function () {
    //autocomplete suppliers
    purchaseNumber.value = pRamdonNumber();
    $("#searchSupplier").autocomplete({
        
        source: function (request, response) {
            $.ajax({
                url: base_url + 'suppliers/searchSuppliers',
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
            phoneSupplier.value = ui.item.phone;
            addressSupplier.innerHTML = ui.item.address;
            nameSupplier.value = ui.item.label;
            idSupplier.value = ui.item.id;
            searchSupplier.value = '';            
            //purchaseNumber.focus();
            //addSupplierData(ui.item.id);
            //purchaseNumber.value = base_url + 'Suppliers/generateOrderNumber';
        }
    });
    //Load data into tbl
    tblLoadProducts();

    //complete the order
    btnComplete.addEventListener('click', function () {

        const cartListRow = document.querySelectorAll('#tblPurchase tr').length;
        // for test only
        // console.log(cartListRow);
        // return;
        if (cartListRow < 2) {
            customAlert('warning', 'CART EMPTY');
        } else if (idSupplier.value == '' &&
            phoneSupplier.value == '' &&
            nameSupplier.value == ''
        ) {
            customAlert('warning', 'SUPPLIER REQUIRED');
        } else if (purchaseNumber.value == '') {
            customAlert('warning', 'PURCHASE NUMBER REQUIRED');
        } else {
            const url = base_url + 'purchases/registerOrder/';
            //instaciate the object XMLHttpRequest
            const http = new XMLHttpRequest();
            //open connection this time POST
            http.open('POST', url, true);
            //send data
            http.send(JSON.stringify({
                products: cartList,
                idSupplier: idSupplier.value,
                purchaseNumber: purchaseNumber.value,
            }));
            //generarte ticket or invoice alert
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);

                    console.log(this.responseText);
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
                                    const route = base_url + 'purchases/reports/tickets/' + res.idPurchase;
                                    window.open(route, '_blank');
                                } else if (result.isDenied) {
                                    const route = base_url + 'purchases/reports/invoice/' + res.idPurchase;
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
    //Load records with the plugin Datatable
    tblRecords = $('#tblRecords').DataTable({
        ajax: {
            url: base_url + '/Purchases/listRecords',
            dataSrc: ''
        },
        columns: [
            { data: 'dates' },
            { data: 'time_day' },
            { data: 'total' },
            { data: 'name' },
            { data: 'serie' },
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
                        <td>${product.purchase_price}</td>
                        <td width="125">
                        <input class="form-control inputQuantity" type="number" data-id="${product.id}" value="${product.quantity}" placeholder="Quantity">
                        </td>
                        <td>${product.subTotalPurchase}</td>
                        <td><button class="btn btn-danger btnDeleteProduct" data-id="${product.id}" type="button"><i class="fas fa-trash"></i></button></td>
                    </tr>`;
                    });
                    tblPurchase.innerHTML = html;
                    totalAmount.value = res.totalPurchase;
                    btnDeleteProductTbl();
                    inputChangeQuantity();
                } else {
                    tblPurchase.innerHTML = '';
                }
            }
        }
    } else {        
        tblPurchase.innerHTML = `<tr>
        <td colspan="4" class="text-center">EMPTY CART</td>
    </tr>`;
    }
}
function showReport(idPurchase) {
    Swal.fire({
        title: 'Do you want to generate an invoice?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ticket',
        denyButtonText: `Invoice`,
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            const route = base_url + 'purchases/reports/tickets/' + idPurchase;
            window.open(route, '_blank');
        } else if (result.isDenied) {
            const route = base_url + 'purchases/reports/invoice/' + idPurchase;
            window.open(route, '_blank');
        }
    })
}
function deletePurchase(idPurchase) {
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
            const url = base_url + 'Purchases/cancelOrder/' + idPurchase;
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
function pRamdonNumber() {
    const url = base_url + 'Suppliers/generateOrderNumber/';
    //instaciate the object XMLHttpRequest
    const http = new XMLHttpRequest();
    //open connection this time POST
    http.open('POST', url, true);
    //send data
    http.send();
    //verify status
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);            
            purchaseNumber.value = res;
            //console.log(res);
        }
    }
}