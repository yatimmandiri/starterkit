<?php

namespace App\Http\Controllers\Admin\Sdm;

use App\Concerns\Traits\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sdm\StoreOfficeRequest;
use App\Http\Requests\Sdm\UpdateOfficeRequest;
use App\Models\Sdm\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OfficeController extends Controller
{
    use LogActivity;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Office::class);

        $data = [
            'pageTitle' => 'Office List',
        ];

        return Inertia::render('admin/sdm/offices/list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Office::class);

        $data = [
            'types' => ['Pusat', 'Regional', 'Cabang', 'Unit'],
        ];

        return Inertia::render('admin/sdm/offices/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOfficeRequest $request)
    {
        $this->authorize('create', Office::class);

        $office = Office::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'type' => $request->type,
            'parent_id' => $request->parent_id,
        ]);

        if ($office) {
            $this->logSuccess('create-office', "Created Office: {$office->name}", [
                'office_id' => $office->id,
                'new_data' => $office->toArray(),
            ]);
        } else {
            $this->logError('create-office', "Failed To Create Office: {$office->name}", [
                'office_id' => $office->id,
                'new_data' => $office->toArray(),
            ]);
        }

        return redirect()->route('admin.sdm.offices.index')->with('success', 'Office Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Office $office)
    {
        $this->authorize('view', $office);

        $office->load(['parent', 'children']);

        $data = [
            'office' => $office,
        ];

        return Inertia::render('admin/sdm/offices/show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Office $office)
    {
        $this->authorize('update', $office);

        $office->load(['parent', 'children']);

        $data = [
            'office' => $office,
            'types'  => ['Pusat', 'Regional', 'Cabang', 'Unit'],
        ];

        return Inertia::render('admin/sdm/offices/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOfficeRequest $request, Office $office)
    {
        $this->authorize('update', $office);

        $oldData = $office->replicate();

        $office->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'type' => $request->type,
            'parent_id' => $request->parent_id,
        ]);

        if ($office) {
            $this->logSuccess('update-office', "Update Office: {$office->name}", [
                'office_id' => $office->id,
                'old_data' => $oldData->toArray(),
                'new_data' => $office->toArray(),
            ]);
        } else {
            $this->logError('update-office', "Failed To Update Office: {$office->name}", [
                'office_id' => $office->id,
                'old_data' => $oldData->toArray(),
                'new_data' => $office->toArray(),
            ]);
        }

        return redirect()->route('admin.sdm.offices.index')->with('success', 'Office Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Office $office)
    {
        $this->authorize('delete', $office);

        $office->delete();

        if ($office) {
            $this->logSuccess('delete-office', "Delete Office: {$office->name}", ['office_id' => $office->id]);
        } else {
            $this->logError('delete-office', "Failed To Delete Office: {$office->name}", ['office_id' => $office->id]);
        }

        return redirect()->route('admin.sdm.offices.index')->with('success', 'Office Deleted Successfully');
    }

    public function updateStatus(Office $office)
    {
        $this->authorize('update', $office);

        $office->update([
            'status' => !$office->status,
        ]);

        return redirect()->back()->with('success', 'Status Updated Successfully');
    }

    public function reOrder(Request $request)
    {
        $this->authorize('data-office', Office::class);

        $request->validate([
            'data' => 'required|array',
            'data.*.regional_id' => 'required|integer',
            'data.*.branches' => 'required|array',
            'data.*.branches.*.id' => 'required|integer',
            'data.*.branches.*.sort' => 'required|integer',
        ]);

        // Menggunakan Database Transaction demi keamanan data masal
        DB::transaction(function () use ($request) {
            foreach ($request->data as $regional) {
                $regionalId = $regional['regional_id'];

                foreach ($regional['branches'] as $branch) {
                    DB::table('offices') // ganti dengan nama tabel Anda
                        ->where('id', $branch['id'])
                        ->update([
                            'sort' => $branch['sort'],
                            'parent_id' => $regionalId,
                            'updated_at' => now()
                        ]);
                }
            }
        });

        return redirect()->back()->with('success', 'Data Reordered Successfully');
    }

    public function getData(Request $request)
    {
        $this->authorize('data-office', Office::class);

        $perPage = $request->input('perPage', null);
        $page = $request->input('page', 1);
        $globalSearch = $request->input('globalSearch', '');
        $orderDirection = $request->input('orderDirection', 'asc');
        $orderBy = $request->input('orderBy', 'id');

        $query = Office::query()
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
