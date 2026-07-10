<?php

namespace App\Http\Controllers\Admin\Sdm;

use App\Concerns\Traits\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sdm\StoreGradeRequest;
use App\Http\Requests\Sdm\UpdateGradeRequest;
use App\Models\Sdm\Grade;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GradeController extends Controller
{
    use LogActivity;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Grade::class);

        $data = [
            'pageTitle' => 'Grade List',
        ];

        return Inertia::render('admin/sdm/grades/list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Grade::class);

        $data = [];

        return Inertia::render('admin/sdm/grades/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGradeRequest $request)
    {
        $this->authorize('create', Grade::class);

        $grade = Grade::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($grade) {
            $this->logSuccess('create-grade', "Created Grade: {$grade->name}", [
                'grade_id' => $grade->id,
                'new_data' => $grade->toArray(),
            ]);
        } else {
            $this->logError('create-grade', "Failed To Create Grade: {$grade->name}", [
                'grade_id' => $grade->id,
                'new_data' => $grade->toArray(),
            ]);
        }

        return redirect()->route('admin.sdm.grades.index')->with('success', 'Grade Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Grade $grade)
    {
        $this->authorize('view', $grade);

        $data = [
            'grade' => $grade,
        ];

        return Inertia::render('admin/sdm/grades/show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grade $grade)
    {
        $this->authorize('update', $grade);

        $data = [
            'grade' => $grade,
        ];

        return Inertia::render('admin/sdm/grades/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGradeRequest $request, Grade $grade)
    {
        $this->authorize('update', $grade);

        $oldData = $grade->replicate();

        $grade->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($grade) {
            $this->logSuccess('update-grade', "Update Grade: {$grade->name}", [
                'grade_id' => $grade->id,
                'old_data' => $oldData->toArray(),
                'new_data' => $grade->toArray(),
            ]);
        } else {
            $this->logError('update-grade', "Failed To Update Grade: {$grade->name}", [
                'Grade_id' => $grade->id,
                'old_data' => $oldData->toArray(),
                'new_data' => $grade->toArray(),
            ]);
        }

        return redirect()->route('admin.sdm.grades.index')->with('success', 'Grade Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        $this->authorize('delete', $grade);

        $grade->delete();

        if ($grade) {
            $this->logSuccess('delete-grade', "Delete Grade: {$grade->name}", ['Grade_id' => $grade->id]);
        } else {
            $this->logError('delete-grade', "Failed To Delete Grade: {$grade->name}", ['Grade_id' => $grade->id]);
        }

        return redirect()->route('admin.sdm.grades.index')->with('success', 'Grade Deleted Successfully');
    }

    public function getData(Request $request)
    {
        $this->authorize('data-grade', Grade::class);

        $perPage = $request->input('perPage', null);
        $page = $request->input('page', 1);
        $globalSearch = $request->input('globalSearch', '');
        $orderDirection = $request->input('orderDirection', 'desc');
        $orderBy = $request->input('orderBy', 'id');

        $query = Grade::query()
            ->search($globalSearch)
            ->orderBy($orderBy, $orderDirection);

        $data = $perPage
            ? $query->paginate($perPage, ['*'], 'page', $page)
            : $query->get();

        return response()->json($data);
    }
}
