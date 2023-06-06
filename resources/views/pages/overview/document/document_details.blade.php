<div class="col-sm-12 p-10">
              
                <div class="card">
                    <div class=" d-flex align-items-start p-10">
                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            <button class="nav-link active p-5" id="v-pills-personal-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-personal" type="button" role="tab" aria-controls="v-pills-personal"
                                aria-selected="true">Personal Documents</button>
                            <button class="nav-link  p-5" id="v-pills-education-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-education" type="button" role="tab"
                                aria-controls="v-pills-education" aria-selected="false">Education Documents</button>
                            <button class="nav-link  p-5" id="v-pills-experience-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-experience" type="button" role="tab"
                            aria-controls="v-pills-experience" aria-selected="false">Experience Documents</button>
                            <button class="nav-link  p-5" id="v-pills-leave-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-leave" type="button" role="tab"
                            aria-controls="v-pills-leave" aria-selected="false">Leave Documents</button>
                            <button class="nav-link  p-5" id="v-pills-salary-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-salary" type="button" role="tab"
                                aria-controls="v-pills-salary" aria-selected="false">Salary Slip</button>
                            <button class="nav-link  p-5" id="v-pills-appointment-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-appointment" type="button" role="tab"
                            aria-controls="v-pills-appointment" aria-selected="false">Appointment Order</button>
                        </div>
                        <div class="tab-content w-100" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-personal" role="tabpanel"
                                aria-labelledby="v-pills-personal-tab">
                                <table  class="p-10 table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer">
                                    <thead class="bg-primary p-10">
                                        
                                        <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="text-center text-white ps-3" >Document Name</th>
                                                <th class="text-center text-white"> Approval Status</th>
                                                <th class="text-center text-white"> Approved By</th>                                              
                                                <th class="text-center text-white">Uploaded Date</th>
                                              
                                                <th class="text-center text-white pe-3">Download</th>
                                              
                                            </tr>
                                           
                                        </thead>                                                                                 
                                     
                                    @forelse ($personal_doc as $personal_docs )
                                    <tr>
                                        <td> {{$personal_docs->documentType->name ??''}}</td>
                                        <td>
                                            @if ($personal_docs->verification_status=='pending')      
                                            <span class="badge badge-secondary"> Pending</span>
                                            @elseif ($personal_docs->verification_status=='approved')
                                            <span class="badge badge-success">
                                                {{ucfirst($personal_docs->verification_status)}}</span><br>
                                                {{$personal_docs->approved_date ??''}}
                                            @elseif($personal_docs->verification_status=='rejected')
                                            <span class="badge badge-danger"> 
                                                {{ucfirst($personal_docs->verification_status)}}
                                            </span><br>
                                            {{$personal_docs->rejected_date ??''}}
                                            @endif
                                           
                                        </td>
                                        <td> {{$personal_docs->doc_approved_by->name ??''}}</td>
                                        <td> {{$personal_docs->documentType->created_at ??''}}</td>                                       
                                      
                                        
                                        <td>
                                            <a href="{{ url('storage/app/public'.'/'.$personal_docs->multi_file) }}"  class="btn btn-icon btn-active-info btn-light-info mx-1 w-50px h-50px" target="_blank" download> 
                                                <i class="fa fa-download"></i></a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6"> <strong>Personal Documents not Uploaded</strong> </td>
                                    </tr>
                                    @endforelse

                                </table>
                                    
                              </div>
                            <div class="tab-pane fade" id="v-pills-education" role="tabpanel"
                                aria-labelledby="v-pills-education-tab">
                                <table  class="p-10 table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer">
                                    <thead class="bg-primary p-10">
                                        
                                        <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">

                                            <th class="text-center text-white ps-3" >Document Name</th>
                                            <th class="text-center text-white"> Approval Status</th>
                                            <th class="text-center text-white"> Approved By</th>                                                 
                                            <th class="text-center text-white">Uploaded Date</th>
                                         
                                            <th class="text-center text-white pe-3">Download</th>
                                              
                                              
                                            </tr>
                                           
                                        </thead>                                                                                 
                                    @forelse ($education_doc as $education_docs )
                                    <tr>
                                        <td> {{$education_docs->course_name ??''}}</td>

                                        <td>
                                            @if ($education_docs->verification_status=='pending')      
                                            <span class="badge badge-secondary"> Pending</span>
                                            @elseif ($education_docs->verification_status=='approved')
                                            <span class="badge badge-success">
                                                {{ucfirst($education_docs->verification_status)}}</span><br>
                                                {{$education_docs->approved_date ??''}}
                                            @elseif($education_docs->verification_status=='rejected')
                                            <span class="badge badge-danger"> 
                                                {{ucfirst($education_docs->verification_status)}}
                                            </span><br>
                                            {{$education_docs->rejected_date ??''}}
                                            @endif
                                           
                                        </td>
                                        <td> {{$education_docs->doc_approved_by->name ??''}}</td>                                       
                                        <td> {{$education_docs->submitted_date ??''}}</td>

                                        
                                         <td> <a href="{{ url('storage/app/public'.'/'.$education_docs->doc_file) }}"  class="btn btn-icon btn-active-info btn-light-info mx-1 w-50px h-50px" target="_blank" download> 
                                            <i class="fa fa-download"></i>
                                        </a></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6"> <strong>Education Documents not Uploaded</strong> </td>
                                    </tr>
                                    @endforelse

                                </table>
                            </div>
                            <div class="tab-pane fade" id="v-pills-experience" role="tabpanel"
                            aria-labelledby="v-pills-experience-tab">
                            <table  class="p-10 table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer">
                                <thead class="bg-primary p-10">
                                    
                                    <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">                                           
                                        <th class="text-center text-white ps-3">Designation</th>
                                        <th class="text-center text-white"> Approval Status</th>  
                                        <th class="text-center text-white"> Approved By</th>                                             
                                        <th class="text-center text-white">Uploaded Date</th>
                                        
                                        <th class="text-center text-white pe-3">Download</th>                                          
                                    </tr>
                                       
                                </thead>                                                                                 
                                @forelse ($experince_doc as $experince_docs )
                                <tr>
                                    <td> {{$experince_docs->designation->name ??''}}</td>

                                    <td>
                                        @if ($experince_docs->verification_status=='pending')      
                                        <span class="badge badge-secondary"> Pending</span>
                                        @elseif ($experince_docs->verification_status=='approved')
                                        <span class="badge badge-success">
                                            {{ucfirst($experince_docs->verification_status)}}</span><br>
                                            {{$experince_docs->approved_date ??''}}
                                        @elseif($experince_docs->verification_status=='rejected')
                                        <span class="badge badge-danger"> 
                                            {{ucfirst($experince_docs->verification_status)}}
                                        </span><br>
                                        {{$experince_docs->rejected_date ??''}}
                                        @endif
                                       
                                    </td>
                                    <td> {{$experince_docs->doc_approved_by->name ??''}}</td>                        
                                    <td> {{$experince_docs->created_at ??''}}</td>
                                  
                                     <td> <a href=" {{ url('storage/app/public'.'/'.$experince_docs->doc_file) }}" class="btn btn-icon btn-active-info btn-light-info mx-1 w-50px h-50px" target="_blank" download> 
                                        <i class="fa fa-download"></i>
                                    </a></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6"> <strong>Experience Documents not Uploaded</strong> </td>
                                </tr>
                                @endforelse

                            </table>
                        </div>
                            <div class="tab-pane fade" id="v-pills-leave" role="tabpanel"
                                aria-labelledby="v-pills-leave-tab">
                                <table  class="p-10 table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer">
                                    <thead class="bg-primary p-10">
                                        
                                        <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">
                                                   
                                                                                      
                                                <th class="text-center text-white ps-3">Leave Dates</th>
                                                <th class="text-center text-white">No of Days</th>
                                                <th class="text-center text-white">Approval Status</th>
                                                <th class="text-center text-white">Leave Approved By</th>
                                              
                                                <th class="text-center text-white pe-3">Download</th>                                              
                                            </tr>
                                           
                                        </thead>                                                                                 
                                    @forelse ($leave_doc as $leave_docs )
                                    <tr>
                                      
                                       
                                        <td>{{$leave_docs->from_date ??''}} to {{$leave_docs->to_date ??''}}</td>
                                        <td>{{$leave_docs->no_of_days ?? ''}}</td>                             
                                    <td>
                                        @if ($leave_docs->status=='pending')      
                                        <span class="badge badge-secondary"> Pending</span>
                                        @elseif ($leave_docs->status=='approved')
                                        <span class="badge badge-success">
                                            {{ucfirst($leave_docs->status)}}</span><br>
                                            {{$leave_docs->approved_date ??''}}                                          
                                        @elseif($leave_docs->status=='rejected')
                                        <span class="badge badge-danger"> 
                                            {{ucfirst($leave_docs->status)}} </span><br>
                                            {{$leave_docs->rejected_date ??''}}   
                                       
                                        @endif                                       
                                    </td>
                                    <td> {{$leave_docs->granted_info->name ??''}}</td>
                                   
                                    <td>
                                           @if ($leave_docs->status=='pending'  )
                                           <a href="{{ url('storage/app'.'/'.$leave_docs->document) }}"  class="btn btn-icon btn-active-info btn-light-info mx-1 w-50px h-50px" target="_blank" download> 
                                            <i class="fa fa-download"></i>
                                        </a>                       
                                            @else                                            
                                            <a href="{{ url('storage/app'.'/'.$leave_docs->approved_document) }}"  class="btn btn-icon btn-active-info btn-light-info mx-1 w-50px h-50px" target="_blank" download> 
                                                <i class="fa fa-download"></i>
                                            </a>
                                            @endif
                                    </td>
                                          
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6"> <strong>Leave Documents not Uploaded</strong> </td>
                                    </tr>
                                    @endforelse
    
                                </table>
                            </div>
                            <div class="tab-pane fade" id="v-pills-salary" role="tabpanel"
                                aria-labelledby="v-pills-salary-tab">
                            
                                <table  class="p-10 table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer">
                                    <thead class="bg-primary p-10">
                                        
                                        <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">
                                                   
                                                                                      
                                                <th class="text-center text-white ps-3">Gross Salary</th>
                                                <th class="text-center text-white">Deductions</th>     
                                                <th class="text-center text-white">Approval Status</th>                                               
                                                <th class="text-center text-white">Approved By</th>
                                               
                                                <th class="text-center text-white pe-3">Download</th>                                              
                                            </tr>
                                           
                                        </thead>                                                                                 
                                    @forelse ($salary_doc as $salary_docs )
                                    <tr>                         
                                        <td>{{$salary_docs->total_earnings ??''}} </td>
                                        <td>{{$salary_docs->total_deductions ?? ''}}</td>                               
                                    <td>
                                        @if ($salary_docs->is_salary_processed=='no' && $salary_docs->approved_date=='')      
                                        <span class="badge badge-secondary"> Pending</span>
                                        @elseif ($salary_docs->is_salary_processed=='yes' && $salary_docs->approved_date!='')
                                        <span class="badge badge-success">
                                          Approved</span><br>     
                                          {{$salary_docs->approved_date ?? ''}}
                                        @elseif ($salary_docs->is_salary_processed=='no' && $salary_docs->rejected_date!='')
                                            <span class="badge badge-danger">
                                            Rejected</span><br>     
                                            {{$salary_docs->rejected_date ?? ''}}                   
                                        @endif                                       
                                    </td>
                                    <td>{{$salary_docs->salaryApprovedBy->name ?? ''}}</td>                        
                                  
                                    <td>
                                           @if ($salary_docs->is_salary_processed=='yes'  )
                                           <!-- <a href="{{ url('storage/app'.'/'.$leave_docs->document) }}"  class="btn btn-icon btn-active-info btn-light-info mx-1 w-50px h-50px" target="_blank" download> 
                                                   
                                                </a>      -->                           
                                            @endif
                                    </td>
                                          
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6"> <strong>Salary Documents not Uploaded</strong> </td>
                                    </tr>
                                    @endforelse
    
                                </table>
                            </div>
                            <div class="tab-pane fade" id="v-pills-appointment" role="tabpanel"
                            aria-labelledby="v-pills-appointment-tab">
                            <table  class="p-10 table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer">
                                <thead class="bg-primary p-10">
                                    
                                    <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="text-center text-white">Appointment Model Name</th>
                                            <th class="text-center text-white">Employee Nature</th>
                                            <th class="text-center text-white">Joining Date</th>
                                            <th class="text-center text-white">Download</th>
                                          
                                        </tr>
                                       
                                    </thead>                                                                                 
                                @forelse ($appointment_doc as $appointment_docs )
                                <tr>
                                    <td> {{$appointment_docs->appointmentOrderModel->name ??''}}</td>
                                    <td>{{ucfirst($appointment_docs->employment_nature->name ?? '')}}</td>
                                    <td> {{$appointment_docs->joining_date ??''}}</td>

                                    <td> 
                                        @if($appointment_docs->appointment_doc)
                                        <a href="{{ url('storage/app/public'.'/'.$appointment_docs->appointment_doc) }}"  class="btn btn-icon btn-active-info btn-light-info mx-1 w-50px h-50px" target="_blank" download> 
                                        <i class="fa fa-download"></i>
                                    </a>
                                    @endif
                                </td>
                                      
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4"> <strong>Appointment Documents not Uploaded</strong> </td>
                                </tr>
                                @endforelse

                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>