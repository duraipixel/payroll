<div class="modal-dialog modal-dialog-centered mw-900px">
    <!--begin::Modal content-->
    <div class="modal-content">
       
        <div class="modal-body" id="dynamic_content" style="padding:0px;">
            
            <!--begin::Stepper-->
            {!! $content ?? '' !!}
            <!--end::Stepper-->
            <div class="row">
                <div class="col-sm-12 mt-3 text-end">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-dark">Close</button>
                </div>
            </div>
        </div>
        <!--end::Modal body-->
    </div>
    <!--end::Modal content-->
</div>
<script>
    $(document).ready(function() {
        $(window).keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    });
</script>
