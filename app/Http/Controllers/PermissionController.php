<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    // public function store()
    // {
        
    //     try{
    //         $permission = Permission::create(['name' => 'edit articles']);
    //         $toast = ['type' => 'success', 'title' => trans('lang.success'), 'message' => trans('lang.role_saved_successfully')];
    //         return redirect()->route('roles.index')->with('toast', $toast);
    //     }catch(Exception $e){
    //         $toast = ['type' => 'error', 'title' => 'error', 'message' => $e->getMessage(),];
    //         return redirect()->back()->with('toast', $toast);
    //     }
    // }
}
