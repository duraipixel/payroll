 <!--begin::Navbar-->
 @extends('layouts.template')
 @section('content')

 @endsection

@section('add_on_script')
<!--begin::Page Vendors Javascript(used by this page)-->
<script src="{{ asset('assets/js/plugins/datatables.bundle.js') }}"></script>
<!--end::Page Vendors Javascript-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{ asset('assets/js/lists/list-1.js') }}"></script>
<script src="{{ asset('assets/js/lists/list-2.js') }}"></script>
<script src="{{ asset('assets/js/custom/widgets.bundle.js') }}"></script>
<script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
<script src="{{ asset('assets/js/custom/chat.js') }}"></script>
<script src="{{ asset('assets/js/custom/intro.js') }}"></script>
<script src="{{ asset('assets/js/modals/upgrade-plan.js') }}"></script>
<script src="{{ asset('assets/js/modals/create-app.js') }}"></script>
<script src="{{ asset('assets/js/modals/type.js') }}"></script>
<script src="{{ asset('assets/js/modals/details.js') }}"></script>
<script src="{{ asset('assets/js/modals/finance.js') }}"></script>
<script src="{{ asset('assets/js/modals/complete.js') }}"></script>
<script src="{{ asset('assets/js/modals/main.js') }}"></script>
<script src="{{ asset('assets/js/modals/users-search.js') }}"></script>
@endsection