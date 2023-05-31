<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Amalarpavam</title>

    <style>
        .userimg {
            float: right:
        }

        .userimg img {
            height: 100px
        }

        .signature img {
            height: 50px
        }
    </style>
</head>



<body class="form-page" data-new-gr-c-s-check-loaded="8.904.0" data-gr-ext-installed="">

    <table style="font-family: arial, sans-serif;border-collapse: collapse;" width="100%">
        <tbody>
            <tr style="border: 2px solid #c3c3c3;background: #1b488c;">
                <td>
                    <img src="{{ asset('assets/media/logos/user-logo.png') }}" style="height:90px;">
                </td>
                <td style="width:1%;">
                    <div class="userimg">
                        @if( isset( $user->image ) && !empty( $user->image ) )
                        @php
                            $path = Storage::url($user->image);
                        @endphp
                            <img src="{{ asset('public'.$path) }}">

                        @else 
                        <img src="https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg">
                        @endif
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="height:10px;"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="font-size: 20px;font-weight:bold;text-align:center;">Amalorpavam Educational Welfare
                        Soceity</div>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="height:10px;"></div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="font-family: arial, sans-serif;border-collapse: collapse;" width="100%" cellpadding="5">
        <tbody>
            <!-- -------------------------------------------------------------- !-->
            @include('pages.overview.print_view._personal')
            <!-- -------------------------------------------------------------- !-->
            <tr>
                <td height="10px"></td>
            </tr>
            @include('pages.overview.print_view._basic')
            <!-- -------------------------------------------------------------- !-->
            <tr>
                <td height="10px"></td>
            </tr>
            @include('pages.overview.print_view._position')
            <!-- -------------------------------------------------------------- !-->
        </tbody>
    </table>


    <div style="page-break-before:always">&nbsp;</div>

    @include('pages.overview.print_view._education')

    <table style="font-family: arial, sans-serif;border-collapse: collapse;" width="100%" cellpadding="5">
        <tbody>
            @include('pages.overview.print_view._language')
            @include('pages.overview.print_view._others')
        </tbody>
    </table>
    <!-- -------------------------------------------------------------- !-->
    <div style="page-break-before:always">&nbsp;</div>
    @include('pages.overview.print_view._family')
    {{-- @include('pages.overview.print_view._family_others') --}}
    @include('pages.overview.print_view._aews')
    @include('pages.overview.print_view._nominee')
    @include('pages.overview.print_view._relation_working')

    {{-- <div style="page-break-before:always">&nbsp;</div> --}}

    @include('pages.overview.print_view._medical')

    {{-- <div style="page-break-before:always">&nbsp;</div> --}}

    @include('pages.overview.print_view._appointment')
    <!-- -------------------------------------------------------------- !-->
    {{-- <div style="page-break-before:always">&nbsp;</div> --}}
</body>
<grammarly-desktop-integration data-grammarly-shadow-root="true"></grammarly-desktop-integration>
</html>
