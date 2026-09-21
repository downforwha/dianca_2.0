<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinancialRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'this_month');
        [$dateFrom, $dateTo] = $this->getDateRange($period);

        $query = FinancialRecord::whereBetween('date', [$dateFrom, $dateTo]);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $totalIncome  = (clone $query)->where('type', 'income')->sum('amount');
        $totalExpense = (clone $query)->where('type', 'expense')->sum('amount');
        $netProfit    = $totalIncome - $totalExpense;
        $incomeCount  = (clone $query)->where('type', 'income')->count();
        $expenseCount = (clone $query)->where('type', 'expense')->count();

        $records = (clone $query)->with('order')->orderByDesc('date')->paginate(20)->withQueryString();

        // Chart data
        $chartRaw = FinancialRecord::select(
                DB::raw('DATE_FORMAT(date, "%b %Y") as label'),
                DB::raw('MIN(date) as min_date'),
                DB::raw('SUM(CASE WHEN type="income" THEN amount ELSE 0 END) as income'),
                DB::raw('SUM(CASE WHEN type="expense" THEN amount ELSE 0 END) as expense')
            )
            ->whereBetween('date', [$dateFrom, $dateTo])
            ->groupBy('label')
            ->orderByRaw('MIN(date) asc')
            ->get();

        $chartLabels = $chartRaw->pluck('label')->toArray();
        $incomeData  = $chartRaw->pluck('income')->map(fn($v) => (float)$v)->toArray();
        $expenseData = $chartRaw->pluck('expense')->map(fn($v) => (float)$v)->toArray();

        return view('admin.keuangan.index', compact(
            'records', 'totalIncome', 'totalExpense', 'netProfit',
            'incomeCount', 'expenseCount',
            'chartLabels', 'incomeData', 'expenseData',
            'period'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type'        => 'required|in:income,expense',
            'category'    => 'nullable|string|max:100',
            'amount'      => 'required|numeric|min:0',
            'description' => 'required|string|max:500',
            'notes'       => 'nullable|string|max:1000',
            'date'        => 'required|date',
        ]);

        $data['recorded_by']      = auth()->user()->name;
        $data['reference_number'] = 'MAN-' . date('YmdHis');

        FinancialRecord::create($data);
        return back()->with('success', 'Transaksi berhasil dicatat!');
    }

    public function destroy(FinancialRecord $record)
    {
        if ($record->order_id) {
            return back()->with('error', 'Transaksi yang terkait dengan pesanan tidak dapat dihapus.');
        }
        $record->delete();
        return back()->with('success', 'Transaksi berhasil dihapus!');
    }

    public function export(Request $request): StreamedResponse
    {
        $period = $request->get('period', 'this_month');
        [$dateFrom, $dateTo] = $this->getDateRange($period);

        $records = FinancialRecord::whereBetween('date', [$dateFrom, $dateTo])
            ->with('order')->orderByDesc('date')->get();

        $filename = 'keuangan_' . $period . '_' . now()->format('Ymd') . '.csv';

        return response()->streamDownload(function () use ($records) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Tanggal', 'Keterangan', 'Kategori', 'No. Order', 'Tipe', 'Jumlah']);
            foreach ($records as $rec) {
                fputcsv($file, [
                    $rec->date->format('d/m/Y'),
                    $rec->description,
                    $rec->category ?? 'Umum',
                    $rec->order->order_number ?? '—',
                    $rec->type === 'income' ? 'Pendapatan' : 'Pengeluaran',
                    number_format($rec->amount, 0, ',', '.'),
                ]);
            }
            fclose($file);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    private function getDateRange(string $period): array
    {
        return match($period) {
            'today'      => [now()->toDateString(), now()->toDateString()],
            'this_week'  => [now()->startOfWeek()->toDateString(), now()->endOfWeek()->toDateString()],
            '3_months'   => [now()->subMonths(3)->startOfMonth()->toDateString(), now()->toDateString()],
            '6_months'   => [now()->subMonths(6)->startOfMonth()->toDateString(), now()->toDateString()],
            'this_year'  => [now()->startOfYear()->toDateString(), now()->endOfYear()->toDateString()],
            'all'        => ['2000-01-01', now()->toDateString()],
            default      => [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()],
        };
    }
}
