<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\User;
use App\Models\Menu;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\DB;

class StudentPolicy
{

    public function getPermission(User $user, string $menuName){
            $menu = Menu::where('menu_name',$menuName)->first();

            $permission = DB::table('role_permission')
                          ->where('role_id', $user->role_id)
                          ->where('menu_id', $menu->id)
                          ->first();
            return $permission;   
       }   

    /**
     * Determine whether the user can view any models.
     */
    //Index
    public function viewAny(User $user): bool
    {
        if ($user && $user->role && $user->role->role === 'SuperAdmin') return true;
            $permission = $this->getPermission($user,'ViewAny');
            return $permission && $permission->full_access;
       
    }

    /**
     * Determine whether the user can create models.
     */
    //Create Student
    public function create(User $user): bool
    {
        
        if ($user && $user->role && $user->role->role === 'SuperAdmin') return true;
            $permission = $this->getPermission($user,'Students Create');
            return $permission && $permission->full_access;
    }

    /**
     * Determine whether the user can update the model.
     */
    //update StudentData
    public function update(User $user, Student $student): bool
    {
        
        if ($user && $user->role && $user->role->role === 'SuperAdmin') return true;
            $permission = $this->getPermission($user,'Students Update');
            return $permission && $permission->full_access;
    }

    /**
     * Determine whether the user can delete the model.
     */
    //Delete StudentData
    public function delete(User $user, Student $student): bool
    {
        
        if ($user && $user->role && $user->role->role === 'SuperAdmin') return true;
            $permission = $this->getPermission($user,'Students Delete');
            return $permission && $permission->full_access;
    }

    //MarkUpload Using Excel
    public function markImport(User $user): bool
    {
        if ($user->role && $user->role->role === 'SuperAdmin') return true;
         $permission = $this->getPermission($user, 'Students MarkImport');
         return $permission && $permission->full_access;
    }

    //dataImport Using Excel
    public function studentDataImport(User $user): bool
    {
        if ($user->role && $user->role->role === 'SuperAdmin') return true;
         $permission = $this->getPermission($user, 'Students DataImport');
         return $permission && $permission->full_access;
    }


    //Export StudentData in Pdf 
    public function pdfDownload(User $user): bool
    {
        
        if ($user && $user->role && $user->role->role === 'SuperAdmin') return true;
             $permission = $this->getPermission($user,'Students pdfDownload');
             return $permission && $permission->full_access;
    }

    //Excel Export
    public function ExcelExport(User $user){
        if ($user && $user->role && $user->role->role === 'SuperAdmin') return true;
             $permission = $this->getPermission($user,'Students ExcelExport');
             return $permission && $permission->full_access ;
    }

     //Download ExportedData
     public function downloadExportedStudentData(User $user): bool
    {
        
        if ($user && $user->role && $user->role->role === 'SuperAdmin') return true;
             $permission = $this->getPermission($user,'Download ExcelExportData');
             return $permission && $permission->full_access;
    }



    //Send Email
    public function sendMail(User $user): bool
    {
        if ($user && $user->role && $user->role->role === 'SuperAdmin') return true;
             $permission = $this->getPermission($user,'Send Email');
             return $permission && $permission->full_access;
    }


    //View Mark
    public function viewMark(User $user): bool
    {
        if ($user && $user->role && $user->role->role === 'SuperAdmin') return true;
            $permission = $this->getPermission($user,'ViewMarkList');
            return $permission && $permission->full_access;
       
    }

}
