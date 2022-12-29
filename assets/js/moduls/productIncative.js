let tblInactiveProducts;
const containerPreview = document.querySelector('#containerPreview');

document.addEventListener('DOMContentLoaded', function () {
    tblInactiveProducts = $('#tblInactiveProducts').DataTable({
        ajax: {
            url: base_url + '/Products/listInactiveProducts',
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
            { data: 'actions' }
        ],
        dom,
        buttons,
        responsive: true,
        order: [[1, 'asc']]
    });

})
//Restore user function
function restoreProduct(idProduct) {
    const url = base_url + 'Products/productRestore/' + idProduct;
    restoreRegistry(url, tblInactiveProducts);
}