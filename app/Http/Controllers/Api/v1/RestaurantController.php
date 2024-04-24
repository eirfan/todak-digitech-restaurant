<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaseResource;
use App\Http\Resources\ErrorResource;
use App\Models\Restaurants;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RestaurantController extends Controller
{
    public function getListOfRestaurant(Request $request) {
        $validator = Validator::make($request->all(),[
            'isFilterCategories'=>'boolean',
            'categories'=>'required_if:a,true',
            'rowsPerPage'=>'required',
        ]);
        
        try{
            if($validator->fails()) {
               
                throw new Exception($this->parseValidationError($validator->errors()->all()));
            }
            $restaurantQuery = Restaurants::query();
            if(isset($request->isFilterCategories) && filter_var($request->isFilterCategories,FILTER_VALIDATE_BOOLEAN)) {
                ## BOC  : User is requesting to filter the restaurants based on categories
    
                if(is_array($request->categories)) {
                    $restaurantQuery = $restaurantQuery->whereIn('restaurants.categories',$request->categories);
                }
                if(is_string($request->categories)) {
                    $restaurantQuery = $restaurantQuery->where('restaurants.categories','like',"%".$request->categories."%");
                }
    
                ## EOC
            }
            $restaurantQuery = $restaurantQuery->select(
                'restaurants.id',
                'restaurants.created_at',
                'restaurants.name',
                'restaurants.address',
                'restaurants.categories',
            );
    
            $restaurant = $restaurantQuery->paginate($request->rowsPerPage);
    
            if(!isset($restaurant)) {
                throw new Exception("Cannot find any restaurants");
            }
            return new BaseResource($restaurant,200,__FUNCTION__);
            
        }catch(Exception $exception) {
            return new ErrorResource($exception->getMessage(),$exception->getCode(),__FUNCTION__);
        }
    }

    public function getRestaurant(Request $request) {
        try{
            $restaurant = Restaurants::findOrFail($request->id);
            return new BaseResource($restaurant,200,__FUNCTION__);
        }catch(Exception $exception) {
            return new ErrorResource($exception->getMessage(),$exception->getCode(),__FUNCTION__);
        }
    }

    public function getListOfRestaurantMenus(Request $request) {
        try{
           $menus = Restaurants::join('menus','menus.restaurant_id','=','restaurants.id')
           ->where('restaurants.id','=',$request->id)
           ->select(
            'restaurants.id as restaurant_id',
            'menus.id as menu_id',
            'menus.created_at as menu_created_at',
            'restaurants.created_at as restaurant_created_at',
            'menus.name as menu_name',
            'restaurants.name as restaurant_name',
            'menus.*',
            'restaurants.*',
           )->paginate($request->rowsPerPage);

           if(!isset($menus)) {
            throw new Exception("Cannot find the menus");
           }
           return new BaseResource($menus,200,__FUNCTION__);
        }catch(Exception $exception) {
            return new ErrorResource($exception->getMessage(),$exception->getCode(),__FUNCTION__);
        }
    }
    public function create(Request $request) {
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'address'=>'required',
            'categories'=>'required',            
        ]);

        try{
            
            if($validator->fails()) {
                throw new Exception($this->parseValidationError($validator->errors()->all()));
            }

            $restaurant = unserialize(serialize($request->all()));
            $newRestaurant = Restaurants::create($restaurant);
            if(!isset($newRestaurant)) {
                throw new Exception("Cannot register the restaurant");
            }
            return new BaseResource($newRestaurant,200,__FUNCTION__);
        }catch(Exception $exception) {
            return new ErrorResource($exception->getMessage(),$exception->getCode(),__FUNCTION__);
        }
    }
    public function update(Request $request) {
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'address'=>'required',
            'categories'=>'required',  
            'operation_status'=>'required|in:active,inactive',
            'approval_status'=>'required|in:pending,approve,rejected'          
        ]);

        try{
            
            if($validator->fails()) {
                throw new Exception($this->parseValidationError($validator->errors()->all()));
            }
            
            $restaurant = Restaurants::findOrFail($request->id);
            if(!isset($restaurant)) {
                throw new Exception("Cannot find the restaurant");
            }
            DB::beginTransaction();
            if(!$restaurant->update($request->all())) {
                throw new Exception("Cannot update the restaurant");
            }; 
            DB::commit();

            return new BaseResource($restaurant,200,__FUNCTION__);
        }catch(Exception $exception) {
            DB::rollBack();
            return new ErrorResource($exception->getMessage(),$exception->getCode(),__FUNCTION__);
        }        
    }
}
