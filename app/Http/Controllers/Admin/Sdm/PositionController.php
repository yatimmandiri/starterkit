<?php

namespace App\Http\Controllers\Admin\Sdm;

use App\Concerns\Traits\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sdm\StorePositionRequest;
use App\Http\Requests\Sdm\UpdatePositionRequest;
use App\Models\Sdm\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PositionController extends Controller
{
    use LogActivity;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Position::class);

        $data = [
            'pageTitle' => 'Position List',
        ];

        return Inertia::render('admin/sdm/positions/list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Position::class);

        $data = [
            'types' => ['Pusat', 'Regional', 'Cabang', 'Unit'],
            'workTypes' => ['Dalam', 'Lapangan'],
        ];

        return Inertia::render('admin/sdm/positions/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePositionRequest $request)
    {
        $this->authorize('create', Position::class);

        $position = Position::create([
            'name' => $request->name,
            'office_type' => $request->office_type,
            'work_type' => $request->work_type,
            'parent_id' => $request->parent_id,
        ]);

        if ($position) {
            $this->logSuccess('create-position', "Created Position: {$position->name}", [
                'position_id' => $position->id,
                'new_data' => $position->toArray(),
            ]);
        } else {
            $this->logError('create-position', "Failed To Create Position: {$position->name}", [
                'position_id' => $position->id,
                'new_data' => $position->toArray(),
            ]);
        }

        return redirect()->route('admin.sdm.positions.index')->with('success', 'Position Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Position $position)
    {
        $this->authorize('view', $position);

        $position->load(['parent', 'children']);

        $data = [
            'position' => $position,
        ];

        return Inertia::render('admin/sdm/positions/show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Position $position)
    {
        $this->authorize('update', $position);

        $position->load(['parent', 'children']);

        $data = [
            'position' => $position,
            'types'  => ['Pusat', 'Regional', 'Cabang', 'Unit'],
            'workTypes' => ['Dalam', 'Lapangan'],
        ];

        return Inertia::render('admin/sdm/positions/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePositionRequest $request, Position $position)
    {
        $this->authorize('update', $position);

        $oldData = $position->replicate();

        $position->update([
            'name' => $request->name,
            'office_type' => $request->office_type,
            'work_type' => $request->work_type,
            'parent_id' => $request->parent_id,
        ]);

        if ($position) {
            $this->logSuccess('update-position', "Update Position: {$position->name}", [
                'position_id' => $position->id,
                'old_data' => $oldData->toArray(),
                'new_data' => $position->toArray(),
            ]);
        } else {
            $this->logError('update-position', "Failed To Update Position: {$position->name}", [
                'position_id' => $position->id,
                'old_data' => $oldData->toArray(),
                'new_data' => $position->toArray(),
            ]);
        }

        return redirect()->route('admin.sdm.positions.index')->with('success', 'Position Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position)
    {
        $this->authorize('delete', $position);

        $position->delete();

        if ($position) {
            $this->logSuccess('delete-position', "Delete Position: {$position->name}", ['Position_id' => $position->id]);
        } else {
            $this->logError('delete-position', "Failed To Delete Position: {$position->name}", ['Position_id' => $position->id]);
        }

        return redirect()->route('admin.sdm.positions.index')->with('success', 'Position Deleted Successfully');
    }

    public function updateStatus(Position $position)
    {
        $this->authorize('update', $position);

        $position->update([
            'status' => !$position->status,
        ]);

        return redirect()->back()->with('success', 'Status Updated Successfully');
    }

    public function reOrder(Request $request)
    {
        $this->authorize('data-position', Position::class);

        $request->validate([
            'data' => 'required|array',
            'data.*.id' => 'required|integer|exists:positions,id',
            'data.*.parent_id' => 'nullable|integer|exists:positions,id',
            'data.*.sort' => 'required|integer',
        ]);

        // 1. Validasi Tambahan: Ambil peta parent-child baru dari request untuk dicek
        $allPositions = collect($request->data)->pluck('parent_id', 'id')->toArray();

        foreach ($request->data as $row) {
            if ($row['parent_id'] !== null) {
                if ($this->isCircular($row['id'], $row['parent_id'], $allPositions)) {
                    return redirect()->back()->withErrors([
                        'error' => 'Struktur hirarki tidak valid! Terdeteksi circular reference (jabatan saling membawahi).'
                    ]);
                }
            }
        }

        // 2. Eksekusi Database Transaction jika validasi lolos
        DB::transaction(function () use ($request) {
            foreach ($request->data as $row) {
                DB::table('positions')
                    ->where('id', $row['id'])
                    ->update([
                        'parent_id' => $row['parent_id'],
                        'sort'      => $row['sort'],
                        'updated_at' => now()
                    ]);
            }
        });

        return redirect()->back()->with('success', 'Struktur Hirarki Jabatan Berhasil Diperbarui');
    }

    /**
     * Helper Rekursif untuk mendeteksi Circular Reference
     */
    private function isCircular($movedId, $targetParentId, array $allPositions): bool
    {
        // Jika parent baru adalah dirinya sendiri
        if ($movedId == $targetParentId) {
            return true;
        }

        $currentParentId = $targetParentId;

        // Telusuri ke atas sepanjang rantai atasan
        while ($currentParentId !== null) {
            // Jika di tengah jalan bertemu dengan ID yang digeser, berarti terjadi looping
            if ($currentParentId == $movedId) {
                return true;
            }

            // Ambil atasan berikutnya dari payload request, jika tidak ada ambil dari DB (fallback)
            if (array_key_exists($currentParentId, $allPositions)) {
                $currentParentId = $allPositions[$currentParentId];
            } else {
                $parentInDb = DB::table('positions')->where('id', $currentParentId)->value('parent_id');
                $currentParentId = $parentInDb;
            }
        }

        return false;
    }

    public function getData(Request $request)
    {
        $this->authorize('data-position', Position::class);

        $perPage = $request->input('perPage', null);
        $page = $request->input('page', 1);
        $globalSearch = $request->input('globalSearch', '');
        $orderDirection = $request->input('orderDirection', 'asc');
        $orderBy = $request->input('orderBy', 'id');

        $query = Position::query()
            ->select(['id', 'name', 'parent_id', 'status'])
            ->with(['parent', 'children'])
            ->search($globalSearch)
            ->orderBy($orderBy, $orderDirection);

        $data = $perPage
            ? $query->paginate($perPage, ['*'], 'page', $page)
            : $query->get();

        return response()->json($data);
    }
}
