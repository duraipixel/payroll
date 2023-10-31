<div id="kt_customer_details_invoices_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
    <div class="row g-6 g-xl-9">
        <div class="col-lg-6 col-xxl-4">
            <div class="card h-100 cstmzed">
                @include('pages.overview.overview.total_working_day')
            </div>
        </div>
        <div class="col-lg-6 col-xxl-4">
            <div class="card h-100 cstmzed">
                @include('pages.overview.overview.total_leaves')
            </div>
        </div>
      
        <div class="col-xl-6 mb-5 mb-xl-10">
            @include('pages.overview.overview.languages')
        </div>
        @foreach($loans as $loan)
          <div class="col-lg-6 col-xxl-4">
            @include('pages.overview.overview.total_loan')
        </div>
         @endforeach
        <br>
    </div>
</div>