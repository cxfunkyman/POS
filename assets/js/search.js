let cartList, tblRecords;

const searchBarcodeInput = document.querySelector('#searchBarcodeInput');
const searchNameInput = document.querySelector('#searchNameInput');
const radioBarcode = document.querySelector('#radioBarcode');
const radioName = document.querySelector('#radioName');
const barcodeContainer = document.querySelector('#barcodeContainer');
const nameContainer = document.querySelector('#nameContainer');

const totalAmount = document.querySelector('#totalAmount');
const btnComplete = document.querySelector('#btnComplete');

// filter by date
const fromInput = document.querySelector('#fromInput');
const toInput = document.querySelector('#toInput');

document.addEventListener('DOMContentLoaded', function () {
    //Check if there is any item in the local storage
    if (localStorage.getItem(cartKey) != null) {
        cartList = JSON.parse(localStorage.getItem(cartKey));
    }

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
            searchProduct(e.target.value);
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
            //console.log(ui.item);
            addLocalProduct(ui.item.id, 1, ui.item.stock);
            searchNameInput.value = '';
            searchNameInput.focus();
            return false;
        }
    });

    //function for filtering the orders by date
    fromInput.addEventListener('change', function () {
        tblRecords.draw();
    });
    toInput.addEventListener('change', function () {
        tblRecords.draw();
    });

    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            const FilterStart = fromInput.value;
            const FilterEnd = toInput.value;
            const DataTableStart = data[0].trim();
            const DataTableEnd = data[0].trim();
            if (FilterStart == '' || FilterEnd == '') {
                return true;
            }
            return !!(DataTableStart >= FilterStart && DataTableEnd <= FilterEnd);

        });
})

function searchProduct(value) {
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
                addLocalProduct(res.data.id, 1, res.data.quantity);
            }
            searchBarcodeInput.value = '';
            searchBarcodeInput.focus();
        }
    }
}
//Add products to localStorage
function addLocalProduct(idProduct, quantity, currentStock) {
    if (localStorage.getItem(cartKey) == null) {
        cartList = [];
    } else {
        if (cartKey === 'postSale') {
            let addedQuantity = 0;
            for (let i = 0; i < cartList.length; i++) {
                if (cartList[i]['id'] == idProduct) {
                    addedQuantity = parseInt(cartList[i]['quantity']) + parseInt(quantity);
                }
            }
            //just for test
            //console.log(addedQuantity);
            //console.log(cartList.length);
            if (addedQuantity > currentStock || currentStock == 0) {
                customAlert('warning', 'STOCK UNAVAILABLE');
                return;
            }
        }
        for (const element of cartList) {
            if (element['id'] == idProduct) {
                element['quantity'] = parseInt(element['quantity']) + 1;
                localStorage.setItem(cartKey, JSON.stringify(cartList));
                customAlert('success', 'PRODUCT ADDED');
                tblLoadProducts();
                return;
            }
        }
    }
    cartList.push({
        id: idProduct,
        quantity: quantity
    })
    localStorage.setItem(cartKey, JSON.stringify(cartList));
    customAlert('success', 'PRODUCT ADDED');
    tblLoadProducts();

}

//event click to eliminate product
function btnDeleteProductTbl() {
    let productList = document.querySelectorAll('.btnDeleteProduct');

    for (let i = 0; i < productList.length; i++) {
        productList[i].addEventListener('click', function () {
            let idProduct = productList[i].getAttribute('data-id');
            //for test.
            //console.log(idProduct);
            listDeleteProduct(idProduct);
        });
    }
}
//function to eliminate product from the localStorage
function listDeleteProduct(idProduct) {
    for (let i = 0; i < cartList.length; i++) {
        if (cartList[i]['id'] == idProduct) {
            cartList.splice(i, 1);
        }
        localStorage.setItem(cartKey, JSON.stringify(cartList));
        customAlert('success', 'PRODUCT DELETED');
        tblLoadProducts();
    }
}
//add event 'change' to edit the quantity field in the table and localStorage
function inputChangeQuantity() {
    let productList = document.querySelectorAll('.inputQuantity');

    for (const element of productList) {
        element.addEventListener('change', function () {
            let idProduct = element.getAttribute('data-id');
            let quantity = element.value;
            //for test.
            //console.log(idProduct, quantity);
            listUpdateQuantityTbl(idProduct, quantity);
        });
    }
}
//function to eliminate product from the localStorage
function listUpdateQuantityTbl(idProduct, quantity) {
    if (cartKey === 'postSale') {
        const url = base_url + 'sales/verifyStock/' + idProduct;
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
                if (res.quantity >= quantity) {
                    for (let i = 0; i < cartList.length; i++) {
                        if (cartList[i]['id'] == idProduct) {
                            cartList[i]['quantity'] = quantity;
                        }
                    }
                    localStorage.setItem(cartKey, JSON.stringify(cartList));
                } else {
                    customAlert('warning', 'STOCK UNAVAILABLE');
                }
                tblLoadProducts();
                return;
                // customAlert(res.type, res.msg)
                // if (res.type == 'success') {
                //     tblRecords.ajax.reload();
                // }
                //console.log(this.responseText);
            }
        }
    } else {
        for (let i = 0; i < cartList.length; i++) {
            if (cartList[i]['id'] == idProduct) {
                cartList[i]['quantity'] = quantity;
            }
        }

        localStorage.setItem(cartKey, JSON.stringify(cartList));
        tblLoadProducts();
    }
}