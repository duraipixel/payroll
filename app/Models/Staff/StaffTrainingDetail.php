<?php

namespace App\Models\Staff;

use App\Models\Master\TopicTraining;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffTrainingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_id', 
        'staff_id', 
        'from', 
        'to', 
        'trainer_name', 
        'training_topic_id',
        'remarks',
        'notes',
        'status'
    ];

    public function topics()
    {
        return $this->hasOne(TopicTraining::class, 'id', 'training_topic_id');
    }
}
