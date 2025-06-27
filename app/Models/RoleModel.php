<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class RoleModel extends Model
{
    use HasFactory;
    protected $table = 'role';
    protected $fillable = ['role'];


    public function users()
        {
            return $this->hasMany(User::class,'role_id');
        }

   public function menu(){

      return $this->belongsToMany(Menu::class,'role_permission');
      
    } 
}
