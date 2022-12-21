let tblOpenClose, tblExpenseHistory, myChart;

//New expense
const expenseForm = document.querySelector('#expenseForm');
const expenseAmount = document.querySelector('#expenseAmount');
const description = document.querySelector('#description');
const expensePhoto = document.querySelector('#expensePhoto');
const containerPreview = document.querySelector('#containerPreview');
const actualPhoto = document.querySelector('#actualPhoto');
const id = '#id';
const movementGraph = document.querySelector('#movementGraph');

const btnRegisterExpense = document.querySelector('#btnRegisterExpense');


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
                    window.location.reload();
                }
            }
        }
    });
    btnCancel.addEventListener('click', function () {
        modalRegister.hide();
        initialAmount.value = '';
    });
    //verify if the cash register is open
    if (expenseForm && movementGraph) {

        //Load data with the plugin Datatable
        tblOpenClose = $('#tblOpenClose').DataTable({
            ajax: {
                url: base_url + '/CashRegister/listOpenClose',
                dataSrc: ''
            },
            columns: [
                { data: 'initial_amount' },
                { data: 'opening_date' },
                { data: 'closing_date' },
                { data: 'final_amount' },
                { data: 'total_sale' },
                { data: 'name' }
            ],
            dom,
            buttons,
            responsive: true,
            order: [[0, 'asc']]
        })

        //Inicialize the ckeditor5 editor
        ClassicEditor
            .create(document.querySelector('#description'), {
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
            })

        //Register expense
        expenseForm.addEventListener('submit', function (e) {
            e.preventDefault();
            if (expenseAmount.value == '') {
                customAlert('warning', 'EXPENSE IS REQUIRED');
            } else if (description.value == '') {
                customAlert('warning', 'DESCRIPTION IS REQUIRED');
            } else {
                const url = base_url + 'CashRegister/registerExpense';
                insertRegistry(url, this, tblExpenseHistory, btnRegisterExpense, false, id);
                delPreview();
                graphMovement();
                // setTimeout(() => {
                //     window.location.reload();
                // }, 2000);
            }
        })

        //Preview selected photo
        expensePhoto.addEventListener('change', function (e) {
            if (e.target.files[0].type == 'image/png' ||
                e.target.files[0].type == 'image/jpg' ||
                e.target.files[0].type == 'image/jpeg') {

                const url = e.target.files[0];
                const tmpUrl = URL.createObjectURL(url);
                containerPreview.innerHTML = `<img class="img-thumbnail" src="${tmpUrl}" width="200">
                    <button class="btn btn-danger" type="button" onclick="delPreview()"><i class="fas fa-trash"></i></button>`;
            } else {
                expensePhoto.value = '';
                customAlert('warning', 'ONLY JPG, JPEG AND PNG IMAGES ARE ACEPTED')
            }
        })

        //Load data with the plugin Datatable
        tblExpenseHistory = $('#tblExpenseHistory').DataTable({
            ajax: {
                url: base_url + '/CashRegister/listExpenseHistory',
                dataSrc: ''
            },
            columns: [
                { data: 'amount' },
                { data: 'description' },
                { data: 'dates' },
                { data: 'name' },
                { data: 'photo' }
            ],
            dom,
            buttons,
            responsive: true,
            order: [[2, 'asc']]
        })
        graphMovement();
    }
})

function delPreview() {
    expensePhoto.value = '';
    containerPreview.innerHTML = '';
    actualPhoto.value = '';
}

function graphMovement() {

    const url = base_url + 'CashRegister/cashMovement';
    //instaciate the object XMLHttpRequest
    const http = new XMLHttpRequest();
    //open connection this time POST - GET
    http.open('GET', url, true);
    //send data
    http.send();
    //verify status
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            //Just for testing
            //console.log(this.responseText);
            const res = JSON.parse(this.responseText);

            if (myChart) {
                myChart.destroy();
            }

            const ctx = document.getElementById("movementGraph").getContext('2d');

            const gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke1.addColorStop(0, '#008cff');
            gradientStroke1.addColorStop(1, '#008cff');

            const gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke2.addColorStop(0, '#15ca21b0');
            gradientStroke2.addColorStop(1, '#15ca21b0');

            const gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke3.addColorStop(0, '#e61c1c');
            gradientStroke3.addColorStop(1, '#e61c1c');

            const gradientStroke4 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke4.addColorStop(0, '#ddeb21');
            gradientStroke4.addColorStop(1, '#ddeb21');

            const gradientStroke5 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke5.addColorStop(0, '#00ffc873');
            gradientStroke5.addColorStop(1, '#00ffc873');

            const gradientStroke6 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke6.addColorStop(0, '#a6a808');
            gradientStroke6.addColorStop(1, '#a6a808');

            const gradientStroke7 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke7.addColorStop(0, '#c720b1');
            gradientStroke7.addColorStop(1, '#c720b1');

            myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ["Initial Amount", "Income", "Expenses", "Discounts", "Outcome", "Credits", "Balance"],
                    datasets: [{
                        backgroundColor: [
                            gradientStroke1,
                            gradientStroke2,
                            gradientStroke3,
                            gradientStroke4,
                            gradientStroke5,
                            gradientStroke6,
                            gradientStroke7
                        ],

                        hoverBackgroundColor: [
                            gradientStroke1,
                            gradientStroke2,
                            gradientStroke3,
                            gradientStroke4,
                            gradientStroke5,
                            gradientStroke6,
                            gradientStroke7
                        ],

                        data: [res.initialAmount, res.income, res.expenses, res.discount, res.outcome, res.credits, res.balance],
                        borderWidth: [1, 1, 1, 1, 1, 1, 1]
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    cutoutPercentage: 0,
                    legend: {
                        position: 'bottom',
                        display: false,
                        labels: {
                            boxWidth: 8
                        }
                    },
                    tooltips: {
                        displayColors: false,
                    },
                }
            });

            let html = `<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                    <div><i class="fas fa-key"></i> Initial Amount </div> <span class="badge bg-graph1 rounded-pill" style="color: black; font-size: 15px;">${res.currency + res.initialAmountDecimal}</span>
                </li>
                <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                    <div><i class="fas fa-arrow-up"></i> Income </div> <span class="badge bg-graph2 rounded-pill" style="color: black; font-size: 15px;">${res.currency + res.incomeDecimal}</span>
                </li>
                <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                    <div><i class="fas fa-hand-holding-dollar"></i> Expenses </div> <span class="badge bg-graph3 rounded-pill" style="color: black; font-size: 15px;">${res.currency + res.expensesDecimal}</span>
                </li>
                <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                    <div><i class="fas fa-circle-dollar-to-slot"></i> Discount </div> <span class="badge bg-graph4 rounded-pill" style="color: black; font-size: 15px;">${res.currency + res.discountDecimal}</span>
                </li>
                <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                    <div><i class="fas fa-arrow-down"></i> Outcome </div> <span class="badge bg-graph5 rounded-pill" style="color: black; font-size: 15px;">${res.currency + res.outcomeDecimal}</span>
                </li>
                <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                    <div><i class="fas fa-credit-card"></i> Credits </div> <span class="badge bg-graph6 rounded-pill" style="color: black; font-size: 15px;">${res.currency + res.creditsDecimal}</span>
                </li>
                <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                    <div><i class="fas fa-dollar-sign"></i> Balance </div> <span class="badge bg-graph7 rounded-pill" style="color: black; font-size: 15px;">${res.currency + res.balanceDecimal}</span>
                </li>`;
            document.querySelector('#listMoveGraph').innerHTML = html;

        }
    }

}