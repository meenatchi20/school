<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTempData extends Model
{
    use HasFactory;
    protected $table = 'student_temp_data';
    protected $fill = ['student_id','first_name','last_name','email','phone_no','age','department_id','action', 'maker_by', 'maker_at','status'];
    protected $fillable = ['student_id','first_name','last_name','email','phone_no','age','department_id','action', 'maker_by', 'maker_at','status'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function subject()
    {
        return $this->belongsToMany(Subject::class,'temp_student_subjects','student_id','subject_id');
    }
    
     public function students()
    {
        return $this->belongsTo(Student::class);
    }


}
