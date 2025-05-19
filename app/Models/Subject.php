<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';
    protected $fillable = ['subject_name'];


    public function students()
    {
        return $this->belongsToMany(Student::class,'student_mapping','student_id','subject_id');
    }

}
