<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoleModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Services\RoleMenuServices;
use App\Http\Requests\RoleRequest;

class ApiRoleController extends Controller
{
        //View Role Data
        public function index(RoleMenuServices $getRoleData){
            $role = $getRoleData->getRole();
            if($role){
                return response()->json([
                'success' => true,
                'data' => $role
            ]);
            }else{
                return response()->json([
                    'success' => false,
                    'error'=> 'Role not found'
                ]);
            }
        }

        //Create Roles
        public function create(RoleRequest $request, RoleMenuServices $createRoleData){
            $validateRole = $request->validated();
            $role = $createRoleData->createRole($validateRole);
            // Check if user is Super Admin
            $user = auth()->user();
                 if (!$user || !$user->role || $user->role->role !== 'SuperAdmin') {
                    return response()->json(['error' => 'Unauthorized! Only SuperAdmin Create Role'], 403);
                }  
            if($role){
                return response()->json([
                    'success' => true,
                    'message' => 'Role Created Successfully',
                    'data' => $role
                ]);
            }else{
                 return response()->json([
                    'success' => false,
                    'error'=> 'something wrong'
                ]);
            }
        }

        //edit Role
        public function edit(string $id, RoleMenuServices $editRoleData){
            $editRole = $editRoleData->editRole($id);
            if($editRole){
                return response()->json([
                    'success' => true,
                    'data' => $editRole
                ]);
             }else{
                return response()->json([
                    'success' => true,
                    'message' => 'Role does not Find'
                ]);
             }
    }
        //update Roles
        public function update(RoleRequest $request, string $id, RoleMenuServices $updateRoleData){
            $validateRole = $request->validated();
            $updateRole = $updateRoleData->updateRole($id,$validateRole);           
            if($updateRole){
                return response()->json([
                    'success' => true,
                    'message' => 'Role Updated Successfully',
                    'data' => $updateRole
                ]);
            }else{
                 return response()->json([
                    'success' => false,
                    'error'=> 'Role not found'
                ]);
            }

        }
        //Delete Roles
        public function delete($id, RoleMenuServices $deleteRoleData){
            $deleteRole =  $deleteRoleData->deleteRole($id);
            if($deleteRole){
                return response()->json([
                    'success' => true,
                    'message' => 'Role Deleted Successfully',
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'error'=> 'Role not found'
                ]);
            }
        }

        //show Role Data
        public function show($id, RoleMenuServices $showRoleData){
            $showRole = $showRoleData->showRole($id);
            if($showRole){
                return response()->json([
                    'success' => true,
                    'message' => $showRole
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'error'=> 'Role not found'
                ]);
            }
        }


}
