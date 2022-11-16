// fullcalendar: https://fullcalendar.io/
//               https://fullcalendar.io/docs/locale
//               https://fullcalendar.io/docs/headerToolbar

const tblReserves = document.querySelector('#tblReserves tbody');

const searchClient = document.querySelector('#searchClient');
const idClient = document.querySelector('#idClient');

const nameClient = document.querySelector('#nameClient');
const phoneClient = document.querySelector('#phoneClient');
const addressClient = document.querySelector('#addressClient');
const nameSeller = document.querySelector('#nameSeller');
//const totalAmount = document.querySelector('#totalAmount');
const reserveDate = document.querySelector('#reserveDate');
const withdrawDate = document.querySelector('#withdrawDate');
const depositAmount = document.querySelector('#depositAmount');
const dateColor = document.querySelector('#dateColor');

const modalReserve = new bootstrap.Modal('#modalReserve');



document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var today = new Date();
    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        dateClick: function (info) {
            today.setDate(today.getDate() + 0);
            //Just for test
            //console.log(info.dateStr);
            //console.log(today.toLocaleDateString('en-CA'));
            if (info.dateStr >= today.toLocaleDateString('en-CA')) {
                //just for test
                //console.log(info.dateStr);
                reserveDate.value = info.dateStr;
                withdrawDate.setAttribute('min', reserveDate.value);
                clearFields();
                //totalAmount.value = '';
                modalReserve.show();
            } else {
                customAlert('warning', 'DATE CANNOT BE LESS THAN TODAY');
            }
        }
    });
    calendar.render();

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
            addressClient.value = ui.item.address;
            nameClient.value = ui.item.label;
            idClient.value = ui.item.id;
            searchClient.value = '';
            //addClientData(ui.item.id);
        }
    });

    //clean fields of modal to add deposit
    btnAddClean.addEventListener('click', function () {
        clearFields();
    });
    //Cancel and close modal to add deposit
    btnAddCancel.addEventListener('click', function () {
        clearFields();
        localStorage.removeItem(cartKey);
        window.location.reload();
        //modalReserve.hide();
    });
    //complete the reserves
    btnComplete.addEventListener('click', function () {

        const cartListRow = document.querySelectorAll('#tblReserves tr').length;
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
        } else if (reserveDate.value == '') {
            customAlert('warning', 'RESERVE DATE REQUIRED');
        } else if (withdrawDate.value == '') {
            customAlert('warning', 'WITHDRAW DATE REQUIRED');
        } else if (depositAmount.value == '') {
            customAlert('warning', 'DEPOSIT AMOUNT REQUIRED');
        } else {
            const url = base_url + 'reserves/registerReserves/';
            //instaciate the object XMLHttpRequest
            const http = new XMLHttpRequest();
            //open connection this time POST
            http.open('POST', url, true);
            //send data
            http.send(JSON.stringify({
                products: cartList,
                idClient: idClient.value,
                reserveDate: reserveDate.value,
                withdrawDate: withdrawDate.value,
                depositAmount: depositAmount.value,
                dateColor: dateColor.value
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
});
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
                    tblReserves.innerHTML = html;
                    totalAmount.value = res.totalSale;
                    btnDeleteProductTbl();
                    inputChangeQuantity();
                } else {
                    totalAmount.value = '';
                    tblReserves.innerHTML = `<tr>
                            <td colspan="5" class="text-center">EMPTY CART</td>
                        </tr>`;
                }
            }
        }
    } else {
        totalAmount.value = '';
        tblReserves.innerHTML = `<tr>
                <td colspan="5" class="text-center">EMPTY CART</td>
            </tr>`;
    }
}
function clearFields() {
    //for test
    //console.log('clear');
    searchClient.value = "";
    idClient.value = '';
    nameClient.value = '';
    phoneClient.value = '';
    addressClient.value = '';
    withdrawDate.value = '';
    depositAmount.value = '';
    searchClient.focus();
}