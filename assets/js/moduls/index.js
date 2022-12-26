
let spChart, ccdChart, tpChart, exChart, smChart, rsChart;

salesAndPurchases();
cashCreditsDiscounts();
topProductGraph();
expenseGraph();
stockMinimum();
reservesSummary();

function salesAndPurchases() {
  if (spChart) {
    spChart.destroy();
  }
  const yearSP = document.querySelector('#yearSP').value;

  const url = base_url + 'admin/salesAndPurchases/' + yearSP;
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

      // chart Sales & Purchases

      document.querySelector('#totalSale').textContent = "$ " + res.totalSalesDecimal;
      document.querySelector('#totalPurchase').textContent = "$ " + res.totalPurchasesDecimal;

      var ctx = document.getElementById("salesAndPurchases").getContext('2d');

      var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke1.addColorStop(0, '#18caca');
      gradientStroke1.addColorStop(1, '#90f4f4');

      var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke2.addColorStop(0, '#aa1818');
      gradientStroke2.addColorStop(1, '#e55353');

      spChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          datasets: [{
            label: 'Sales',
            data: [res.sales.ene, res.sales.feb, res.sales.mar, res.sales.abr, res.sales.may, res.sales.jun, res.sales.jul, res.sales.aug, res.sales.sep, res.sales.oct, res.sales.nov, res.sales.dic],
            borderColor: gradientStroke1,
            backgroundColor: gradientStroke1,
            hoverBackgroundColor: gradientStroke1,
            pointRadius: 0,
            fill: false,
            borderWidth: 0
          }, {
            label: 'Purchases',
            data: [res.purchases.ene, res.purchases.feb, res.purchases.mar, res.purchases.abr, res.purchases.may, res.purchases.jun, res.purchases.jul, res.purchases.aug, res.purchases.sep, res.purchases.oct, res.purchases.nov, res.purchases.dic],
            borderColor: gradientStroke2,
            backgroundColor: gradientStroke2,
            hoverBackgroundColor: gradientStroke2,
            pointRadius: 0,
            fill: false,
            borderWidth: 0
          }]
        },

        options: {
          maintainAspectRatio: false,
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
          scales: {
            xAxes: [{
              barPercentage: .5
            }]
          }
        }
      });
    }
  }
}
function cashCreditsDiscounts() {
  if (ccdChart) {
    ccdChart.destroy();
  }
  const yearCDD = document.querySelector('#yearCCD').value;
  // chart 1
  const url = base_url + 'admin/cashCreditsDiscount/' + yearCDD;
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

      // chart Cash & Credits & Discounts

      document.querySelector('#saleCash').textContent = "$ " + res.totalCashDecimal;
      document.querySelector('#saleCredit').textContent = "$ " + res.totalCreditDecimal;
      document.querySelector('#saleDiscount').textContent = "$ " + res.totalDiscountDecimal;

      var ctx = document.getElementById("cashAndCredits").getContext('2d');

      var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke1.addColorStop(0, '#d89411');
      gradientStroke1.addColorStop(1, '#f9c96d');

      var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke2.addColorStop(0, '#161aef');
      gradientStroke2.addColorStop(1, '#787bfa');

      var gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke3.addColorStop(0, '#b615a3');
      gradientStroke3.addColorStop(1, '#e551d3');

      ccdChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          datasets: [{
            label: 'Cash',
            data: [res.cash.ene, res.cash.feb, res.cash.mar, res.cash.abr, res.cash.may, res.cash.jun, res.cash.jul, res.cash.aug, res.cash.sep, res.cash.oct, res.cash.nov, res.cash.dic],
            borderColor: gradientStroke1,
            backgroundColor: gradientStroke1,
            hoverBackgroundColor: gradientStroke1,
            pointRadius: 0,
            fill: false,
            borderWidth: 0
          }, {
            label: 'Credit',
            data: [res.credit.ene, res.credit.feb, res.credit.mar, res.credit.abr, res.credit.may, res.credit.jun, res.credit.jul, res.credit.aug, res.credit.sep, res.credit.oct, res.credit.nov, res.credit.dic],
            borderColor: gradientStroke2,
            backgroundColor: gradientStroke2,
            hoverBackgroundColor: gradientStroke2,
            pointRadius: 0,
            fill: false,
            borderWidth: 0
          }, {
            label: 'Discount',
            data: [res.discount.ene, res.discount.feb, res.discount.mar, res.discount.abr, res.discount.may, res.discount.jun, res.discount.jul, res.discount.aug, res.discount.sep, res.discount.oct, res.discount.nov, res.discount.dic],
            borderColor: gradientStroke3,
            backgroundColor: gradientStroke3,
            hoverBackgroundColor: gradientStroke3,
            pointRadius: 0,
            fill: false,
            borderWidth: 0
          }]
        },

        options: {
          maintainAspectRatio: false,
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
          scales: {
            xAxes: [{
              barPercentage: .5
            }]
          }
        }
      });
    }
  }
}
function topProductGraph() {
  if (tpChart) {
    tpChart.destroy();
  }

  const url = base_url + 'admin/topProductsGraph/';
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

      // chart Top 5 Products

      var ctx = document.getElementById("topProducts").getContext('2d');

      var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke1.addColorStop(0, '#17a00e');
      gradientStroke1.addColorStop(1, '#50c948');

      var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke2.addColorStop(0, '#0bb2d3');
      gradientStroke2.addColorStop(1, '#88d8e8');


      var gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke3.addColorStop(0, '#008cff');
      gradientStroke3.addColorStop(1, '#73bbf5');

      var gradientStroke4 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke4.addColorStop(0, '#ffc107');
      gradientStroke4.addColorStop(1, '#f7d87b');

      var gradientStroke5 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke5.addColorStop(0, '#f41127');
      gradientStroke5.addColorStop(1, '#f08691');

      let name = [];
      let quantity = [];

      for (const element of res) {
        name.push(element.description);
        quantity.push(element.sales);
      }

      tpChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: name,
          datasets: [{
            backgroundColor: [
              gradientStroke1,
              gradientStroke2,
              gradientStroke3,
              gradientStroke4,
              gradientStroke5
            ],
            hoverBackgroundColor: [
              gradientStroke1,
              gradientStroke2,
              gradientStroke3,
              gradientStroke4,
              gradientStroke5
            ],
            data: quantity,
            borderWidth: [1, 1, 1, 1, 1]
          }]
        },
        options: {
          maintainAspectRatio: false,
          cutoutPercentage: 75,
          legend: {
            position: 'bottom',
            display: false,
            labels: {
              boxWidth: 8
            }
          },
          tooltips: {
            displayColors: false,
          }
        }
      });
    }
  }
}
function expenseGraph() {
  if (exChart) {
    exChart.destroy();
  }
  const yearEX = document.querySelector('#yearEX').value;

  const url = base_url + 'admin/expenses/' + yearEX;
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

      document.querySelector('#expenseTotal').textContent = "Year Total Expense $ " + res.totalExpensesDecimal;

      // chart Monthly Expenses

      var ctx = document.getElementById('expenses').getContext('2d');

      var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke1.addColorStop(0, '#008cff');
      gradientStroke1.addColorStop(1, 'rgba(22, 195, 233, 0.1)');

      exChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          datasets: [{
            label: 'Expenses',
            data: [res.expenses.jan, res.expenses.feb, res.expenses.mar, res.expenses.apr, res.expenses.may, res.expenses.jun, res.expenses.jul, res.expenses.aug, res.expenses.sep, res.expenses.oct, res.expenses.nov, res.expenses.dic],
            pointBorderWidth: 2,
            pointHoverBackgroundColor: gradientStroke1,
            backgroundColor: gradientStroke1,
            borderColor: gradientStroke1,
            borderWidth: 3
          }]
        },
        options: {
          maintainAspectRatio: false,
          legend: {
            position: 'bottom',
            display: false
          },
          tooltips: {
            displayColors: false,
            mode: 'nearest',
            intersect: false,
            position: 'nearest',
            xPadding: 10,
            yPadding: 10,
            caretPadding: 10
          }
        }
      });
    }
  }
}
function stockMinimum() {
  if (smChart) {
    smChart.destroy();
  }

  const url = base_url + 'admin/minimumStock/';
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

      // chart 5 Products With Minimum Stock

      var ctx = document.getElementById("minStock").getContext('2d');

      var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke1.addColorStop(0, '#17a00e');
      gradientStroke1.addColorStop(1, '#50c948');

      var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke2.addColorStop(0, '#0bb2d3');
      gradientStroke2.addColorStop(1, '#88d8e8');


      var gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke3.addColorStop(0, '#008cff');
      gradientStroke3.addColorStop(1, '#73bbf5');

      var gradientStroke4 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke4.addColorStop(0, '#ffc107');
      gradientStroke4.addColorStop(1, '#f7d87b');

      var gradientStroke5 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke5.addColorStop(0, '#f41127');
      gradientStroke5.addColorStop(1, '#f08691');

      let name = [];
      let quantity = [];

      for (const element of res) {
        name.push(element.description);
        quantity.push(element.quantity);
      }

      smChart = new Chart(ctx, {
        type: 'pie',
        data: {
          labels: name,
          datasets: [{
            backgroundColor: [
              gradientStroke1,
              gradientStroke2,
              gradientStroke3,
              gradientStroke4,
              gradientStroke5
            ],
            hoverBackgroundColor: [
              gradientStroke1,
              gradientStroke2,
              gradientStroke3,
              gradientStroke4,
              gradientStroke5
            ],
            data: quantity,
            borderWidth: [1, 1, 1, 1, 1]
          }]
        },
        options: {
          maintainAspectRatio: false,
          cutoutPercentage: 75,
          legend: {
            position: 'bottom',
            display: false,
            labels: {
              boxWidth: 8
            }
          },
          tooltips: {
            displayColors: false,
          }
        }
      });
    }
  }
}
function reservesSummary() {
  if (rsChart) {
    rsChart.destroy();
  }
  const yearRS = document.querySelector('#yearRS').value;

  const url = base_url + 'admin/reserves/' + yearRS;
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

      document.querySelector('#compRS').textContent = res.completed.total;
      document.querySelector('#pendRS').textContent = res.pending.total;
      document.querySelector('#cancRS').textContent = res.cancelled.total;

      // Chart Reserves Summary

      var ctx = document.getElementById("reserveSummary").getContext('2d');

      var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke1.addColorStop(0, '#17a00e');
      gradientStroke1.addColorStop(1, '#50c948');

      var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke2.addColorStop(0, '#008cff');
      gradientStroke2.addColorStop(1, '#73bbf5');

      var gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke3.addColorStop(0, '#f41127');
      gradientStroke3.addColorStop(1, '#f08691');

      rsChart = new Chart(ctx, {
        type: 'pie',
        data: {
          labels: ["Completed", "Pending", "Cancelled"],
          datasets: [{
            backgroundColor: [
              gradientStroke1,
              gradientStroke2,
              gradientStroke3
            ],

            hoverBackgroundColor: [
              gradientStroke1,
              gradientStroke2,
              gradientStroke3
            ],

            data: [res.completed.total, res.pending.total, res.cancelled.total],
            borderWidth: [1, 1, 1]
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
    }
  }
}
//Reserves Report

// document.addEventListener('DOMContentLoaded', function () {
//   //complete the Sale
//   btnComplete.addEventListener('click', function () {

//       const cartListRow = document.querySelectorAll('#tblSale tr').length;
//       // for test only
//       // console.log(cartListRow);
//       // return;
//       if (cartListRow < 2) {
//           customAlert('warning', 'CART EMPTY');
//       } else if (idClient.value == '' &&
//           phoneClient.value == '' &&
//           nameClient.value == ''
//       ) {
//           customAlert('warning', 'CLIENT REQUIRED');
//       } else if (payMethod.value == '') {
//           customAlert('warning', 'PAYMENT METHOD REQUIRED');
//       } else {
//           const url = base_url + 'Sales/registerSale/';
//           //instaciate the object XMLHttpRequest
//           const http = new XMLHttpRequest();
//           //open connection this time POST
//           http.open('POST', url, true);
//           //send data
//           http.send(JSON.stringify({
//               products: cartList,
//               idClient: idClient.value,
//               payMethod: payMethod.value,
//               discount: discount.value,
//               optionPrinter: directPrint.checked
//           }));
//           //generarte ticket or invoice alert
//           http.onreadystatechange = function () {
//               if (this.readyState == 4 && this.status == 200) {
//                   const res = JSON.parse(this.responseText);
//                   //for test
//                   //console.log(this.responseText);
//                   customAlert(res.type, res.msg);
//                   if (res.msg == 'CASH REGISTER IS CLOSE') {
//                       setTimeout(() => {
//                           localStorage.removeItem(cartKey);
//                           window.location.reload();
//                       }, 2000);
//                   } else {
//                       if (res.type == 'success') {
//                           localStorage.removeItem(cartKey);
//                           setTimeout(() => {
//                               Swal.fire({
//                                   title: 'Do you want to generate an invoice?',
//                                   showDenyButton: true,
//                                   showCancelButton: true,
//                                   confirmButtonText: 'Ticket',
//                                   denyButtonText: `Invoice`,
//                               }).then((result) => {
//                                   /* Read more about isConfirmed, isDenied below */
//                                   if (result.isConfirmed) {
//                                       const route = base_url + 'sales/reports/tickets/' + res.idSale;
//                                       window.open(route, '_blank');
//                                   } else if (result.isDenied) {
//                                       const route = base_url + 'sales/reports/invoice/' + res.idSale;
//                                       window.open(route, '_blank');
//                                   }
//                                   window.location.reload();
//                               })
//                           }, 2000);
//                       }
//                   }
//               }
//           }
//       }
//   })
// })