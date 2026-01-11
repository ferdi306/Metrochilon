<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    // Return daily attendance summary for a given month (YYYY-MM)
    public function attendanceDaily(Request $request)
    {
        $month = $request->query('month', now()->format('Y-m'));
        try {
            $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid month format, use YYYY-MM'], 422);
        }
        $end = (clone $start)->endOfMonth();

        // Prepare days array
        $days = [];
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $days[$date->toDateString()] = [
                'present' => 0,
                'izin' => 0,
                'sakit' => 0,
            ];
        }

        // Fetch attendance 'in' counts grouped by date
        $attendances = Attendance::select(DB::raw('DATE(created_at) as date'), DB::raw('count(distinct user_id) as cnt'))
            ->whereBetween('created_at', [$start, $end->endOfDay()])
            ->where('type', 'in')
            ->groupBy('date')
            ->get()
            ->pluck('cnt', 'date')
            ->toArray();

        foreach ($attendances as $date => $cnt) {
            if (isset($days[$date])) $days[$date]['present'] = (int) $cnt;
        }

        // Fetch leaves overlapping the month with status approved and count per day
        $leaves = Leave::where('status', 'approved')
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_date', [$start->toDateString(), $end->toDateString()])
                    ->orWhereBetween('end_date', [$start->toDateString(), $end->toDateString()])
                    ->orWhere(function ($q2) use ($start, $end) {
                        $q2->where('start_date', '<=', $start->toDateString())->where('end_date', '>=', $end->toDateString());
                    });
            })
            ->get();

        foreach ($leaves as $leave) {
            $from = Carbon::parse($leave->start_date)->max($start);
            $to = Carbon::parse($leave->end_date)->min($end);
            for ($d = $from->copy(); $d->lte($to); $d->addDay()) {
                $ds = $d->toDateString();
                if (!isset($days[$ds])) continue;
                if ($leave->type === 'sakit') $days[$ds]['sakit']++;
                elseif ($leave->type === 'izin') $days[$ds]['izin']++;
                // cuti (vacation) not counted here; could be added if needed
            }
        }

        // Return arrays for labels and datasets
        $labels = array_keys($days);
        $present = array_values(array_map(function ($v) { return $v['present']; }, $days));
        $izin = array_values(array_map(function ($v) { return $v['izin']; }, $days));
        $sakit = array_values(array_map(function ($v) { return $v['sakit']; }, $days));

        if ($request->wantsJson() || $request->acceptsJson()) {
            return response()->json([
                'labels' => $labels,
                'present' => $present,
                'izin' => $izin,
                'sakit' => $sakit,
            ]);
        }

        return response()->stream(function () use ($labels, $present, $izin, $sakit) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['date', 'present', 'izin', 'sakit']);
            foreach ($labels as $i => $label) {
                fputcsv($handle, [$label, $present[$i], $izin[$i], $sakit[$i]]);
            }
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="attendance_daily_' . now()->format('Y-m') . '.csv"'
        ]);
    }

    // Return monthly attendance summary for a given year
    public function attendanceMonthly(Request $request)
    {
        $year = $request->query('year', now()->year);
        if (!is_numeric($year) || strlen((string)$year) !== 4) {
            return response()->json(['error' => 'Invalid year'], 422);
        }

        $labels = [];
        $present = [];
        $izin = [];
        $sakit = [];

        for ($m = 1; $m <= 12; $m++) {
            $start = Carbon::create($year, $m, 1)->startOfMonth();
            $end = (clone $start)->endOfMonth();
            $labels[] = $start->format('Y-m');

            // Count total 'in' attendance records for the month
            $cntPresent = Attendance::whereBetween('created_at', [$start, $end->endOfDay()])->where('type', 'in')->count();
            $present[] = $cntPresent;

            // Leaves overlapping the month
            $leaves = Leave::where('status', 'approved')
                ->where(function ($q) use ($start, $end) {
                    $q->whereBetween('start_date', [$start->toDateString(), $end->toDateString()])
                      ->orWhereBetween('end_date', [$start->toDateString(), $end->toDateString()])
                      ->orWhere(function ($q2) use ($start, $end) {
                          $q2->where('start_date', '<=', $start->toDateString())->where('end_date', '>=', $end->toDateString());
                      });
                })->get();

            $cntIzin = $leaves->where('type', 'izin')->count();
            $cntSakit = $leaves->where('type', 'sakit')->count();

            $izin[] = $cntIzin;
            $sakit[] = $cntSakit;
        }

        if ($request->wantsJson() || $request->acceptsJson()) {
            return response()->json([ 'labels' => $labels, 'present' => $present, 'izin' => $izin, 'sakit' => $sakit ]);
        }

        return response()->stream(function () use ($labels, $present, $izin, $sakit) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['month', 'present', 'izin', 'sakit']);
            foreach ($labels as $i => $label) {
                fputcsv($handle, [$label, $present[$i], $izin[$i], $sakit[$i]]);
            }
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="attendance_monthly_' . now()->format('Y') . '.csv"'
        ]);
    }

    // Export daily CSV (wrapper for attendanceDaily logic)
    public function exportDailyCsv(Request $request)
    {
        $month = $request->query('month', now()->format('Y-m'));
        try {
            $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid month format, use YYYY-MM'], 422);
        }
        $end = (clone $start)->endOfMonth();

        $days = [];
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $days[$date->toDateString()] = ['present' => 0, 'izin' => 0, 'sakit' => 0];
        }

        $attendances = Attendance::select(DB::raw('DATE(created_at) as date'), DB::raw('count(distinct user_id) as cnt'))
            ->whereBetween('created_at', [$start, $end->endOfDay()])
            ->where('type', 'in')
            ->groupBy('date')
            ->get()
            ->pluck('cnt', 'date')
            ->toArray();

        foreach ($attendances as $date => $cnt) {
            if (isset($days[$date])) $days[$date]['present'] = (int) $cnt;
        }

        $leaves = Leave::where('status', 'approved')
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_date', [$start->toDateString(), $end->toDateString()])
                    ->orWhereBetween('end_date', [$start->toDateString(), $end->toDateString()])
                    ->orWhere(function ($q2) use ($start, $end) {
                        $q2->where('start_date', '<=', $start->toDateString())->where('end_date', '>=', $end->toDateString());
                    });
            })
            ->get();

        foreach ($leaves as $leave) {
            $from = Carbon::parse($leave->start_date)->max($start);
            $to = Carbon::parse($leave->end_date)->min($end);
            for ($d = $from->copy(); $d->lte($to); $d->addDay()) {
                $ds = $d->toDateString();
                if (!isset($days[$ds])) continue;
                if ($leave->type === 'sakit') $days[$ds]['sakit']++;
                elseif ($leave->type === 'izin') $days[$ds]['izin']++;
            }
        }

        $labels = array_keys($days);
        $present = array_values(array_map(function ($v) { return $v['present']; }, $days));
        $izin = array_values(array_map(function ($v) { return $v['izin']; }, $days));
        $sakit = array_values(array_map(function ($v) { return $v['sakit']; }, $days));

        return response()->stream(function () use ($labels, $present, $izin, $sakit) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['date', 'present', 'izin', 'sakit']);
            foreach ($labels as $i => $label) {
                fputcsv($handle, [$label, $present[$i], $izin[$i], $sakit[$i]]);
            }
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="attendance_daily_' . $month . '.csv"'
        ]);
    }

    // Export monthly CSV (wrapper for attendanceMonthly logic)
    public function exportMonthlyCsv(Request $request)
    {
        $year = $request->query('year', now()->year);
        if (!is_numeric($year) || strlen((string)$year) !== 4) {
            return response()->json(['error' => 'Invalid year'], 422);
        }

        $labels = [];
        $present = [];
        $izin = [];
        $sakit = [];

        for ($m = 1; $m <= 12; $m++) {
            $start = Carbon::create($year, $m, 1)->startOfMonth();
            $end = (clone $start)->endOfMonth();
            $labels[] = $start->format('Y-m');

            // Count total 'in' attendance records for the month
            $cntPresent = Attendance::whereBetween('created_at', [$start, $end->endOfDay()])->where('type', 'in')->count();
            $present[] = $cntPresent;

            $leaves = Leave::where('status', 'approved')
                ->where(function ($q) use ($start, $end) {
                    $q->whereBetween('start_date', [$start->toDateString(), $end->toDateString()])
                      ->orWhereBetween('end_date', [$start->toDateString(), $end->toDateString()])
                      ->orWhere(function ($q2) use ($start, $end) {
                          $q2->where('start_date', '<=', $start->toDateString())->where('end_date', '>=', $end->toDateString());
                      });
                })->get();

            $cntIzin = $leaves->where('type', 'izin')->count();
            $cntSakit = $leaves->where('type', 'sakit')->count();

            $izin[] = $cntIzin;
            $sakit[] = $cntSakit;
        }

        return response()->stream(function () use ($labels, $present, $izin, $sakit) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['month', 'present', 'izin', 'sakit']);
            foreach ($labels as $i => $label) {
                fputcsv($handle, [$label, $present[$i], $izin[$i], $sakit[$i]]);
            }
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="attendance_monthly_' . $year . '.csv"'
        ]);
    }
}
