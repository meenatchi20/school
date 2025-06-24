<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleWithPermission extends Model
{
    use HasFactory;

    protected $table = 'role_permission';
    protected $fillable = ['role_id','menu_id','full_access','read_only_access','hidden'];
}
