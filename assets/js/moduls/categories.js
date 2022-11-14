let tblCategories;
const categoryForm = document.querySelector('#categoryForm');
const categoryName = document.querySelector('#categoryName');
const btnCRegister = document.querySelector('#btnCRegister');
const btnCNew = document.querySelector('#btnCNew');
const id = document.querySelector('#idCategory');
const errorCategoryName = document.querySelector('#errorCategoryName');

document.addEventListener('DOMContentLoaded', function () {
    //Load data with the plugin Datatable
    tblCategories = $('#tblCategories').DataTable({
        ajax: {
            url: base_url + '/Categories/listCategories',
            dataSrc: ''
        },
        columns: [
            { data: 'category' },
            { data: 'dates' },
            { data: 'actions' }
        ],
        dom,
        buttons,
        responsive: true,
        order: [[0, 'asc']]
    });
    btnCNew.addEventListener('click', function () {
        id.value = '';
        btnCRegister.textContent = 'Register';
        categoryForm.reset();
    })
        //Send categories data
        categoryForm.addEventListener('submit', function (e) {
            e.preventDefault();
            clearErrorFields();
                
            if (categoryName.value == '') {
                errorCategoryName.textContent = 'CATEGORY NAME IS REQUIRED';
            } else {
                const url = base_url + 'Categories/registerCategories';
                insertRegistry(url, this, tblCategories, btnCRegister, false, '#idCategory');
            }
        })
})

function deleteCategory(idCategory) {
    const url = base_url + 'Categories/delCategory/' + idCategory;
    deleteRegistry(url, tblCategories);
}

function editCategory(idCategory) {
    clearErrorFields();
    const url = base_url + 'Categories/modifyCategories/' + idCategory;
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
            categoryName.value = res.category;
            btnCRegister.textContent = 'Update';
            firstTab.show()
        }
    }
}
function clearErrorFields() {
    errorCategoryName.textContent = '';
}

