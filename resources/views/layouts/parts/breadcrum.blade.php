<div data-kt-swapper="true" data-kt-swapper-mode="prepend"
    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
    
    <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">
        {{ $breadcrums['title'] ?? '' }}
    </h1>

    <span class="h-20px border-gray-300 border-start mx-4"></span>

    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{ url('/') }}" class="text-muted text-hover-primary"> Home </a>
        </li>
        @isset($breadcrums['breadcrums'])
            @foreach ($breadcrums['breadcrums'] as $item)
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-300 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted"> 
                    <a href="{{ isset($item['link']) && !empty( $item['link']) ? $item['link'] : 'javascript:void(0)' }}">
                        {{  $item['title']  }} 
                    </a>
                </li>
            @endforeach
        @endisset
    </ul>
</div>
