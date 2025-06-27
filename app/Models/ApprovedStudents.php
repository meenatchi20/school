<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovedStudents extends Model
{
    use HasFactory;

    protected $table = 'approved_students';
    protected $fillable = ['temp_student_id', 'action', 'maker_by','maker_at', 'approved_by', 'approved_at'];
}
