<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Core\LogActivity;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LogActivityController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', LogActivity::class);

        $data = [];

        return Inertia::render('admin/core/log-activity/list', $data);
    }

    public function getData(Request $request)
    {
        $this->authorize('data-log-activity', LogActivity::class);

        $perPage = $request->input('perPage', null);
        $page = $request->input('page', 1);
        $globalSearch = $request->input('globalSearch', '');
        $orderDirection = $request->input('orderDirection', 'desc');
        $orderBy = $request->input('orderBy', 'id');

        $query = LogActivity::query()
            ->with(['users'])
            ->latest()
            ->search($globalSearch)
            ->orderBy($orderBy, $orderDirection);

        $data = $perPage
            ? $query->paginate($perPage, ['*'], 'page', $page)
            : $query->get();

        return response()->json($data);
    }
}
