<div class="card-body py-4">
    <div class="body genealogy-body genealogy-scroll">
        <div class="genealogy-tree">
            <ul>
                
                @isset($reporting_data)
                <li>
                    <a href="javascript:void(0);">
                        <div class="member-view-box">
                            <div class="member-image">
                                <img src="http://localhost/amalpayroll/assets/images/no_Image.jpg" alt="Member">
                                <div class="member-details">
                                    <h3>{{ $reporting_data->manager->name }}</h3>
                                </div>
                            </div>
                        </div>
                    </a>
                
                    {{ buildTree($reporting_data->reportee_id); }}
                </li>
                @endisset
            </ul>
        </div>
    </div>

</div>