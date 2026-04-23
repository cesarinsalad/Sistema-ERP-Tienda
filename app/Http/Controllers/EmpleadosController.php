<?php

namespace App\Http\Controllers;

use App\Empleados;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class EmpleadosController extends Controller
{
    public function index(Request $request)
    {
        $query = Empleados::with('user')->where('is_active', true);
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('document', 'like', "%{$search}%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        $empleados = $query->latest()->paginate(10)->appends($request->query());
        return view('empleados.index', compact('empleados'));
    }

    public function inactivos(Request $request)
    {
        $query = Empleados::with('user')->where('is_active', false);
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('document', 'like', "%{$search}%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        $empleados = $query->latest()->paginate(10)->appends($request->query());
        return view('empleados.inactivos', compact('empleados'));
    }

    public function create()
    {
        return view('empleados.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'document' => 'required|string|unique:empleados',
            'phone' => 'nullable|string',
            'position' => 'required|string',
            'salary' => 'required|numeric|min:0',
            'role' => 'required|in:admin,empleado'
        ]);

        DB::beginTransaction();
        try {
            // Password defaults to the ID document
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->document, 
                'role' => $request->role
            ]);

            Empleados::create([
                'user_id' => $user->id,
                'document' => $request->document,
                'phone' => $request->phone,
                'position' => $request->position,
                'salary' => $request->salary,
                'is_active' => true
            ]);

            DB::commit();
            return redirect()->route('empleados.index')->with('success', 'Empleado creado y perfil generado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al crear el empleado: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $empleado = Empleados::with('user')->findOrFail($id);

        if (in_array($empleado->user->role, ['admin', 'super_admin']) && auth()->user()->role !== 'super_admin' && $empleado->user_id !== auth()->id()) {
            return redirect()->route('empleados.index')->with('error', 'Privilegios Insuficientes: No puedes modificar el perfil de otros Administradores.');
        }

        return view('empleados.edit', compact('empleado'));
    }

    public function show(Request $request, $id)
    {
        $empleado = Empleados::with('user')->findOrFail($id);
        
        // Base query for sales
        $salesQuery = \App\Order::where('user_id', $empleado->user_id);
        
        // Total stats (for the whole history)
        $totalSalesCount = $salesQuery->count();
        $totalSalesAmount = $salesQuery->sum('monto_orden');
        
        // Chart filtering
        $filter = $request->get('chart_filter', '6months');
        $chartQuery = \App\Order::where('user_id', $empleado->user_id);
        $groupByDay = false;

        if ($filter == 'thisweek') {
            $chartQuery->where('created_at', '>=', now()->startOfWeek());
            $periodLabel = 'Esta Semana';
            $groupByDay = true;
        } elseif ($filter == 'lastmonth') {
            $chartQuery->where('created_at', '>=', now()->subMonth());
            $periodLabel = 'Último Mes';
            $groupByDay = true;
        } elseif ($filter == '3months') {
            $chartQuery->where('created_at', '>=', now()->subMonths(3));
            $periodLabel = 'Últimos 3 Meses';
        } elseif ($filter == '6months') {
            $chartQuery->where('created_at', '>=', now()->subMonths(6));
            $periodLabel = 'Últimos 6 Meses';
        } elseif ($filter == '12months') {
            $chartQuery->where('created_at', '>=', now()->subMonths(12));
            $periodLabel = 'Último Año';
        } elseif ($filter == 'thisyear') {
            $chartQuery->whereYear('created_at', now()->year);
            $periodLabel = 'Año Actual (' . now()->year . ')';
        } else {
            $periodLabel = 'Histórico Completo';
        }

        if ($groupByDay) {
            $chartData = $chartQuery->selectRaw('DATE(created_at) as date, SUM(monto_orden) as total')
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        } else {
            $chartData = $chartQuery->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(monto_orden) as total')
                ->groupBy('year', 'month')
                ->orderBy('year')
                ->orderBy('month')
                ->get();
        }

        $labels = [];
        $data = [];
        $monthNames = [1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'];
        
        foreach ($chartData as $stat) {
            if ($groupByDay) {
                $labels[] = \Carbon\Carbon::parse($stat->date)->format('d M');
            } else {
                $label = $monthNames[$stat->month];
                if ($filter != '6months' && $filter != 'thisyear' && $filter != '3months') {
                    $label .= ' ' . substr($stat->year, 2);
                }
                $labels[] = $label;
            }
            $data[] = $stat->total;
        }

        // Paginated list for the table
        $ventas = $salesQuery->with(['client', 'products'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('empleados.show', compact('empleado', 'ventas', 'totalSalesCount', 'totalSalesAmount', 'labels', 'data', 'filter', 'periodLabel'));
    }

    public function update(Request $request, $id)
    {
        $empleado = Empleados::findOrFail($id);

        if (in_array($empleado->user->role, ['admin', 'super_admin']) && auth()->user()->role !== 'super_admin' && $empleado->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Privilegios Insuficientes: No puedes modificar el perfil de otros Administradores.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$empleado->user_id,
            'document' => 'required|string|unique:empleados,document,'.$id,
            'phone' => 'nullable|string',
            'position' => 'required|string',
            'salary' => 'required|numeric|min:0',
            'role' => 'required|in:admin,empleado'
        ]);

        DB::beginTransaction();
        try {
            // Self-protection logic: Prevent users from changing their own role or active status
            $isSelfUpdate = $empleado->user_id === auth()->id();
            $newRole = $isSelfUpdate ? $empleado->user->role : $request->role;
            $newIsActive = $isSelfUpdate ? $empleado->is_active : $request->has('is_active');

            $empleado->user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $newRole
            ]);

            $empleado->update([
                'document' => $request->document,
                'phone' => $request->phone,
                'position' => $request->position,
                'salary' => $request->salary,
                'is_active' => $newIsActive
            ]);

            DB::commit();
            
            $message = 'Datos del empleado actualizados.';
            if ($isSelfUpdate && ($request->role !== $empleado->user->role || !$request->has('is_active'))) {
                $message .= ' (Nota: Tu rol/estado no fueron modificados por seguridad propia)';
            }

            return redirect()->route('empleados.index')->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $empleado = Empleados::findOrFail($id);
        
        if ($empleado->user->role === 'super_admin') {
            return redirect()->back()->with('error', 'No se puede desactivar al Super Administrador.');
        }

        if ($empleado->user_id === auth()->id()) {
            return redirect()->back()->with('error', 'Por seguridad, no puedes desactivar tu propia cuenta activa.');
        }

        if ($empleado->user->role === 'admin' && auth()->user()->role !== 'super_admin') {
            return redirect()->back()->with('error', 'Privilegios Insuficientes: Solo el Super Administrador puede desactivar o modificar el estado de otros Administradores.');
        }

        $empleado->is_active = !$empleado->is_active;
        $empleado->save();
        
        $status = $empleado->is_active ? 'Reactivado' : 'Desactivado';
        return redirect()->route('empleados.index')->with('success', "Empleado $status exitosamente.");
    }
}