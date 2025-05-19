<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentMapping extends Model
{
    use HasFactory;

   
    protected  $table = 'student_mapping';
    protected $fillable = ['student_id','subject_id'];

    
}
