<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Penalty;
use Illuminate\View\View;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{

    /**
     * index
     * @param Request $request
     * @return View
     */
    public function __invoke(
        Request $request,
    ): View {
        $employees = User::whereHasRole('employee')->get();
        $reports = $employees->map(function ($employee) {
            return [
                'name' => $employee->name,
                'actions' => ActivityLog::where('user_id', $employee->id)->whereNotIn('action', ['login', 'logout', 'idle_session'])->count(),
                'idle_sessions' => ActivityLog::where('user_id', $employee->id)->where('action', 'idle_session')->count(),
                'penalties' => Penalty::where('user_id', $employee->id)->count(),
            ];
        });

        return view('employees.index', compact('reports'));
    }
}
