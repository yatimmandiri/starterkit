<?php

namespace App\Http\Controllers\Admin\Sdm;

use App\Concerns\Traits\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sdm\StoreShiftRequest;
use App\Http\Requests\Sdm\UpdateShiftRequest;
use App\Models\Sdm\Shift;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShiftController extends Controller
{
    use LogActivity;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Shift::class);

        $data = [
            'pageTitle' => 'Shift List',
        ];

        return Inertia::render('admin/sdm/shifts/list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Shift::class);

        $data = [];

        return Inertia::render('admin/sdm/shifts/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShiftRequest $request)
    {
        $this->authorize('create', Shift::class);

        $shift = Shift::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($shift) {
            $this->logSuccess('create-shift', "Created Shift: {$shift->name}", [
                'shift_id' => $shift->id,
                'new_data' => $shift->toArray(),
            ]);
        } else {
            $this->logError('create-shift', "Failed To Create Shift: {$shift->name}", [
                'shift_id' => $shift->id,
                'new_data' => $shift->toArray(),
            ]);
        }

        return redirect()->route('admin.sdm.shifts.index')->with('success', 'Shift Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shift $shift)
    {
        $this->authorize('view', $shift);

        $data = [
            'shift' => $shift,
        ];

        return Inertia::render('admin/sdm/shifts/show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shift $shift)
    {
        $this->authorize('update', $shift);

        $data = [
            'shift' => $shift,
        ];

        return Inertia::render('admin/sdm/shifts/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShiftRequest $request, Shift $shift)
    {
        $this->authorize('update', $shift);

        $oldData = $shift->replicate();

        $shift->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($shift) {
            $this->logSuccess('update-shift', "Update Shift: {$shift->name}", [
                'shift_id' => $shift->id,
                'old_data' => $oldData->toArray(),
                'new_data' => $shift->toArray(),
            ]);
        } else {
            $this->logError('update-shift', "Failed To Update Shift: {$shift->name}", [
                'shift_id' => $shift->id,
                'old_data' => $oldData->toArray(),
                'new_data' => $shift->toArray(),
            ]);
        }

        return redirect()->route('admin.sdm.shifts.index')->with('success', 'Shift Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shift $shift)
    {
        $this->authorize('delete', $shift);

        $shift->delete();

        if ($shift) {
            $this->logSuccess('delete-shift', "Delete Shift: {$shift->name}", ['shift_id' => $shift->id]);
        } else {
            $this->logError('delete-shift', "Failed To Delete Shift: {$shift->name}", ['shift_id' => $shift->id]);
        }

        return redirect()->route('admin.sdm.shifts.index')->with('success', 'Shift Deleted Successfully');
    }

    public function getData(Request $request)
    {
        $this->authorize('data-shift', Shift::class);

        $perPage = $request->input('perPage', null);
        $page = $request->input('page', 1);
        $globalSearch = $request->input('globalSearch', '');
        $orderDirection = $request->input('orderDirection', 'desc');
        $orderBy = $request->input('orderBy', 'id');

        $query = Shift::query()
            ->search($globalSearch)
            ->orderBy($orderBy, $orderDirection);

        $data = $perPage
            ? $query->paginate($perPage, ['*'], 'page', $page)
            : $query->get();

        return response()->json($data);
    }
}
