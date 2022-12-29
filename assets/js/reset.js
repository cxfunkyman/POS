const btnChangePass = document.querySelector('#btnChangePass');
const newPass = document.querySelector('#newPass');
const confirmPass = document.querySelector('#confirmPass');
const resetToken = document.querySelector('#resetToken');

document.addEventListener("DOMContentLoaded", function () {
    btnChangePass.addEventListener('click', function () {
        if (newPass.value == '') {
            customAlert('warning', 'NEW PASSWORD REQUIRED', 2000);
        } else if (confirmPass.value == '') {
            customAlert('warning', 'CONFIRM PASSWORD REQUIRED', 2000);
        } else if (confirmPass.value != newPass.value) {
            customAlert('warning', 'NEW PASSWORD AND CONFIRM PASSWORD MUST BE THE SAME', 3000);
        }  else {
            const url = base_url + 'principal/resetPassword/';
            //instaciate the object XMLHttpRequest
            const http = new XMLHttpRequest();
            //open connection this time POST
            http.open('POST', url, true);
            //send data
            http.send(JSON.stringify({
                newPass: newPass.value,
                confirmPass: confirmPass.value,
                resetToken: resetToken.value
            }));
            //verify status
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    //Just for testing
                    // console.log(this.responseText);
                    const res = JSON.parse(this.responseText);
                    customAlert(res.type, res.msg, 2000)
                    if (res.type == 'success') {
                        setTimeout(() =>{
                            window.location.href = base_url;
                        }, 2500); 
                    }
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