const logForm = document.querySelector('#logForm');
const email = document.querySelector('#email');
const password = document.querySelector('#password');

const emailError = document.querySelector('#emailError');
const passwordError = document.querySelector('#passwordError');

document.addEventListener('DOMContentLoaded', function () {
    logForm.addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrorFields();

        if (email.value == '') {
            emailError.textContent = 'EMAIL REQUIRED.';
        }
        else if (password.value == '') {
            passwordError.textContent = 'PASSWORD REQUIRED.';
        }
        else {
            const url = base_url + 'home/validate';
            //create formData 
            const data = new FormData(this);
            //instaciate the object XMLHttpRequest
            const http = new XMLHttpRequest();
            //open connection this time POST
            http.open('POST', url, true);
            //send data
            http.send(data);
            //verify status
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    //Custom error message from https://sweetalert2.github.io/
                    Swal.fire(
                        'Message?',
                        res.msg,
                        res.type
                    )
                    if (res.type == 'success') {
                        setTimeout(() => {
                            let timerInterval
                            Swal.fire({
                                title: res.msg,
                                html: 'You will be redirected in <b></b> milliseconds.',
                                timer: 2000,
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
                                    window.location = base_url + 'admin';
                                }
                            })
                        }, 2000);
                    }                    
                }
            }
        }
    });
});
function clearErrorFields() {
    emailError.textContent = '';
    passwordError.textContent = '';
}