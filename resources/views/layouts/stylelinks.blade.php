<link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/developer.css') }}" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/solid.min.css" integrity="sha512-6/gTF62BJ06BajySRzTm7i8N2ZZ6StspU9uVWDdoBiuuNu5rs1a8VwiJ7skCz2BcvhpipLKfFerXkuzs+npeKA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
        background: red;

    }

    #toastr-container>div {
        opacity: 1;
    }

    .text-small {
        font-size: 10px;
    }

    div.dataTables_length+div.dataTables_info {
        margin-left: 6rem;
    }
</style>
