let tblLogs;
const btnClearData = document.querySelector('#btnClearData');

document.addEventListener('DOMContentLoaded', function() {
        //Load data with the plugin Datatable
        tblLogs = $('#tblLogs').DataTable({
            ajax: {
                url: base_url + 'admin/listLogs',
                dataSrc: ''
            },
            columns: [
                { data: 'event' },
                { data: 'ip' },
                { data: 'details' },
                { data: 'dates' },
                { data: 'name' }
            ],
            dom,
            buttons,
            responsive: true,
            order: [[2, 'asc']]
        });
        btnClearData.addEventListener('click', function() {
            Swal.fire({
                title: 'Are you sure you want to delete all logs?',
                text: "All access log will be deleted permanetly.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {   
                    const url = base_url + 'admin/clearLogs';         
                    //instaciate the object XMLHttpRequest
                    const http = new XMLHttpRequest();
                    //open connection this time POST
                    http.open('GET', url, true);
                    //send data
                    http.send();
                    //verify status
                    http.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            //Just for testing
                            // console.log(this.responseText);
                            // return;
                            const res = JSON.parse(this.responseText);
                            customAlert(res.type, res.msg, 3500)
                            if (res.type == 'success') {
                                tblLogs.ajax.reload();
                            }
                        }
                    }
                }
            }) 
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