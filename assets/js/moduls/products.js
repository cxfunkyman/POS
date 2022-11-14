let tblProducts;
const productForm = document.querySelector('#productForm');
const btnPRegister = document.querySelector('#btnPRegister');
const btnPNew = document.querySelector('#btnPNew');

const id = document.querySelector('#idProduct');
const p_Code = document.querySelector('#p_Code');
const p_Description = document.querySelector('#p_Description');
const p_Price = document.querySelector('#p_Price');
const s_Price = document.querySelector('#s_Price');
const p_Measure = document.querySelector('#p_Measure');
const p_Category = document.querySelector('#p_Category');
const p_Photo = document.querySelector('#p_Photo');
const actualPhoto = document.querySelector('#actualPhoto');
const containerPreview = document.querySelector('#containerPreview');

const errorP_Code = document.querySelector('#errorP_Code');
const errorP_Description = document.querySelector('#errorP_Description');
const errorP_Price = document.querySelector('#errorP_Price');
const errorS_Price = document.querySelector('#errorS_Price');
const errorP_Measure = document.querySelector('#errorP_Measure');
const errorP_Category = document.querySelector('#errorP_Category');

document.addEventListener('DOMContentLoaded', function () {
    //Load data with the plugin Datatable
    tblProducts = $('#tblProducts').DataTable({
        ajax: {
            url: base_url + '/Products/listProducts',
            dataSrc: ''
        },
        columns: [
            { data: 'code' },
            { data: 'description' },
            { data: 'purchase_price' },
            { data: 'sale_price' },
            { data: 'quantity' },
            { data: 'measure' },
            { data: 'category' },
            { data: 'photo' },
            { data: 'actions' }
        ],
        dom,
        buttons,
        responsive: true,
        order: [[1, 'asc']]
    });
    //Preview selected photo
    p_Photo.addEventListener('change', function (e) {
        if (e.target.files[0].type == 'image/png' ||
            e.target.files[0].type == 'image/jpg' ||
            e.target.files[0].type == 'image/jpeg') {

            const url = e.target.files[0];
            const tmpUrl = URL.createObjectURL(url);
            containerPreview.innerHTML = `<img class="img-thumbnail" src="${tmpUrl}" width="200">
                <button class="btn btn-danger" type="button" onclick="delPreview()"><i class="fas fa-trash"></i></button>`;
        } else {
            p_Photo.value = '';
            customAlert('warning', 'ONLY JPG, JPEG AND PNG IMAGES ARE ACEPTED')
        }
    })
    btnPNew.addEventListener('click', function () {
        id.value = '';
        btnPRegister.textContent = 'Register';
        delPreview();
        productForm.reset();
        
    })
    //Send products data
    productForm.addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrorFields();

        if (p_Code.value == '') {
            errorP_Code.textContent = 'CODE REQUIRED';
        } else if (p_Description.value == '') {
            errorP_Description.textContent = 'PRODUCT NAME REQUIRED';
        } else if (p_Price.value == '') {
            errorP_Price.textContent = 'PURCHASE PRICE REQUIRED';
        } else if (s_Price.value == '') {
            errorS_Price.textContent = 'SALE PRICE REQUIRED';
        } else if (p_Measure.value == '') {
            errorP_Measure.textContent = 'MEASURE REQUIRED';
        } else if (p_Category.value == '') {
            errorP_Category.textContent = 'CATEGORY REQUIRED';
        } else {
            const url = base_url + 'Products/registerProducts';
            insertRegistry(url, this, tblProducts, btnPRegister, false, '#idProduct');
            delPreview();
        }
    })

})
function delPreview() {
    p_Photo.value = '';
    containerPreview.innerHTML = '';
    actualPhoto.value = '';
}

function deleteProduct(idProduct) {
    const url = base_url + 'Products/delProduct/' + idProduct;
    deleteRegistry(url, tblProducts);
}

function editProduct(idProduct) {
    clearErrorFields();
    const url = base_url + 'Products/modifyProducts/' + idProduct;
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
            p_Code.value = res.code;
            p_Description.value = res.description;
            p_Price.value = res.purchase_price;
            s_Price.value = res.sale_price;
            p_Measure.value = res.id_measure;
            p_Category.value = res.id_category;
            actualPhoto.value = res.photo;
            containerPreview.innerHTML = `<img class="img-thumbnail" src="${base_url + res.photo}" width="200">
            <button class="btn btn-danger" type="button" onclick="delPreview()"><i class="fas fa-trash"></i></button>`;

            btnPRegister.textContent = 'Update';
            firstTab.show();
            
        }
    }
}
function clearErrorFields() {

    errorP_Code.textContent = '';
    errorP_Description.textContent = '';
    errorP_Price.textContent = '';
    errorS_Price.textContent = '';
    errorP_Measure.textContent = '';
    errorP_Category.textContent = '';
}