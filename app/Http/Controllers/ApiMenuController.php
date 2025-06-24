<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Services\RoleMenuServices;
use App\Http\Requests\MenuRequest;

class ApiMenuController extends Controller
{
    //View MenuData
    public function index(RoleMenuServices $getMenuData){
        $menu = $getMenuData->getMenu(); 
 
        if($menu){
            return response()->json([
                'success' => true,
                'data' => $menu
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Menu does not Found'
            ]);
        }
    }

    //Create Menu
    public function create(MenuRequest $request, RoleMenuServices $createMenuData){

        // Check if user is Super Admin
             $user = auth()->user();
                 if (!$user || !$user->role || $user->role->role !== 'SuperAdmin') {
                    return response()->json(['error' => 'Unauthorized! Only SuperAdmin Assign Permission'], 403);
                }
                
       $validateMenu = $request->validated();
       $menu = $createMenuData->createMenu($validateMenu);
            
        if($menu){
            return response()->json([
                'success' => true,
                'message' => 'Menu Created Successfully',
                'data' => $menu
            ]);
        }else{
             return response()->json([
                'success' => true,
                'message' => 'Menu does not Created'
            ]);
        }
    }

    //Update Menu
    public function update(MenuRequest $request, string $id, RoleMenuServices $updateMenuData){
            
            $validateMenu = $request->validated();
            $updateMenu = $updateMenuData->updateMenu($id, $validateMenu);

             if($updateMenu){
                return response()->json([
                    'success' => true,
                    'message' => 'Menu Updated Successfully',
                    'data' => $updateMenu
                ]);
             }else{
                return response()->json([
                    'success' => true,
                    'message' => 'Menu does not Updated'
                ]);
             }
         }

        //Delete Menu
          public function delete($id, RoleMenuServices $deleteMenuData){
            $deleteMenu = $deleteMenuData->deleteMenu($id);   
            if($deleteMenu){
                return response()->json([
                    'success' => true,
                    'message' => 'Menu Deleted Successfully',
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'error'=> 'Menu not found'
                ]);
            }
        }

        //Show Menu Data
         public function show($id, RoleMenuServices $showMenuData){
            $showMenu = $showMenuData->showMenu($id);
            if($showMenu){
                return response()->json([
                    'success' => true,
                    'message' => $showMenu
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'error'=> 'Menu not found'
                ],404);
            }
        }

}
