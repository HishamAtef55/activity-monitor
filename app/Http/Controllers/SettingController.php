<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Setting;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;


class SettingController extends Controller
{


    /**
     * index
     * @param Request $request
     * @return View
     */
    public function index(
        Request $request
    ): View {
        $idleTime = Setting::getIdleTimeout();         
        $roles  = Role::get();
        return view('settings.list', compact('idleTime','roles'));
    }
                                                                    

    /**
     * update
     * @param  Request $request
     * @return RedirectResponse
     */
    public function update(
        Request $request
    ): RedirectResponse {
        
        try {

            Setting::where('key', 'idle_timeout')->first()?->update([
                'value' => $request->idle_time
            ]);

            return redirect(route('settings.list'))
                ->withInput();

        } catch (\Throwable $th) {

            Log::error('update settings  error: ' . $th->getMessage());

            return redirect(route('settings.list'))
                ->withInput();
        }
    }


}