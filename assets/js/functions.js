const firstTabEl = document.querySelector('#nav-tab button:last-child')
const firstTab = new bootstrap.Tab(firstTabEl)

function cleanFields() {
    id.value = '';
    btnAction.textContent = 'Register';
    newForm.reset();
}

function insertRegistry(url, idForm, dataTbl, idButton, action, idUsed) {
    //create formData 
    const data = new FormData(idForm);
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
            Swal.fire({
                toast: true,
                position: 'top-right',
                icon: res.type,
                title: res.msg,
                showConfirmButton: false,
                timer: 2000
            })
            if (res.type == 'success') {
                if (action) {
                    password.removeAttribute('readonly');
                }
                if (dataTbl != null) {
                    document.querySelector(idUsed).value = '';
                    idButton.textContent = 'Register';
                    containerPreview.innerHTML = '';
                    idForm.reset();                
                    dataTbl.ajax.reload();
                }
            }
        }
    }
}

function deleteRegistry(url, dataTbl) {
    Swal.fire({
        title: 'Are you sure you want to delete?',
        text: "Won't be deleted permanetly, only the status change to inactive.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {            
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
                    Swal.fire({
                        toast: true,
                        position: 'top-right',
                        icon: res.type,
                        title: res.msg,
                        showConfirmButton: false,
                        timer: 2000
                    })
                    if (res.type == 'success') {
                        dataTbl.ajax.reload();
                    }
                }
            }
        }
    }) 
}

function restoreRegistry(url, dataTbl) {
    Swal.fire({
        title: 'Are you sure you want to restore?',
        text: "The status will change to active.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, restored!'
    }).then((result) => {
        if (result.isConfirmed) {
            
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
                    Swal.fire({
                        toast: true,
                        position: 'top-right',
                        icon: res.type,
                        title: res.msg,
                        showConfirmButton: false,
                        timer: 2000
                    })
                    if (res.type == 'success') {
                        dataTbl.ajax.reload();
                    }
                }
            }
        }
    })
}

function customAlert(type, msg) {
    Swal.fire({
        toast: true,
        position: 'top-right',
        icon: type,
        title: msg,
        showConfirmButton: false,
        timer: 2000
    })  
}