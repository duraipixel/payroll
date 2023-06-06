<style>
    .modal{
    display: block !important; /* I added this to see the modal, you don't need this */
}

/* Important part */
.modal-dialog{
    overflow-y: initial !important
}
.modal-body{
    height: 90vh;
    overflow-y: auto;
}
    </style>
<div class="row" >
    {!! $info->document !!}
</div>