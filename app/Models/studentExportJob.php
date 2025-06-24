<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class studentExportJob extends Model
{
    use HasFactory;

    protected $table = 'export_student_data';
    protected $fillable = ['user_id','file_name','status','initiated_at','completed_at'];


    public function User(){
        return $this->belongsTo(User::class);
    }
}
