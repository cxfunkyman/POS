const compForm = document.querySelector('#companyForm');
const btnUpdate = document.querySelector('#btnUpdate');

const taxID = document.querySelector('#taxID');
const configName = document.querySelector('#configName');
const configPhone = document.querySelector('#configPhone');
const configEmail = document.querySelector('#configEmail');
const configAddress = document.querySelector('#configAddress');

const errortaxID = document.querySelector('#errortaxID');
const errorConfigName = document.querySelector('#errorConfigName');
const errorConfigPhone = document.querySelector('#errorConfigPhone');
const errorConfigEmail = document.querySelector('#errorConfigEmail');
const errorConfigAddress = document.querySelector('#errorConfigAddress');
const logoCompany = document.querySelector('#logoCompany');
const containerPreview = document.querySelector('#containerPreview');

document.addEventListener('DOMContentLoaded', function () {
    //Inicialize the ckeditor5 editor
    ClassicEditor
        .create(document.querySelector('#configMessage'), {
            toolbar: {
                items: [
                    'selectAll', '|',
                    'heading', '|',
                    'bold', 'italic',
                    'outdent', 'indent', '|',
                    'undo', 'redo', '|',
                    'link', 'blockQuote', 'insertTable', 'mediaEmbed'
                ],
                shouldNotGroupWhenFull: true
            },
        })
        .catch(error => {
            console.error(error);
        });
    //Preview selected photo
    logoCompany.addEventListener('change', function (e) {
        if (e.target.files[0].type == 'image/png') {

            const url = e.target.files[0];
            const tmpUrl = URL.createObjectURL(url);
            containerPreview.innerHTML = `<img class="img-thumbnail" src="${tmpUrl}" width="200">
                <button class="btn btn-danger" type="button" onclick="delPreview()"><i class="fas fa-trash"></i></button>`;
        } else {
            logoCompany.value = '';
            customAlert('warning', 'ONLY PNG IMAGES ARE ACEPTED')
        }
    })

    //Update company data
    compForm.addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrorFields();

        if (taxID.value == '') {
            errortaxID.textContent = 'TAX ID REQUIRED';
        } else if (configName.value == '') {
            errorConfigName.textContent = 'NAME REQUIRED';
        } else if (configPhone.value == '') {
            errorConfigPhone.textContent = 'PHONE NUMBER REQUIRED';
        } else if (configEmail.value == '') {
            errorConfigEmail.textContent = 'EMAIL REQUIRED';
        } else if (configAddress.value == '') {
            errorConfigAddress.textContent = 'ADDRESS REQUIRED';
        } else {
            const url = base_url + 'admin/modifyCompany';
            insertRegistry(url, this, null, btnUpdate, false, '#idCompany');
        }
    })
})
function clearErrorFields() {
    errortaxID.textContent = '';
    errorConfigName.textContent = '';
    errorConfigPhone.textContent = '';
    errorConfigEmail.textContent = '';
    errorConfigAddress.textContent = '';
}
function delPreview() {
    logoCompany.value = '';
    containerPreview.innerHTML = '';
}


