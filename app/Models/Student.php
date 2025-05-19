<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'student';
    protected $fill = ['first_name','last_name','email','phone_no','age','department_id'];
    protected $fillable = ['first_name','last_name','email','phone_no','age','department_id'];
    

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function subject()
    {
        return $this->belongsToMany(Subject::class,'student_mapping','student_id','subject_id');
    }


}
