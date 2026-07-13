<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Order;
use App\Product;
use App\Product_order;
use App\Metodo_pago_orden;
use App\OrderReturn;
use App\OrderReturnItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderReturnController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getInfo($order_id)
    {
        $order = Order::with(['products', 'paymentMethods'])->findOrFail($order_id);
        
        $daysPassed = Carbon::parse($order->created_at)->diffInDays(Carbon::now());
        if ($daysPassed > 15) {
            return response()->json(['error' => 'La orden supera el límite de 15 días para devoluciones.'], 403);
        }

        return response()->json([
            'order' => $order,
            'days_passed' => $daysPassed
        ]);
    }

    public function processReturn(Request $request, $order_id)
    {
        $request->validate([
            'return_type' => 'required|in:same_item,money_back,different_item',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'return_to_stock' => 'boolean',
            'reason' => 'nullable|string',
        ]);

        $order = Order::with(['products', 'paymentMethods'])->findOrFail($order_id);
        
        if (Carbon::parse($order->created_at)->diffInDays(Carbon::now()) > 15) {
            return response()->json(['error' => 'La orden supera el límite de 15 días.'], 403);
        }

        $oldProductPivot = $order->products()->where('product_id', $request->product_id)->first();
        if (!$oldProductPivot || $oldProductPivot->pivot->quantity < $request->quantity) {
            return response()->json(['error' => 'Cantidad inválida para devolver.'], 422);
        }

        $unitPrice = $oldProductPivot->pivot->precio / $oldProductPivot->pivot->quantity;

        DB::beginTransaction();
        try {
            $returnToStock = $request->input('return_to_stock', false);
            
            $orderReturn = OrderReturn::create([
                'order_id' => $order->id,
                'type' => $request->return_type,
                'reason' => $request->reason,
            ]);

            $orderReturnItem = OrderReturnItem::create([
                'order_return_id' => $orderReturn->id,
                'returned_product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'returned_to_stock' => $returnToStock,
            ]);

            if ($returnToStock) {
                $oldProduct = Product::find($request->product_id);
                $oldProduct->cantidad += $request->quantity;
                $oldProduct->save();
            }

            if ($request->return_type == 'money_back') {
                $refundAmount = $unitPrice * $request->quantity;
                $orderReturn->update(['amount_refunded' => $refundAmount]);

                $order->monto_orden -= $refundAmount;
                $order->save();

                $newQty = $oldProductPivot->pivot->quantity - $request->quantity;
                $newPivotPrice = $oldProductPivot->pivot->precio - $refundAmount;
                if ($newQty > 0) {
                    $order->products()->updateExistingPivot($request->product_id, [
                        'quantity' => $newQty,
                        'precio' => $newPivotPrice
                    ]);
                } else {
                    $order->products()->detach($request->product_id);
                }

                $remainingRefund = $refundAmount;
                foreach ($order->paymentMethods as $pm) {
                    if ($remainingRefund <= 0) break;
                    
                    $available = $pm->pivot->monto_pago_orden;
                    if ($available > 0) {
                        $deduct = min($available, $remainingRefund);
                        $newAmount = $available - $deduct;
                        
                        DB::table('metodo_pago_ordens')
                            ->where('id', $pm->pivot->id)
                            ->update(['monto_pago_orden' => $newAmount]);
                            
                        $remainingRefund -= $deduct;
                    }
                }

            } elseif ($request->return_type == 'same_item') {
                $oldProduct = Product::find($request->product_id);
                $oldProduct->cantidad -= $request->quantity;
                $oldProduct->save();
                
                $orderReturnItem->update(['exchanged_for_product_id' => $request->product_id]);

            } elseif ($request->return_type == 'different_item') {
                $request->validate([
                    'new_product_id' => 'required|exists:products,id',
                ]);

                $newProduct = Product::findOrFail($request->new_product_id);
                $newUnitPrice = $newProduct->precio;
                $totalNewPrice = $newUnitPrice * $request->quantity;
                $totalOldPrice = $unitPrice * $request->quantity;
                
                $difference = $totalNewPrice - $totalOldPrice;
                if ($difference < 0) {
                    throw new \Exception('El nuevo artículo debe ser de igual o mayor valor.');
                }

                $orderReturn->update([
                    'amount_charged' => $difference,
                    'payment_method_id' => $difference > 0 ? $request->payment_method_id : null
                ]);
                $orderReturnItem->update(['exchanged_for_product_id' => $newProduct->id]);

                $newProduct->cantidad -= $request->quantity;
                $newProduct->save();

                $newQty = $oldProductPivot->pivot->quantity - $request->quantity;
                $newPivotPrice = $oldProductPivot->pivot->precio - $totalOldPrice;
                if ($newQty > 0) {
                    $order->products()->updateExistingPivot($request->product_id, [
                        'quantity' => $newQty,
                        'precio' => $newPivotPrice
                    ]);
                } else {
                    $order->products()->detach($request->product_id);
                }

                $existingNewProductPivot = $order->products()->where('product_id', $newProduct->id)->first();
                if ($existingNewProductPivot) {
                    $order->products()->updateExistingPivot($newProduct->id, [
                        'quantity' => $existingNewProductPivot->pivot->quantity + $request->quantity,
                        'precio' => $existingNewProductPivot->pivot->precio + $totalNewPrice
                    ]);
                } else {
                    $order->products()->attach($newProduct->id, [
                        'quantity' => $request->quantity,
                        'precio' => $totalNewPrice
                    ]);
                }

                $order->monto_orden += $difference;
                $order->save();

                if ($difference > 0) {
                    Metodo_pago_orden::create([
                        'id_orden' => $order->id,
                        'id_metodo_pago' => $request->payment_method_id,
                        'monto_pago_orden' => $difference,
                        'reference' => 'Cambio dif.'
                    ]);
                }
            }

            DB::commit();
            return response()->json(['message' => 'Devolución procesada exitosamente.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
