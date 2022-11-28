let tblOpenClose, tblExpenseHistory;

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
                }
            }
        }
    });
    btnCancel.addEventListener('click', function () {
        modalRegister.hide();
        initialAmount.value = '';
    });
});