<?php

namespace App\Http\Controllers\Admin\Sdm;

use App\Concerns\Traits\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sdm\StoreContractRequest;
use App\Http\Requests\Sdm\UpdateContractRequest;
use App\Models\Sdm\Contract;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContractController extends Controller
{
    use LogActivity;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Contract::class);

        $data = [
            'pageTitle' => 'Contract List',
        ];

        return Inertia::render('admin/sdm/contracts/list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Contract::class);

        $data = [];

        return Inertia::render('admin/sdm/contracts/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractRequest $request)
    {
        $this->authorize('create', Contract::class);

        $contract = Contract::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($contract) {
            $this->logSuccess('create-contract', "Created Contract: {$contract->name}", [
                'contract_id' => $contract->id,
                'new_data' => $contract->toArray(),
            ]);
        } else {
            $this->logError('create-contract', "Failed To Create Contract: {$contract->name}", [
                'contract_id' => $contract->id,
                'new_data' => $contract->toArray(),
            ]);
        }

        return redirect()->route('admin.sdm.contracts.index')->with('success', 'Contract Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        $this->authorize('view', $contract);

        $data = [
            'contract' => $contract,
        ];

        return Inertia::render('admin/sdm/contracts/show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract)
    {
        $this->authorize('update', $contract);

        $data = [
            'contract' => $contract,
        ];

        return Inertia::render('admin/sdm/contracts/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractRequest $request, Contract $contract)
    {
        $this->authorize('update', $contract);

        $oldData = $contract->replicate();

        $contract->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($contract) {
            $this->logSuccess('update-contract', "Update Contract: {$contract->name}", [
                'contract_id' => $contract->id,
                'old_data' => $oldData->toArray(),
                'new_data' => $contract->toArray(),
            ]);
        } else {
            $this->logError('update-contract', "Failed To Update Contract: {$contract->name}", [
                'contract_id' => $contract->id,
                'old_data' => $oldData->toArray(),
                'new_data' => $contract->toArray(),
            ]);
        }

        return redirect()->route('admin.sdm.contracts.index')->with('success', 'Contract Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        $this->authorize('delete', $contract);

        $contract->delete();

        if ($contract) {
            $this->logSuccess('delete-contract', "Delete Contract: {$contract->name}", ['contract_id' => $contract->id]);
        } else {
            $this->logError('delete-contract', "Failed To Delete Contract: {$contract->name}", ['contract_id' => $contract->id]);
        }

        return redirect()->route('admin.sdm.contracts.index')->with('success', 'Contract Deleted Successfully');
    }

    public function getData(Request $request)
    {
        $this->authorize('data-contract', Contract::class);

        $perPage = $request->input('perPage', null);
        $page = $request->input('page', 1);
        $globalSearch = $request->input('globalSearch', '');
        $orderDirection = $request->input('orderDirection', 'desc');
        $orderBy = $request->input('orderBy', 'id');

        $query = Contract::query()
            ->search($globalSearch)
            ->orderBy($orderBy, $orderDirection);

        $data = $perPage
            ? $query->paginate($perPage, ['*'], 'page', $page)
            : $query->get();

        return response()->json($data);
    }
}
