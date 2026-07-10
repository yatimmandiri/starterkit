<?php

namespace App\Http\Controllers\Admin\Sdm;

use App\Concerns\Traits\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sdm\StoreHolidayRequest;
use App\Http\Requests\Sdm\UpdateHolidayRequest;
use App\Models\Sdm\Holiday;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HolidayController extends Controller
{
    use LogActivity;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Holiday::class);

        $data = [
            'pageTitle' => 'Holiday List',
        ];

        return Inertia::render('admin/sdm/holidays/list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Holiday::class);

        $data = [];

        return Inertia::render('admin/sdm/holidays/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHolidayRequest $request)
    {
        $this->authorize('create', Holiday::class);

        $holiday = Holiday::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($holiday) {
            $this->logSuccess('create-holiday', "Created Holiday: {$holiday->name}", [
                'holiday_id' => $holiday->id,
                'new_data' => $holiday->toArray(),
            ]);
        } else {
            $this->logError('create-holiday', "Failed To Create Holiday: {$holiday->name}", [
                'holiday_id' => $holiday->id,
                'new_data' => $holiday->toArray(),
            ]);
        }

        return redirect()->route('admin.sdm.holidays.index')->with('success', 'Holiday Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Holiday $holiday)
    {
        $this->authorize('view', $holiday);

        $data = [
            'holiday' => $holiday,
        ];

        return Inertia::render('admin/sdm/holidays/show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Holiday $holiday)
    {
        $this->authorize('update', $holiday);

        $data = [
            'holiday' => $holiday,
        ];

        return Inertia::render('admin/sdm/holidays/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHolidayRequest $request, Holiday $holiday)
    {
        $this->authorize('update', $holiday);

        $oldData = $holiday->replicate();

        $holiday->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($holiday) {
            $this->logSuccess('update-holiday', "Update Holiday: {$holiday->name}", [
                'holiday_id' => $holiday->id,
                'old_data' => $oldData->toArray(),
                'new_data' => $holiday->toArray(),
            ]);
        } else {
            $this->logError('update-holiday', "Failed To Update Holiday: {$holiday->name}", [
                'holiday_id' => $holiday->id,
                'old_data' => $oldData->toArray(),
                'new_data' => $holiday->toArray(),
            ]);
        }

        return redirect()->route('admin.sdm.holidays.index')->with('success', 'Holiday Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Holiday $holiday)
    {
        $this->authorize('delete', $holiday);

        $holiday->delete();

        if ($holiday) {
            $this->logSuccess('delete-holiday', "Delete Holiday: {$holiday->name}", ['holiday_id' => $holiday->id]);
        } else {
            $this->logError('delete-holiday', "Failed To Delete Holiday: {$holiday->name}", ['holiday_id' => $holiday->id]);
        }

        return redirect()->route('admin.sdm.holidays.index')->with('success', 'Holiday Deleted Successfully');
    }

    public function getData(Request $request)
    {
        $this->authorize('data-holiday', Holiday::class);

        $perPage = $request->input('perPage', null);
        $page = $request->input('page', 1);
        $globalSearch = $request->input('globalSearch', '');
        $orderDirection = $request->input('orderDirection', 'desc');
        $orderBy = $request->input('orderBy', 'id');

        $query = Holiday::query()
            ->search($globalSearch)
            ->orderBy($orderBy, $orderDirection);

        $data = $perPage
            ? $query->paginate($perPage, ['*'], 'page', $page)
            : $query->get();

        return response()->json($data);
    }
}
