<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentMapping extends Model
{
    use HasFactory;

   
    protected  $table = 'student_mapping';
    protected $fillable = ['student_id','department_id'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
