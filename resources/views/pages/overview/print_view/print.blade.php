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

        .common-table td {
            text-transform: uppercase
        }
    </style>
</head>



<body class="form-page" data-new-gr-c-s-check-loaded="8.904.0" data-gr-ext-installed="">

    <table style="font-family: arial, sans-serif;border-collapse: collapse;" width="100%">
        <tbody>
            <tr style="border: 2px solid #c3c3c3;background: #1b488c;">
                <td style="width: 1%">
                    {{-- <img src="{{ asset('assets/media/logos/user-logo.png') }}" style="height:90px;"> --}}
                </td>
                <td style="width: 50%">
                    <div style="font-size: 20px;font-weight:bold;text-align:center;color:white">Amalorpavam Educational
                        Welfare
                        Soceity</div>
                </td>
                <td style="width:1%;">
                    <div class="userimg">
                        @if (isset($user->image) && !empty($user->image))
                            @php
                                $path = Storage::url($user->image);
                            @endphp
                            <img src="{{ asset('public' . $path) }}">
                        @else
                            <img
                                src="https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg">
                        @endif
                    </div>
                </td>
            </tr>
            {{-- <tr>
                <td>
                    <div style="height:10px;"></div>
                </td>
            </tr> --}}
            {{-- <tr>
                <td>
                    <div style="font-size: 20px;font-weight:bold;text-align:center;">Amalorpavam Educational Welfare
                        Soceity</div>
                </td>
            </tr> --}}
            <tr>
                <td>
                    <div style="height:1px;"></div>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="common-table" style="font-family: arial, sans-serif;border-collapse: collapse;" width="100%"
        cellpadding="5">
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

    <table id="studied_table"  class="common-table" style="font-family: arial, sans-serif;border-collapse: collapse;" width="100%"
    cellpadding="5">
    
        <thead>
            <tr style="background-color: #1b488c;-webkit-print-color-adjust: exact;">
                <td colspan="{{ count($classes)+1 }}"
                    style="border: 1px solid #1b488c;color:#fff;font-weight:bold;font-size:15px;vertical-align: middle;height:0px;">
                    Employee Handling Subjects
                </td>
            </tr>
            <tr class="fw-bolder text-muted" style="background-color: #ddd;-webkit-print-color-adjust: exact;">
                <th class="" style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">Subjects</th>
                @if( isset($class_details) && count($class_details) > 0 )
                    @foreach ($class_details as $item)
                        <th style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:center;font-size: 12px;" id="{{ $item->id }}">
                            {{ $item->name }}</th>
                    @endforeach
                @endisset
            </tr>
        </thead>
     
        <tbody>
            @if( isset($subject_details) && count($subject_details) > 0 )
                @foreach ($subject_details as $items)
                <tr>
                    <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;font-weight:bold">
                        {{ $items->name ?? '' }}
                    </td>
                   
                    @if( isset($class_details) && count($class_details) > 0 )
                        @foreach ($class_details as $item)
                        <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;font-size: 12px;text-align:center">
                            @if( isset($user->id) && getHandlingSubjects( $user->id, $items->id, $item->id )) 
                                Yes
                            @else
                            -
                            @endif
                        </td>
                        @endforeach
                    @endif
                </tr>
                @endforeach
            @endif
        </tbody>
        
    </table>
    
   
    <table id="studied_table"  class="common-table" style="font-family: arial, sans-serif;border-collapse: collapse;" width="100%"
    cellpadding="5">
    
        <thead>
            <tr style="background-color: #1b488c;-webkit-print-color-adjust: exact;">
                <td colspan="{{ count($classes)+1 }}"
                    style="border: 1px solid #1b488c;color:#fff;font-weight:bold;font-size:15px;vertical-align: middle;height:0px;">
                    Employee Studied Subjects
                </td>
            </tr>
            <tr class="fw-bolder text-muted" style="background-color: #ddd;-webkit-print-color-adjust: exact;">
                <th class="" style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;width: 10%;font-size: 12px;">Subjects</th>
                @isset($classes)
                    @foreach ($classes as $item)
                        <th style="border: 1px solid #c3c3c3;color:#333;font-weight:bold;height:0px;text-align:left;font-size: 12px;" id="{{ $item->id }}">
                            {{ $item->name }}</th>
                    @endforeach
                @endisset
            </tr>
        </thead>

        <tbody>
            @if( isset($user->studiedSubjectOnly ) && count( $user->studiedSubjectOnly) > 0 )
                @foreach ($user->studiedSubjectOnly as $items)
                    <tr>
                        <td style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;font-weight:bold">
                            {{ $items->subjects->name ?? '' }}
                        </td>
                        @isset($classes)
                            @foreach ($classes as $item)
                                <td class="" style="border: 1px solid #c3c3c3;color:#5f5d5d;height:0px;text-align:left;font-size: 12px;text-align:center">
                                    @if (isset($user->id) && getStudiedSubjects($user->id, $items->subject_id, $item->id)) 
                                        Yes
                                    @else
                                        -
                                    @endif
                                </td>
                            @endforeach
                        @endisset
                    </tr>
                @endforeach
            @endisset

        </tbody>

    </table>

    <div style="page-break-before:always">&nbsp;</div>

    @include('pages.overview.print_view._education')

    <table class="common-table" style="font-family: arial, sans-serif;border-collapse: collapse;" width="100%"
        cellpadding="5">
        <tbody>
            @include('pages.overview.print_view._language')
            @include('pages.overview.print_view._others')
        </tbody>
    </table>
    <!-- -------------------------------------------------------------- !-->
    <div style="page-break-before:always">&nbsp;</div>
    @include('pages.overview.print_view._family')
    {{-- @include('pages.overview.print_view._family_others') --}}
    {{-- @include('pages.overview.print_view._aews') --}}
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
