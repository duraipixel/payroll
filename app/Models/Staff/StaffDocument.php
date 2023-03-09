<?php

namespace App\Models\Staff;

use App\Models\Master\DocumentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffDocument extends Model
{
    use HasFactory;
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
        return $this->hasOne(DocumentType::class, 'document_type_id', 'id');
    }
}
