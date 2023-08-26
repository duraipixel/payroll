<div class="card-body py-4">
    <div class="body genealogy-body genealogy-scroll">
        <div class="genealogy-tree">
            <ul>

                @isset($reporting_data)
                    <li>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">

                                    @if (isset($reporting_data->manager->image) && !empty($reporting_data->manager->image))
                                        @php
                                            $profile_image = Storage::url($reporting_data->manager->image);
                                        @endphp
                                        <img src="{{ asset('public' . $profile_image) }}" alt="" width="100"
                                            style="border-radius:10%">
                                    @else
                                        <img src="{{ asset('assets/images/no_Image.jpg') }}" alt="Member">
                                    @endif

                                    <div class="member-details">
                                        <h3>{{ $reporting_data->manager->name }}</h3>
                                    </div>
                                </div>
                            </div>
                        </a>

                        {{ buildTree($reporting_data->reportee_id) }}
                    </li>
                @endisset
            </ul>
        </div>
    </div>

</div>
