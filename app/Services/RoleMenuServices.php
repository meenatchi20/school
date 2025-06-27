<?php 
	namespace App\Services;

	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Hash;
	use Illuminate\Support\Facades\Log;
	use Illuminate\Support\Facades\DB;

	use App\Models\Menu;
	use App\Models\RoleModel;
	use App\Models\RoleWithPermission;


	class RoleMenuServices {

		//View MenuData
		public function getMenu(){
			try{
				 $menu = Menu::all();
				 return $menu;
			}catch(Exception $e){
				Log::error('Error in Get Menu! Please Check Server' . $e->getMessage());
			}
		}

		//Create Menu
		public function createMenu($request){
			try{
				$menu = Menu::create([
		            'menu_name' => $request['menu_name']
		        ]);
		        	return $menu;
	        }catch(Exception $e){
	        	Log::error('Error In Create Menu' . $e->getMessage());
	        }
		}

		//Edit 
		public function editMenu($id){
			return Menu::findOrFail($id);
		}

		//Update Menu
		public function updateMenu($id, $request){
			try{
				$menu = Menu::findOrFail($id);
				$updateMenu = $menu->update([
	                'menu_name' => $request['menu_name']
	             ]);
				return $updateMenu;
			}catch(Exception $e){
				Log::error('Error In Update Menu' . $e->getMessage());
			}
		}

		//Delete Menu
		public function deleteMenu($id){
			try{
				$getMenu = Menu::find($id); 
				$data = $getMenu->delete();
				return $data;
			}catch(Exception $e){
				Log::error('Error In Delete Menu!Check Log' . $e->getMessage());
			}
		}

		//Show Menu
		public function showMenu($id){
			try{
				$menu = Menu::find($id);
				return $menu;
			}catch(Exception $e){
				Log::error('Error In Show Menu' . $e->getMessage());
			}
		}

		//Create Role 
		public function createRole($request){
			try{
				$role = RoleModel::create([
	                'role'=> $request['role']
	            ]);
	            return $role;
        	}catch(Exception $e){
        		Log::error('Error In Create Role' . $e->getMessage());
        	}
		}

		//Get Role
		public function getRole(){
			try{
			 	$role = RoleModel::all();
			 	return $role;
		 	}catch(Exception $e){
		 		Log::error('Error In Get Role' . $e->getMessage());
		 	}
		}


		//Edit Role 
		//Edit 
		public function editRole($id){
			return RoleModel::findOrFail($id);
		}
		//Update Role
		public function updateRole($id, $request){
			try{
				$roles = RoleModel::findOrFail($id);
				$updateRole = $roles->update([
	                'role'=> $request['role']
	            ]);
	            return $roles;
        	}catch(Exception $e){
        		Log::error('Error In Update Role' . $e->getMessage());
        	}
		}

		//Delete Role
		public function deleteRole($id){
			try{
				$getRole = RoleModel::findOrFail($id);
	            $deleteRole = $getRole->delete();
	            return $deleteRole;
        	}catch(Exception $e){
        		Log::error('Error In Delete Role' . $e->getMessage());
        	}
		}

		//Show role
		public function showRole($id){
			try{
				return RoleModel::find($id);
			}catch(Exception $e){
				Log::error('Error In Show Role' . $e->getMessage());
			}
		}


		//Assign Permission
		public function assignPermission($request){
				RoleWithPermission::updateOrInsert(
		            [
		                'role_id' => $request['role_id'],
		                'menu_id' => $request['menu_id']
		            ],
		            [
		                'full_access' => $request['full_access'] ?? false,
		                'read_only_access' => $request['read_only_access'] ?? false,
		                'hidden' => $request['hidden'] ?? false,
		                'updated_at' => now()
		            ]
		        );
		        return true;
		}

		//delete permission
		public function deletePermission($id){
			$getPermission = RoleWithPermission::findOrFail($id);
            $deletePermission = $getPermission->delete();
            return $deletePermission;

		}

	}
?>