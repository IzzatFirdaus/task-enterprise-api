<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AuditLogController extends Controller
{
    /**
     * Display the audit log page.
     */
    public function index(Request $request): View
    {
        $this->ensureSuperAdmin($request);

        $query = AuditLog::query()->with('admin');

        if ($request->filled('admin_id')) {
            $query->where('admin_id', $request->input('admin_id'));
        }

        if ($request->filled('action')) {
            $query->where('action', $request->input('action'));
        }

        if ($request->filled('model_type')) {
            $query->where('model_type', $request->input('model_type'));
        }

        $logs = $query->latest('created_at')->paginate(25);

        return view('admin.audit-logs', compact('logs'));
    }

    /**
     * Return audit logs for the admin API.
     */
    public function apiIndex(Request $request): JsonResponse
    {
        $this->ensureSuperAdmin($request);

        $query = AuditLog::query()->with('admin');

        if ($request->filled('admin_id')) {
            $query->where('admin_id', $request->input('admin_id'));
        }

        if ($request->filled('action')) {
            $query->where('action', $request->input('action'));
        }

        if ($request->filled('model_type')) {
            $query->where('model_type', $request->input('model_type'));
        }

        return response()->json($query->latest('created_at')->paginate(25));
    }

    /**
     * Display a log entry.
     */
    public function show(AuditLog $auditLog): View
    {
        $this->ensureSuperAdmin(request());

        return view('admin.audit-log-show', ['log' => $auditLog->load('admin')]);
    }

    /**
     * Return a single audit log record for API consumers.
     */
    public function apiShow(AuditLog $auditLog): JsonResponse
    {
        $this->ensureSuperAdmin(request());

        return response()->json($auditLog->load('admin'));
    }

    /**
     * Export logs as CSV.
     */
    public function export(Request $request): Response
    {
        $this->ensureSuperAdmin($request);

        $logs = AuditLog::query()->with('admin')->latest('created_at')->get();
        $output = fopen('php://temp', 'wb+');

        fputcsv($output, ['admin_id', 'action', 'model_type', 'model_id', 'changes', 'ip_address', 'user_agent', 'created_at']);

        foreach ($logs as $log) {
            fputcsv($output, [
                $log->admin_id,
                $log->action,
                $log->model_type,
                $log->model_id,
                json_encode($log->changes),
                $log->ip_address,
                $log->user_agent,
                $log->created_at?->toDateTimeString(),
            ]);
        }

        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="audit-logs.csv"',
        ]);
    }

    /**
     * Export audit logs in the admin API.
     */
    public function apiExport(Request $request): StreamedResponse
    {
        return $this->export($request);
    }

    /**
     * Display the settings form.
     */
    public function settings(): View
    {
        return view('admin.settings');
    }

    private function ensureSuperAdmin(Request $request): void
    {
        abort_unless($request->user()?->isSuperAdmin(), 403, 'Super administrator access is required.');
    }
}
