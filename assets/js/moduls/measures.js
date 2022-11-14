let tblMeasures;
const measureForm = document.querySelector('#measureForm');
const btnRegister = document.querySelector('#btnRegister');
const btnMNew = document.querySelector('#btnMNew');
const measureName = document.querySelector('#measureName');
const shortName = document.querySelector('#shortName');
const errorMeasureName = document.querySelector('#errorMeasureName');
const errorShortName = document.querySelector('#errorShortName');
const id = document.querySelector('#idMeasure');

document.addEventListener('DOMContentLoaded', function () {
    //Load data with the plugin Datatable
    tblMeasures = $('#tblMeasures').DataTable({
        ajax: {
            url: base_url + '/Measures/listMeasures',
            dataSrc: ''
        },
        columns: [
            { data: 'measure' },
            { data: 'short_name' },
            { data: 'actions' }
        ],
        dom,
        buttons,
        responsive: true,
        order: [[0, 'asc']]
    });
    btnMNew.addEventListener('click', function () {
        id.value = '';
        btnRegister.textContent = 'Register';
        measureForm.reset();
    })
    //Send measures data
    measureForm.addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrorFields();

        if (measureName.value == '') {
            errorMeasureName.textContent = 'MEASURE NAME IS REQUIRED';
        } else if (shortName.value == '') {
            errorShortName.textContent = 'SHORT NAME IS REQUIRED';
        } else {
            const url = base_url + 'Measures/registerMeasures';
            insertRegistry(url, this, tblMeasures, btnRegister, false, '#idMeasure');
        }
    })
})

function deleteMeasure(idMeasure) {
    const url = base_url + 'Measures/delMeasure/' + idMeasure;
    deleteRegistry(url, tblMeasures);
}

function editMeasure(idMeasure) {
    clearErrorFields();
    const url = base_url + 'Measures/modifyMeasures/' + idMeasure;
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

            id.value = res.id;
            measureName.value = res.measure;
            shortName.value = res.short_name;
            btnRegister.textContent = 'Update';
            firstTab.show()
        }
    }
}
function clearErrorFields() {
    errorMeasureName.textContent = '';
    errorShortName.textContent = '';
}