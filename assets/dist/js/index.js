$(document).ready(() => {
    $('#myTable').DataTable({
        "lengthChange": false,
    });

    // action ketika menghapus data
    $('#table tbody').on('click', '.btnHapus', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                document.location.href = href;
            }
        })
    });

    // action ketika reset password
    $('#table tbody').on('click', '.btnReset', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');

        Swal.fire({
            title: 'Reset password ?',
            text: "Default password : lsphcmi2020",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, reset it!'
        }).then((result) => {
            if (result.value) {
                document.location.href = href;
            }
        })
    });

    // Alert 
    const message = $('.flash-data').data('tempdata');
    const error   = $('.flash-data-error').data('tempdata');
    const info    = $('.flash-data-info').data('tempdata');
    const confirm = $('.flash-data-confirm').data('tempdata');

    // for Error message
    if (error) {
        Swal.fire({
            title: 'Oops...',
            text: error,
            icon: 'error'
        });
    }
    // for success message
    else if(message) {
        Swal.fire({
            title: 'Success',
            text: message,
            icon: 'success'
        });
    // for Info message
    }else if(info) {
        Swal.fire({
            title: 'Info',
            text: info,
            icon: 'info'
        });
    // for download template 
    }else if(confirm) {
        Swal.fire({
            title: 'Success',
            text: confirm,
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: '<a href="http://localhost/lsp_archive/admin/suratkeluar/getTemplate" style="text-decoration: none; color:white;" target="_blank">Download Template</a>'
        })
    }else {
        
    }

    // session logout
    let log = new Date();
    log.setSeconds(log.getSeconds() + 1200);
    log = new Date(log);

    let int_log = setInterval(()=>{
        let now = new Date();
        if (now > log){
            location.href = "http://localhost/lsp_archive/admin/auth";
            clearInterval(int_log);
        }
    }, 1200000);

});