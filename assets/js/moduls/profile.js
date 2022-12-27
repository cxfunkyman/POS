

const fName = document.getElementById('fNameProfile');
const lName = document.getElementById('lNameProfile');
const email = document.getElementById('emailProfile');
const phone = document.getElementById('phoneProfile');
const address = document.getElementById('addressProfile');
const oldPass = document.getElementById('oldPassProfile');
const newPass = document.getElementById('newPassProfile');

const profilePhoto = document.querySelector('#profilePhoto');
const actualPhoto = document.querySelector('#actualPhoto');
const containerPreview = document.querySelector('#containerPreview');

const btnSaveProfile = document.getElementById('btnSaveProfile');

const profileForm = document.getElementById('profileForm');

document.addEventListener('DOMContentLoaded', () => {
    profileForm.addEventListener('submit', function (e) {
        e.preventDefault();

        if (fName.value == '') {
            customAlert('warning', 'FIRST NAME REQUIRED');
        } else if (lName.value == '') {
            customAlert('warning', 'LAST NAME REQUIRED');
        } else if (email.value == '') {
            customAlert('warning', 'EMAIL REQUIRED');
        } else if (phone.value == '') {
            customAlert('warning', 'PHONE NUMBER REQUIRED');
        } else if (address.value == '') {
            customAlert('warning', 'ADDRESS REQUIRED');
        }
        else {
            const url = base_url + 'users/updateProfile';
            //instaciate the object XMLHttpRequest
            const http = new XMLHttpRequest();
            //open connection this time POST
            http.open('POST', url, true);
            //send data
            http.send(new FormData(this));
            //verify status
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    //Just for testing
                    //console.log(this.responseText);
                    const res = JSON.parse(this.responseText);                    
                        customAlert(res.type, res.msg);

                    if (res.password) {
                        customAlert('success', 'PASSWORD CHANGED, NOW YOU WILL BE LOGGED OUT');
                        setTimeout(() => {                            
                            window.location = base_url + 'users/logout';
                        }, 2000);
                    } else {

                    }
                }
            }
        }
    });
    //Preview selected photo
    profilePhoto.addEventListener('change', function (e) {
        if (e.target.files[0].type == 'image/png' ||
            e.target.files[0].type == 'image/jpg' ||
            e.target.files[0].type == 'image/jpeg') {

            const url = e.target.files[0];
            const tmpUrl = URL.createObjectURL(url);
            containerPreview.innerHTML = `<img class="img-thumbnail" src="${tmpUrl}" width="200">
                    <button class="btn btn-danger" type="button" onclick="delPreview()"><i class="fas fa-trash"></i></button>`;
        } else {
            profilePhoto.value = '';
            customAlert('warning', 'ONLY JPG, JPEG AND PNG IMAGES ARE ACEPTED')
        }
    });
});
function delPreview() {
    profilePhoto.value = '';
    containerPreview.innerHTML = '';
    actualPhoto.value = '';
}