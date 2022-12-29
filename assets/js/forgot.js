const btnForgot = document.querySelector('#btnForgot');
const forgotEmail = document.querySelector('#forgotEmail');

document.addEventListener("DOMContentLoaded", function () {
    btnForgot.addEventListener('click', function () {
        if (forgotEmail.value == '') {
            customAlert('warning', 'PLEASE, ENTER YOUR EMAIL ADDRESS', 2000)
        } else {
            const url = base_url + 'principal/emailSend/' + forgotEmail.value;
            //instaciate the object XMLHttpRequest
            const http = new XMLHttpRequest();
            //open connection this time POST
            http.open('GET', url, true);
            //send data
            http.send();
            //verify status
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    //Just for testing
                    // console.log(this.responseText);
                    const res = JSON.parse(this.responseText);
                    customAlert(res.type, res.msg, 4000)
                }
            }
        }
    });
});
function customAlert(type, msg, timer) {
    Swal.fire({
        toast: true,
        position: 'top-right',
        icon: type,
        title: msg,
        showConfirmButton: false,
        timer: timer
    })
}