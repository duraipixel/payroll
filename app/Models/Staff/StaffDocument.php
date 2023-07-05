<?php

namespace App\Models\Staff;

use App\Models\Master\DocumentType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class StaffDocument extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    
    protected $fillable = [
        'academic_id',
        'staff_id',
        'document_type_id',
        'description',
        'doc_number',
        'doc_date',
        'file',
        'multi_file',
        'verification_status',
        'status'
    ];

    public function scopeAcademic($query)
    {
        if( session()->get('academic_id') && !empty( session()->get('academic_id') ) ){

            return $query->where('staff_documents.academic_id', session()->get('academic_id'));
        }
    }

    public function doc_approved_by()
    {
        return $this->hasOne(User::class, 'id', 'approved_by');
    }

    public function documentType()
    {
        return $this->hasOne(DocumentType::class, 'id', 'document_type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }
}
