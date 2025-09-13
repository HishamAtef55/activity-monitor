<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{

    /**
     * index
     * @param Request $request
     * @return View
     */
    public function __invoke(
        Request $request,
        Role $role
    ): RedirectResponse {
        $role->update([
            'idle_monitoring' => !$role->idle_monitoring,
        ]);
        return to_route('settings.list');
    }
}
