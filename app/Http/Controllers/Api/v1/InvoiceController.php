<?php

namespace App\Http\Controllers\Api\v1;

use App\Contracts\PaymentGatewayInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\BaseResource;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\InvoiceReportResource;
use App\Models\Invoices;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\Type\TrueType;

class InvoiceController extends Controller
{
    protected $paymentServices;
    public function __construct(PaymentGatewayInterface $paymentGatewayInterface) {
        $this->paymentServices = $paymentGatewayInterface;
    }
    public function payInvoice(Request $request) {
        try{
            $invoice = Invoices::findOrFail($request->id);
            DB::beginTransaction();

            if($invoice->status=='paid') {
                throw new Exception("Invoice is already paid");
            }
            $user = User::findOrFail(Auth::user()->id);
            $this->paymentServices->charge($invoice,$user);
            $invoice->paid_at = Carbon::now()->toDateTimeLocalString();
            $invoice->status = "paid";
            $invoice->save();
            DB::commit();
            return new BaseResource($invoice,200,__FUNCTION__);
            
            
        }catch(Exception $exception) {
            DB::rollBack();
            return new ErrorResource($exception->getMessage(),$exception->getCode(),__FUNCTION__);
        }
    }
    public function calculateSales(Request $request) {
        $validator = Validator::make($request->all(),[
            'start_date'=>'nullable',
            'end_date'=>'nullable',
        ]);
        try{
            $query = DB::table('restaurants')
            ->join('orders','orders.restaurant_id','=','restaurants.id')
            ->join('invoices','invoices.order_id','=','orders.id')
            ->where('restaurants.id','=',$request->id)
            ->select(
                'restaurants.id as restaurant_id',
                'orders.id as order_id',
                'orders.created_at',
                'invoices.id as invoice_id',
                'invoices.status as invoice_status',
                'invoices.paid_at',
                'invoices.total'
            );

            if(isset($request->start_date)) {
                $query = $query->where('invoices.paid_at',">=",$request->start_date);
            }
            if(isset($request->end_date)) {
                $query = $query->where('invoices.paid_at','<=',$request->end_date);
            }

            $invoices = $query->get();
            $totalSales = $invoices->pluck('total')->toArray();
            $sales = array_sum($totalSales);

            $summary = [
                'total_sales_RM' => $sales,
                'total_orders' => count($totalSales),
            ];
            return new InvoiceReportResource($invoices,$summary,200,__FUNCTION__);


        }catch(Exception $exception) {
            return new ErrorResource($exception->getMessage(),$exception->getCode(),__FUNCTION__);

        }
    }
}
