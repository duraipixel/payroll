<link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


<style>
    div#wizard {
        position: relative;
    }

    div#staff-loading {
        position: fixed;
        top: 0;
        background-color: #f5f8facc;
        width: 100%;
        height: 100%;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .swal2-popup.swal2-modal.swal2-icon-warning.swal2-show {
        background: white;
    }

    .swal2-popup.swal2-modal.swal2-icon-success.swal2-show {
        background: white;
    }

    .swal2-success-line-tip {
        background: green !important;
    }

    .swal2-success-line-long {
        background: green !important;
    }

    .toastr.toastr-error {
        background:red;
        
    }
    #toastr-container > div {
        opacity: 1;
    }
</style>
