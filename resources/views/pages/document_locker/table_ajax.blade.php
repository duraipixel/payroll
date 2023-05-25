<table id="document_locker_ajax" class="table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer"
                      style="width:100%">
                      <thead class="bg-primary">
                        <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">
                                <th class="text-center text-white" style="width:85px;">Staff  ID</th>
                                <th class="text-center text-white">Staff Name</th>
                                <th class="text-center text-white">Department</th>
                                <th class="text-center text-white">Designation</th>
                                <th class="text-center text-white">Total Documents</th>                                
                                <th class="text-center text-white">Aprroved Documents</th>
                                <th  class="text-center text-white">Pending Documents</th>
                                <th  class="text-center text-white">Action</th>
                            </tr>
                           
                        </thead>
                        <tbody>
                           
                                @foreach ($user as $users )
                                <tr>
                                <td>{{$users->emp_code}}</td>
                                <td>{{$users->name}}</td>
                                <td>{{$users->position->department->name ??''}}</td>
                                <td>{{$users->position->designation->name ??''}}</td>                                             
                                @php                                  
                                    $total_doc='';
                                    $total_doc=$users->staffDocuments->count()+$users->education->count()+
                                    $users->careers->count()+$users->leaves->count()+$users->appointmentCount->count(); 
                                    
                                    $pending_doc='';
                                    $pending_doc=$users->staffDocumentsPending->count()+$users->staffEducationDocPending->count()+
                                    $users->staffExperienceDocPending->count()+$users->leavesPending->count();

                                    $approved_doc='';
                                    $approved_doc=$users->staffDocumentsApproved->count()+$users->staffEducationDocApproved->count()+
                                    $users->staffExperienceDocApproved->count()+$users->leavesApproved->count()+$users->appointmentCount->count();
                                    
                                @endphp

                                <td>{{ $total_doc ?? '0'}}</td>
                                <td>{{$approved_doc ?? '0'}}</td>
                                <td>{{$pending_doc?? '0'}}</td>
                               
                                <td><a href=" {{route('user.dl_view', ['id' => $users->id])}}" class="btn btn-icon btn-active-info btn-light-info mx-1 w-30px h-30px"> 
                                    <i class="fa fa-eye"></i>
                                </a></td>
                                
                            </tr>
                                @endforeach
                                
                           
                        </tbody>
                    </table>

                    
<script>   

    $(document).ready(function () {
        $('#document_locker_ajax').DataTable({   
            "scrollX": true
        });
    });
</script>