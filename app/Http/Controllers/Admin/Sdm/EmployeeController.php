<?php

namespace App\Http\Controllers\Admin\Sdm;

use App\Concerns\Traits\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sdm\StoreEmployeeRequest;
use App\Http\Requests\Sdm\UpdateEmployeeRequest;
use App\Models\Sdm\Employee;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    use LogActivity;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Employee::class);

        $data = [
            'pageTitle' => 'Employee List',
        ];

        return Inertia::render('admin/sdm/employees/list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Employee::class);

        $data = [];

        return Inertia::render('admin/sdm/employees/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        $this->authorize('create', Employee::class);

        $employee = Employee::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($employee) {
            $this->logSuccess('create-employee', "Created Employee: {$employee->name}", [
                'employee_id' => $employee->id,
                'new_data' => $employee->toArray(),
            ]);
        } else {
            $this->logError('create-employee', "Failed To Create Employee: {$employee->name}", [
                'employee_id' => $employee->id,
                'new_data' => $employee->toArray(),
            ]);
        }

        return redirect()->route('admin.sdm.employees.index')->with('success', 'Employee Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $this->authorize('view', $employee);

        $data = [
            'employee' => $employee,
        ];

        return Inertia::render('admin/sdm/employees/show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $this->authorize('update', $employee);

        $data = [
            'employee' => $employee,
        ];

        return Inertia::render('admin/sdm/employees/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $this->authorize('update', $employee);

        $oldData = $employee->replicate();

        $employee->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($employee) {
            $this->logSuccess('update-employee', "Update Employee: {$employee->name}", [
                'employee_id' => $employee->id,
                'old_data' => $oldData->toArray(),
                'new_data' => $employee->toArray(),
            ]);
        } else {
            $this->logError('update-employee', "Failed To Update Employee: {$employee->name}", [
                'employee_id' => $employee->id,
                'old_data' => $oldData->toArray(),
                'new_data' => $employee->toArray(),
            ]);
        }

        return redirect()->route('admin.sdm.employees.index')->with('success', 'Employee Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $this->authorize('delete', $employee);

        $employee->delete();

        if ($employee) {
            $this->logSuccess('delete-employee', "Delete Employee: {$employee->name}", ['employee_id' => $employee->id]);
        } else {
            $this->logError('delete-employee', "Failed To Delete Employee: {$employee->name}", ['employee_id' => $employee->id]);
        }

        return redirect()->route('admin.sdm.employees.index')->with('success', 'Employee Deleted Successfully');
    }

    public function updateStatus(Employee $employee)
    {
        $this->authorize('update', $employee);

        $employee->update([
            'status' => !$employee->status,
        ]);

        return redirect()->back()->with('success', 'Status Updated Successfully');
    }

    public function getData(Request $request)
    {
        $this->authorize('data-employee', Employee::class);

        $perPage = $request->input('perPage', null);
        $page = $request->input('page', 1);
        $globalSearch = $request->input('globalSearch', '');
        $orderDirection = $request->input('orderDirection', 'desc');
        $orderBy = $request->input('orderBy', 'id');

        $query = Employee::query()
            ->with(['position'])
            ->search($globalSearch)
            ->orderBy($orderBy, $orderDirection);

        $data = $perPage
            ? $query->paginate($perPage, ['*'], 'page', $page)
            : $query->get();

        return response()->json($data);
    }
}
