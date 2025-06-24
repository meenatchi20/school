<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RoleModel;
use App\Models\Menu;
use App\Models\RoleWithPermission;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RolePermissionRequest;
use App\Services\RoleMenuServices;
use Illuminate\Support\Facades\Log;

class RolePermissionController extends Controller
{
    public function assignPermission(RolePermissionRequest $request,RoleMenuServices $permission)
    {
        try{
            $validatePermission = $request->validated();
            $permission->assignPermission($validatePermission);

            // Check if user is Super Admin
             $user = auth()->user();
                 if (!$user || !$user->role || $user->role->role !== 'SuperAdmin') {
                    return response()->json(['error' => 'Unauthorized! Only SuperAdmin Assign Permission'], 403);
                }
            
            return response()->json([
                'success' => true,
                'user' => $user->role->role,
                'message' => 'Permission saved successfully'
            ]);

        }catch(Exception $e){
            Log::error('Permission is Not Assigned' . $e->getMessage());
        }   
    }

    public function deletePermission($id, RoleMenuServices $deletePermissionData){
        try{
            $delete = $deletePermissionData->deletePermission($id);
                if($delete){
                    return response()->json([
                    'success' => true,
                    'message' => 'Permission Deleted Successfully'
                ]);
            }
            else{
                   return response()->json([ 
                    'success' => false,
                    'message' => 'Permission Not Deleted!Please Check'
                ]);
            }
         }catch(Exception $e){
             Log::error('Permission is Not Assigned' . $e->getMessage());
         }
    }
   
}
