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
}
