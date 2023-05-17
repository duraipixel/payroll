<?php

namespace App\Models\Staff;

use App\Models\Master\DocumentType;
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

    public function documentType()
    {
        return $this->hasOne(DocumentType::class, 'id', 'document_type_id');
    }
}
