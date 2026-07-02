<?php

namespace App\Http\Controllers;

use App\Pagoempleados;
use App\Empleados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exchangerate;

class PagoempleadosController extends Controller
{
    public function index(Request $request)
    {
        // Default dates: current week (Monday to Sunday)
        $defaultFrom = \Carbon\Carbon::now()->startOfWeek(\Carbon\Carbon::MONDAY)->format('Y-m-d');
        $defaultTo   = \Carbon\Carbon::now()->endOfWeek(\Carbon\Carbon::SUNDAY)->format('Y-m-d');

        $fromDate = $request->input('fromDate', $defaultFrom);
        $toDate   = $request->input('toDate', $defaultTo);

        $query = Pagoempleados::with('empleado.user');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('empleado', function($q) use ($search) {
                $q->where('document', 'like', "%{$search}%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($fromDate) {
            $query->whereDate('payment_date', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('payment_date', '<=', $toDate);
        }

        if ($request->filled('empleado_id')) {
            $query->where('empleado_id', $request->empleado_id);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $pagos = $query->latest()->paginate(10)->appends($request->query());
        $empleados = Empleados::with('user')->get()->sortBy('user.name');
        $rate = Exchangerate::updateTodayRate();
        $tasaDolar = $rate->value;

        return view('pagoempleados.index', compact('pagos', 'defaultFrom', 'defaultTo', 'empleados', 'tasaDolar'));
    }

    public function create()
    {
        $empleados = Empleados::with('user')->where('is_active', true)->get();
        $rate = Exchangerate::updateTodayRate();
        $tasaDolar = $rate->value;
        return view('pagoempleados.create', compact('empleados', 'tasaDolar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:Efectivo,Pago Movil,Transferencia',
            'reference' => 'nullable|string|max:255'
        ]);

        DB::beginTransaction();
        try {
            $ref = $request->payment_method === 'Efectivo' ? null : $request->reference;
            $rate = Exchangerate::updateTodayRate();

            Pagoempleados::create([
                'empleado_id' => $request->empleado_id,
                'amount' => $request->amount,
                'tasa_cambio' => $rate->value,
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'reference' => $ref
            ]);

            // Mark unpaid sales for this employee as paid
            $empleado = Empleados::findOrFail($request->empleado_id);
            $empleado->sales()->where('commission_paid', false)->update(['commission_paid' => true]);

            DB::commit();

            return redirect()->route('pagoempleados.index')->with('success', 'El pago fue registrado exitosamente y las comisiones fueron liquidadas.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Hubo un problema registrando el pago: ' . $e->getMessage());
        }
    }

    public function pdfData(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate   = $request->input('toDate');

        $query = Pagoempleados::with('empleado.user');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('empleado', function($q) use ($search) {
                $q->where('document', 'like', "%{$search}%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($fromDate) {
            $query->whereDate('payment_date', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('payment_date', '<=', $toDate);
        }

        if ($request->filled('empleado_id')) {
            $query->where('empleado_id', $request->empleado_id);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        return response()->json($query->orderBy('payment_date', 'desc')->get());
    }
}