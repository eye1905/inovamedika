<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\Models\RolePermition;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {   
        $roles = Session("role_id");
        $url1 = $request->segment(1);
        $url2 = $request->segment(2);
        $url3 = $request->segment(3);
        $url4 = $request->segment(4);
        $method = $request->method();
        
        if($roles=="1"){
            return $next($request);
        }else{
            $permit = RolePermition::getAccess($url1,$roles);
            
            if($permit == null){
                abort(404);
            }

            if($method=="POST"){
                if($permit->create_permission==1){
                    return $next($request);
                }else{
                    abort(404);
                }
            }elseif($method=="PUT"){
                if($permit->update_permission==1){
                    return $next($request);
                }else{
                    abort(404);
                }
            }elseif($method=="DELETE"){
                if($permit->delete_permission==1){
                    return $next($request);
                }else{
                    abort(404);
                }
            }else{
                if($url2==null and $permit->read_permission==1){
                    return $next($request);
                }elseif($url2=="create" and $permit->create_permission==1){
                    return $next($request);
                }elseif($url3=="edit" and $permit->update_permission==1){
                    return $next($request);
                }elseif($url3==null and $url2!="create" and $permit->detail_permission==1){
                    return $next($request);
                }elseif($url3!=null and $permit->update_permission==1){
                    return $next($request);
                }else{
                    abort(404);
                }
            }
        }
    }
}
