<?php
namespace App\Helpers;

use App\Models\Role\Permission;
use App\Models\User;
use DB;


class AccessGuard {
    public function buttonAccess($route_name,$type)
    {
        if( auth()->user()->is_super_admin ) {
            return true;
        } else {
            if( !empty( $route_name ) ) {
                $info = User::find(auth()->id());
       
                $data = $info->roleMapped;      
                $role_id = $data->role_id ?? '';
                if($type=='add_edit')
                {
                    $menu_check = Permission::where('role_id', $role_id)->where('add_edit_menu','1')->where('route_name',$route_name)->first();            
                }
                else if($type=='view')
                {
                   //dd($module);
                    //DB::connection()->enableQueryLog();
                    $menu_check = Permission::where('role_id', $role_id)->where('view_menu','1')->where('route_name',$route_name)->first();           
                    //$queries = DB::getQueryLog();
                    //dd($queries);
                }
                else if($type=='delete')
                {
                    $menu_check = Permission::where('role_id', $role_id)->where('delete_menu','1')->where('route_name',$route_name)->first(); 
                }
                else if($type=='export')
                {
                    $menu_check = Permission::where('role_id', $role_id)->where('export_menu','1')->where('route_name',$route_name)->first();
                }
                else
                {
                    return false; 
                }
               
                if($menu_check)            
                    return true;           
                else            
                return false; 
                }
                else
                {
                    return false; 
                }
        
        }
    }
    public function hasAccess($module, $permission_module = '') {
        if( auth()->user()->is_super_admin ) {
            return true;
        } else {
            $info = User::find(auth()->id());
            $data = $info->roleMapped;      
            $role_id=$data->role_id ?? '';           
            //$data = $info->role->permissions;
            //$data = unserialize($data);
            if( is_string( $module ) ) {
                $module = array( $module );
            }
            
            if( isset( $module ) && !empty( $module ) && is_array( $module ) ) {
                if($permission_module=='')
                {
                    $top_menu=array();
                    foreach( $module as $item ) {                    
                        $top_menu[] =  Permission::where(function ($query) {
                            $query->where('add_edit_menu','1')
                                  ->orWhere('view_menu','1')
                                  ->orWhere('delete_menu','1')
                                  ->orWhere('export_menu','1');
                        })->where('role_id', $role_id)->where('route_name',$item)->first();                  
                    }                                 
                    if(array_filter($top_menu))
                    {                       
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                }
                else if($permission_module=='add_edit')
                {
                    $menu_check = Permission::where('role_id', $role_id)->where('view_menu','1')->where('route_name',$module)->first(); 
                    if($menu_check)            
                    return true;           
                    else            
                    return false; 
                }
                else if($permission_module=='view')
                {
                    $menu_check = Permission::where('role_id', $role_id)->where('view_menu','1')->where('route_name',$module)->first();           
                    if($menu_check)            
                    return true;           
                    else            
                    return false; 
                }
                else if($permission_module=='delete')
                {
                    $menu_check = Permission::where('role_id', $role_id)->where('delete_menu','1')->where('route_name',$module)->first(); 
                    if($menu_check)            
                    return true;           
                    else            
                    return false; 
                }
                else if($permission_module=='export')
                {
                    $menu_check = Permission::where('role_id', $role_id)->where('export_menu','1')->where('route_name',$module)->first();
                    if($menu_check)            
                    return true;           
                    else            
                    return false; 
                }
      
            }
            
            return false;
        }   
    }

    function check_access($permission_module = '') {       
        
        $module = request()->route()->getName(); 
        //dd( $module );
        $info = User::find(auth()->id());
       
        $data = $info->roleMapped;      
        $role_id=$data->role_id;
        //$module = explode(".", $module);
        //$module = current($module);
      
        
        if( !empty($data)) {
            
            if( isset( $module) && !empty($module)) {
              
                if( !empty( $permission_module ) ) {
        if($permission_module=='add_edit')
        {
            $menu_check = Permission::where('role_id', $role_id)->where('add_edit_menu','1')->where('route_name',$module)->first();            
        }
        else if($permission_module=='view')
        {
           //dd($module);
            //DB::connection()->enableQueryLog();
            $menu_check = Permission::where('role_id', $role_id)->where('view_menu','1')->where('route_name',$module)->first();           
            //$queries = DB::getQueryLog();
            //dd($queries);
        }
        else if($permission_module=='delete')
        {
            $menu_check = Permission::where('role_id', $role_id)->where('delete_menu','1')->where('route_name',$module)->first(); 
        }
        else if($permission_module=='export')
        {
            $menu_check = Permission::where('role_id', $role_id)->where('export_menu','1')->where('route_name',$module)->first();
        }
        else
        {
            abort(403);
        }
       
        if($menu_check)            
            return true;           
        else            
            abort(403);
        }

            }
        }
       // 
    }
}