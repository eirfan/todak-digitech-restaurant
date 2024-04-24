<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaseResource;
use App\Http\Resources\ErrorResource;
use App\Models\Invoices;
use App\Models\Menus;
use App\Models\MenusOrders;
use App\Models\Orders;
use App\Models\Restaurants;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function getAllRestaurantOrder(Request $request) {
        $validator = Validator::make($request->all(),[
            'isFilterOrderStatus'=>'boolean',
            'orderStatus'=>'required_if:a,true',
            'rowsPerPage'=>'required',
        ]);
        try{
            $query = DB::table('restaurants')->join('orders','orders.restaurant_id','=','restaurants.id')
            ->join('menus_orders','menus_orders.order_id','=','orders.id')
            ->join('menus','menus.id','=','menus_orders.menu_id')
            ->where('restaurants.id','=',$request->id);
           
    
            if(isset($request->isFilterOrderStatus) && filter_var($request->isFilterOrderStatus,FILTER_VALIDATE_BOOLEAN)) {
                if(is_array($request->orderStatus)){
                    $query = $query->whereIn('orders.status',$request->orderStatus);
                }
                if(is_string($request->orderStatus)) {
                    $query = $query->where('order.status','=',$request->orderStatus);
                }
            }
    
            $restaurantOrders = $query->select(
                'restaurants.id as restaurant_id',
                'orders.id as order_id',
                'menus.id as menu_id',
                'orders.created_at as order_created_at',
                'restaurants.created_at as restaurant_created_at',
                'menus.created_at as menus_created_at',
                'orders.*',
                'restaurants.*',
                'menus.*'
            )->paginate($request->rowsPerPage);
    
            if(!$restaurantOrders) {
                throw new Exception("Cannot find orders for the restaurant");
            }
            return new BaseResource($restaurantOrders,200,__FUNCTION__);

        }catch(Exception $exception) {
            return new ErrorResource($exception->getMessage(),$exception->getCode(),__FUNCTION__);
        }

    }
    public function store(Request $request) {
        $validator = Validator::make($request->all(),
        [
            'type_of_deliveries'=>'required|in:pickup,deliveries',
            'status'=>'required',
            'menus'=>'required|array',
            'menus.*'=>'required|exists:menus,id',
        ]);
        try{
            if($validator->fails()) {
                throw new Exception($this->parseValidationError($validator->errors()->all()));
            }
            DB::beginTransaction();
            $restaurant = Restaurants::findOrFail($request->id);
            $user = Auth::user();

            ## BOC : Create a deep copy of the variable $request->all() for saving purposes
            $order = unserialize(serialize($request->all()));
            ## EOC
            $order['restaurant_id'] = $restaurant->id;
            $order['user_id'] = $user->id;

            $newOrder = Orders::create($order);

            $orderedMenus = [];
            foreach($request->menus as $menu) {
                ## BOC : Insert the menus into orders
                $newMenu = MenusOrders::create([
                    'menu_id'=>$menu,
                    'order_id'=>$newOrder->id,
                ]);
                $orderedMenus[] = $newMenu->toArray();
                ## EOC
            }

            if(!empty($orderedMenus)){
                $menus = Menus::whereIn('id',$request->menus)->get();
                $totalPrice = 0;
                foreach($menus as $menu) {
                    $totalPrice = $totalPrice + $menu->price;
                }
                $invoice = Invoices::create([
                    'order_id'=>$newOrder->id,
                    'total'=>$totalPrice,
                ]);
            }


            DB::commit();
            return new BaseResource([
                'order'=>$newOrder,
                'menus'=>$orderedMenus,
                'invoice'=>$invoice,
            ],200,__FUNCTION__);
        }catch(Exception $exception) {
            DB::rollBack();
            return new ErrorResource($exception->getMessage(),$exception->getCode(),__FUNCTION__);
        }
    }
    public function update(Request $request) {
        $validator = Validator::make($request->all(),[
            'type_of_deliveries'=>'required|in:pickup,deliveries',
            'status'=>'required',
        ]);
        
        try{
            if($validator->fails()) {
                throw new Exception($this->parseValidationError($validator->errors()->all()));
            }
            $order = Orders::findOrFail($request->id);
    
            if(!$order->update($request->all())) {
                throw new Exception("Cannot update orders");
            };
            return new BaseResource($order,200,__FUNCTION__);

        }catch(Exception $exception) {
            return new ErrorResource($exception->getMessage(),$exception->getCode(),__FUNCTION__);
        }

    }
}
