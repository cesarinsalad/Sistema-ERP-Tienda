<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Default dates: current week (Monday to Sunday)
        $defaultFrom = \Carbon\Carbon::now()->startOfWeek(\Carbon\Carbon::MONDAY)->format('Y-m-d');
        $defaultTo   = \Carbon\Carbon::now()->endOfWeek(\Carbon\Carbon::SUNDAY)->format('Y-m-d');

        $fromDate = $request->input('fromDate', $defaultFrom);
        $toDate   = $request->input('toDate', $defaultTo);

        $query = Order::with(['client', 'tasa', 'seller']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('client', function($q) use ($search) {
                $q->where('nombres', 'like', "%{$search}%")
                  ->orWhere('apellidos', 'like', "%{$search}%");
            });
        }

        if ($fromDate) {
            $query->whereDate('created_at', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('created_at', '<=', $toDate);
        }

        $orders = $query->latest()->paginate(10)->appends($request->query()); // increased pagination for reports
        return view('listorden', compact('orders', 'defaultFrom', 'defaultTo'));
    }
    public function show(Order $listorden)
    {
        $listorden->load([
            'client',
            'products',
            'paymentMethods',
            'tasa'
        ]);
        return view('showorden',['order'=>$listorden]);
    }

    public function pdfData(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate   = $request->input('toDate');

        $query = Order::with(['client', 'tasa', 'seller']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('client', function($q) use ($search) {
                $q->where('nombres', 'like', "%{$search}%")
                  ->orWhere('apellidos', 'like', "%{$search}%");
            });
        }

        if ($fromDate) {
            $query->whereDate('created_at', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('created_at', '<=', $toDate);
        }

        return response()->json($query->latest()->get());
    }
}
