<?php

namespace App\Http\Controllers;

use App\Models\AttendanceManagement\LeaveHead;
use App\Models\Master\Bank;
use App\Models\Master\BankBranch;
use App\Models\Master\Society;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PayrollManagement\StaffSalary;
use App\Models\PayrollManagement\StaffSalaryField;
use Illuminate\Support\Facades\Storage;
use App\Models\Leave\StaffLeave;
use Barryvdh\DomPDF\Facade\Pdf;
use \NumberFormatter;
use App\Models\Staff\StaffRetiredResignedDetail;
use App\Models\AcademicYear;
class CommonController extends Controller
{    
    public function numberToWord($num = '')
      {
        $num    = ( string ) ( ( int ) $num );
        if( ( int ) ( $num ) && ctype_digit( $num ) )
        {
            $words  = array( );
            $num    = str_replace( array( ',' , ' ' ) , '' , trim( $num ) );
            $list1  = array('','one','two','three','four','five','six','seven',

                'eight','nine','ten','eleven','twelve','thirteen','fourteen',

                'fifteen','sixteen','seventeen','eighteen','nineteen');
            $list2  = array('','ten','twenty','thirty','forty','fifty','sixty',

                'seventy','eighty','ninety','hundred');
            $list3  = array('','thousand','million','billion','trillion',

                'quadrillion','quintillion','sextillion','septillion',

                'octillion','nonillion','decillion','undecillion',

                'duodecillion','tredecillion','quattuordecillion',

                'quindecillion','sexdecillion','septendecillion',

                'octodecillion','novemdecillion','vigintillion');
            $num_length = strlen( $num );

            $levels = ( int ) ( ( $num_length + 2 ) / 3 );

            $max_length = $levels * 3;

            $num    = substr( '00'.$num , -$max_length );

            $num_levels = str_split( $num , 3 );
            foreach( $num_levels as $num_part )

            {
                $levels--;

                $hundreds   = ( int ) ( $num_part / 100 );

                $hundreds   = ( $hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ( $hundreds == 1 ? '' : 's' ) . ' ' : '' );

                $tens       = ( int ) ( $num_part % 100 );

                $singles    = '';
                if( $tens < 20 ) { $tens = ( $tens ? ' ' . $list1[$tens] . ' ' : '' ); } else { $tens = ( int ) ( $tens / 10 ); $tens = ' ' . $list2[$tens] . ' '; $singles = ( int ) ( $num_part % 10 ); $singles = ' ' . $list1[$singles] . ' '; } $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_part ) ) ? ' ' . $list3[$levels] . ' ' : '' ); } $commas = count( $words ); if( $commas > 1 )

                {

                    $commas = $commas - 1;

                }
                $words  = implode( ', ' , $words );

                $words  = trim( str_replace( ' ,' , ',' , ucwords( $words ) )  , ', ' );

                if( $commas )

                {

                    $words  = str_replace( ',' , ' and' , $words );

                }



                return $words;

            }

            else if( ! ( ( int ) $num ) )

            {

                return 'Zero';

            }

            return '';

        }
    
    public function openAddModal(Request $request)
    {
        $form_type = $request->form_type;
        $bank_id = $request->bank_id ?? '';
        if( $form_type == 'intitution' ) {
            $title = 'Add Institution';
        } else {
            $title = 'Add '.ucfirst($form_type);
        }
        $society = Society::where('status', 'active')->get();
        $content = '';

        if( !empty( $bank_id )) {
            $banks = Bank::find($bank_id);
        }
        
        switch ($form_type) {
            case 'intitution':
                
                $content = view('pages.masters.institutes.add_edit_form', compact('society'));
                break;

            case 'division':
            
                $content = view('pages.masters.divisions.add_edit_form');
                break;

            case 'class':
        
                $content = view('pages.masters.classes.add_edit_form');
                break;
                
            case 'language':
    
                $content = view('pages.masters.languages.add_edit_form');
                break;
            case 'new_language':

                $content = view('pages.masters.new_languages.add_edit_form');
                break;
            
            case 'places':
                $content = view('pages.masters.places.add_edit_form');
                break;

            case 'other_places':
                $content = view('pages.masters.other_places.add_edit_form');
                break;
            
            case 'nationality':
                $content = view('pages.masters.nationality.add_edit_form');
                break;
                
            case 'family_nationality':
                $content = view('pages.masters.nationality.add_edit_form1');
                break;
            
            case 'religion':
                $content = view('pages.masters.religion.add_edit_form');
                break;
            
            case 'caste':
                $content = view('pages.masters.caste.add_edit_form');
                break;

            case 'community':
                $content = view('pages.masters.community.add_edit_form');
                break;

            case 'bank':
                $content = view('pages.masters.bank.add_edit_form');
                break;

            case 'bankbranch':
                $content = view('pages.masters.bankbranch.add_edit_form', compact('banks'));
                break;

            case 'designation':
                $content = view('pages.masters.designation.add_edit_form');
                break;
            case 'experience_designation':
                $content = view('pages.masters.experience_designation.add_edit_form');
                break;
            
            case 'department':
                $content = view('pages.masters.department.add_edit_form');
                break;
            
            case 'subject':
                $content = view('pages.masters.subject.add_edit_form');
                break;
            
            case 'scheme':
                $content = view('pages.masters.scheme.add_edit_form');
                break;
            case 'duty_class':
                $content = view('pages.masters.duty_classes.add_edit_form');
                break;
            case 'duty_type':
                $content = view('pages.masters.duty_types.add_edit_form');
                break;
            case 'other_school':
                $content = view('pages.masters.other_schools.add_edit_form');
                break;
            case 'experience_institute_name':
                $content = view('pages.masters.exp_institutes.add_edit_form');
                break;
            case 'training_topic':
                $content = view('pages.masters.training_topic.add_edit_form');
                break;
            case 'boards':
                $content = view('pages.masters.boards.add_edit_form');
                break;
            case 'main_subject':
                $content = view('pages.masters.main_subject.add_edit_form');
                break;
            case 'ancillary_subject':
                $content = view('pages.masters.ancillary_subject.add_edit_form');
                break;
            case 'professional_type':
                $content = view('pages.masters.professional_type.add_edit_form');
                break;
            case 'relationship':
                $content = view('pages.masters.relation_type.add_edit_form');
                break;
            case 'qualification':
                $content = view('pages.masters.qualification.add_edit_form');
                break;
            case 'blood_group':
                $content = view('pages.masters.blood_group.add_edit_form');
                break;
            case 'medic_blood_group':
                $content = view('pages.masters.blood_group.add_edit_form_medic');
                break;
            case 'relationship_working_type':
                $content = view('pages.masters.working_relationship_type.add_edit_form');
                break;
            case 'staff_category':
                $content = view('pages.masters.staff_category.add_edit_form');
                break;
            case 'nature_of_employeement':
                $content = view('pages.masters.nature_of_employeement.add_edit_form');
                break;
            case 'teaching_type':
                $content = view('pages.masters.teaching_type.add_edit_form');
                break;
            case 'place_of_work':
                $content = view('pages.masters.place_of_work.add_edit_form');
                break;
            case 'order_model':
                $content = view('pages.masters.appointment_order_model.add_edit_form');
                break;
            
            default:
                # code...
                break;
        }
       
        
        return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }

    public function getStaffInfo(Request $request)
    {
        $query = $request['query'];
        $data = [];
        if( $query ) {

            $data = User::with('position.designation')
                        ->where(function($q) use($query) {
                            $q->where('name', 'like', "%{$query}%");
                            $q->orWhere('emp_code', 'like', "%{$query}%");
                            $q->orWhere('institute_emp_code', 'like', "%{$query}%");
                            $q->orWhere('society_emp_code', 'like', "%{$query}%");
                        })
                        ->InstituteBased()
                        ->where(['status' => 'active'])
                        // ->Academic()                       
                        ->get();

        }

        return $data;

    }

    function getStaffLeaveInfo(Request $request) {
        
        $staff_id = $request['staff_id'];
        if(isset($request->date) && !empty($request->date)){
        $resigned=StaffRetiredResignedDetail::where('last_working_date','<=',$request->date)->pluck('staff_id');
            if(count($resigned)>0 && in_array((int)$staff_id,$resigned->toArray())){
                return array('type'=>'retired','data' => '','leave_view'=>'');  
        }
        }
        $academic=AcademicYear::find(academicYearId());
        $data = User::with(['position.designation', 'reporting'])->find($staff_id);
        $leave_count=0;
        $taken_leave =  StaffLeave::where('staff_id', $staff_id)->whereYear('from_date',$academic->from_year)->get();
    
        foreach($taken_leave as $leave){
            $leave_count+=$leave->granted_days;
    
        }
        $tbody_view='';
        $staffleavesHead=StaffleaveAllocated($staff_id,academicYearId());
        if (isset($staffleavesHead) && count($staffleavesHead) > 0) {
            foreach ($staffleavesHead as $item) {
                $leave_head_name = $item->leave_head->name ?? '';
                $no_of_leave = $item->no_of_leave ?? 0;
                $took_leaves = leaveData($staff_id, $academic->from_year, $leave_head_name);
                $balance = $no_of_leave - $took_leaves;
        
                // Append table row to $leave_view
                $tbody_view .= '<tr>
                    <td>' . $leave_head_name . '</td>
                    <td class="text-center">' . $no_of_leave . '</td>
                    <td>' . $took_leaves . '</td>
                    <td>' . number_format($balance, 2) . '</td>
                </tr>';
            }
        }
        $leave_view='<div class="col-sm-12" id="leave_data">
        <label for="" class="text-warning">Maternity Leave is only applicable for female staff</label>
        <div class="col-sm-8">
            <h6 class="fs-6 mt-3 alert alert-danger">Total Leave Taken - '.$leave_count.'&nbsp;&nbsp;&nbsp; <a href="#" id="taken_data1" onclick="viewLeave()"><i class="fa fa-eye"></i></a></h6>
            <h6 class="fs-6 mt-3 alert alert-info">Leave Summary</h6>
            <div class="table-wrap table-responsive" style="max-height: 400px;">
                <table id="nature_table_staff" class="table table-hover table-bordered">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Type</th>
                            <th>Allocated</th>
                            <th>Availed</th>
                             <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>'.$tbody_view.
                    '</tbody>
                </table>
            </div>
        </div>
        <div class="col-sm-4">
            <!-- Placeholder content for the right column -->
        </div>
    </div>';
        return array('type'=>'staff','data' => $data,'leave_view'=>$leave_view);
    }

    public function getLeaveForm(Request $request)
    {
        
        if( $request->leave_category_id ) {
            $heads = LeaveHead::find($request->leave_category_id);
            
            if( $heads ) {
                switch (strtolower($heads->name)) {
                    case 'el':
                        return view('pages.leave.request_leave.el_form');
                        break;
                    case 'eol':
                        return view('pages.leave.request_leave.el_form');
                        break;
                    case 'ml':
                        return view('pages.leave.request_leave.el_form');
                    default:
                        return '';
                        break;
                }
            }
        }
        dd( $request->all() );
    }
    public function payrollDownload(Request $request,$id)
    {
        $info=StaffSalary::with('staff.familyMembers','staff.pancard','staff.pf','staff.esi','staff.position','staff.appointment','fields','staff.leavesApproved')->find($id);
       $date_string = $info->salary_year . '-' . $info->salary_month . '-01';
        $date = date('d/M/Y', strtotime($date_string));

        $params = [
            'institution_name' => $info->staff->institute->name ?? '',
            'institution_address' => $info->staff->institute->address ?? '',
            'institution_logo' => $info->staff->institute->logo ?? '',
             'institution_website' => $info->staff->institute->website ?? '',
            'pay_month' => 'Pay Slip for the month of ' . $info->salary_month . '-' . $info->salary_year,
            'info' => $info,
            'date' => $date
        ];
        
        foreach($info->fields as $field){
          if($field->field_name=="Basic Pay"){
            $params['basic_pay']=$field->amount;
          }
          if($field->field_name=="Dearness Allowance"){
            $params['dearness']=$field->amount;
          }
          if($field->field_name=="House Rent Allowance"){
            $params['house_rent']=$field->amount;
          }
          if($field->field_name=="Traveling Allowance"){
            $params['traveling']=$field->amount;
          }
           if($field->field_name=="Performance Based Allowance Dearness Allowance"){
            $params['performance']=$field->amount;
          }
           if($field->field_name=="Dedication & Sincerity Allowance"){
            $params['dedication']=$field->amount;
          }
           if($field->field_name=="Medical & Nutrition Allowance"){
            $params['medical']=$field->amount;
          }
          if($field->field_name=="Income Tax"){
            $params['income_tax']=$field->amount;
          }
          if($field->field_name=="Employee Provident Fund"){
            $params['pf']=$field->amount;
          }
          if($field->field_name=="Bank Loan"){
            $params['bank_loan']=$field->amount;
          }
          if($field->field_name=="Life Insurance Corporation"){
            $params['insurance']=$field->amount;
          }
        if($field->field_name=="OTHER LOAN"){
            $params['loan']=$field->amount;
          }
           if($field->field_name=="Performance Based Allowance"){
            $params['performance_allowance']=$field->amount;
          }
           if($field->field_name=="Professional Tax"){
            $params['p_tax']=$field->amount;
          }
           if($field->field_name=="Contributions"){
            $params['contributions']=$field->amount;
          }
          if($field->field_name=="Arrears"){
            $params['arrears']=$field->amount;
          }
           if($field->field_name=="Others"){
            $params['others']=$field->amount;
          }
        }
        $head_leave=LeaveHead::where('academic_id',academicYearId())->where('status','active')->get();
         $start=date('Y-m-d', strtotime($date_string));
         $end=date('Y-m-t', strtotime($start));
        foreach($head_leave as $head){
        if ($info->staff->status == 'transferred') {
            $leave=StaffLeave::where('staff_id',$info->staff->refer_user_id)->where('leave_category',$head->name)->whereBetween('from_date',[$start,$end])->where('status','approved')->get();
        } else {
         $leave=StaffLeave::where('staff_id',$info->staff->id)->where('leave_category',$head->name)->whereBetween('from_date',[$start,$end])->where('status','approved')->get();
          
        }
        $head['count']=0;
      foreach($leave as $leave_count){
            $head['count']+=$leave_count->granted_days;
        }
        }
        $params['leave_types']=$head_leave;
        $params['word']=$this->numberToWord($info->net_salary) ?? '';
       

        $file_name = time() .'_'. $info->staff->institute_emp_code . '.pdf';

        $directory              = 'public/salary/' . $date_string;
        $filename               = $directory . '/' . $file_name;

        $pdf = Pdf::loadView('pages.payroll_management.overview.statement._auto_gen_pdf', $params)->setPaper('a4', 'portrait');
      return $pdf->download('salaryslip.pdf');
        
        
    }

}

