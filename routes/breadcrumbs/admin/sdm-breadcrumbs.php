<?php

use Diglactic\Breadcrumbs\Breadcrumbs;

// Offices
Breadcrumbs::for(
    'admin.sdm.offices.index',
    fn($trail) =>
    $trail->parent('admin.dashboard')->push('Offices', route('admin.sdm.offices.index'))
);

Breadcrumbs::for(
    'admin.sdm.offices.create',
    fn($trail) =>
    $trail->parent('admin.sdm.offices.index')->push('Create', route('admin.sdm.offices.create'))
);

Breadcrumbs::for(
    'admin.sdm.offices.show',
    fn($trail, $item) =>
    $trail->parent('admin.sdm.offices.index')->push($item->name, route('admin.sdm.offices.show', $item))
);

Breadcrumbs::for(
    'admin.sdm.offices.edit',
    fn($trail, $item) =>
    $trail->parent('admin.sdm.offices.show', $item)->push('Edit', route('admin.sdm.offices.edit', $item))
);

Breadcrumbs::for(
    'admin.sdm.offices.data',
    fn($trail) =>
    $trail->parent('admin.sdm.offices.index')->push('Offices Data', route('admin.sdm.offices.data'))
);

// Grades
Breadcrumbs::for(
    'admin.sdm.grades.index',
    fn($trail) =>
    $trail->parent('admin.dashboard')->push('Grades', route('admin.sdm.grades.index'))
);

Breadcrumbs::for(
    'admin.sdm.grades.create',
    fn($trail) =>
    $trail->parent('admin.sdm.grades.index')->push('Create', route('admin.sdm.grades.create'))
);

Breadcrumbs::for(
    'admin.sdm.grades.show',
    fn($trail, $item) =>
    $trail->parent('admin.sdm.grades.index')->push($item->name, route('admin.sdm.grades.show', $item))
);

Breadcrumbs::for(
    'admin.sdm.grades.edit',
    fn($trail, $item) =>
    $trail->parent('admin.sdm.grades.show', $item)->push('Edit', route('admin.sdm.grades.edit', $item))
);

Breadcrumbs::for(
    'admin.sdm.grades.data',
    fn($trail) =>
    $trail->parent('admin.sdm.grades.index')->push('Grades Data', route('admin.sdm.grades.data'))
);

// Positions
Breadcrumbs::for(
    'admin.sdm.positions.index',
    fn($trail) =>
    $trail->parent('admin.dashboard')->push('Positions', route('admin.sdm.positions.index'))
);

Breadcrumbs::for(
    'admin.sdm.positions.create',
    fn($trail) =>
    $trail->parent('admin.sdm.positions.index')->push('Create', route('admin.sdm.positions.create'))
);

Breadcrumbs::for(
    'admin.sdm.positions.show',
    fn($trail, $item) =>
    $trail->parent('admin.sdm.positions.index')->push($item->name, route('admin.sdm.positions.show', $item))
);

Breadcrumbs::for(
    'admin.sdm.positions.edit',
    fn($trail, $item) =>
    $trail->parent('admin.sdm.positions.show', $item)->push('Edit', route('admin.sdm.positions.edit', $item))
);

Breadcrumbs::for(
    'admin.sdm.positions.data',
    fn($trail) =>
    $trail->parent('admin.sdm.positions.index')->push('Positions Data', route('admin.sdm.positions.data'))
);

// Shifts
Breadcrumbs::for(
    'admin.sdm.shifts.index',
    fn($trail) =>
    $trail->parent('admin.dashboard')->push('Shifts', route('admin.sdm.shifts.index'))
);

Breadcrumbs::for(
    'admin.sdm.shifts.create',
    fn($trail) =>
    $trail->parent('admin.sdm.shifts.index')->push('Create', route('admin.sdm.shifts.create'))
);

Breadcrumbs::for(
    'admin.sdm.shifts.show',
    fn($trail, $item) =>
    $trail->parent('admin.sdm.shifts.index')->push($item->name, route('admin.sdm.shifts.show', $item))
);

Breadcrumbs::for(
    'admin.sdm.shifts.edit',
    fn($trail, $item) =>
    $trail->parent('admin.sdm.shifts.show', $item)->push('Edit', route('admin.sdm.shifts.edit', $item))
);

Breadcrumbs::for(
    'admin.sdm.shifts.data',
    fn($trail) =>
    $trail->parent('admin.sdm.shifts.index')->push('Shifts Data', route('admin.sdm.shifts.data'))
);

// Contracts
Breadcrumbs::for(
    'admin.sdm.contracts.index',
    fn($trail) =>
    $trail->parent('admin.dashboard')->push('Contracts', route('admin.sdm.contracts.index'))
);

Breadcrumbs::for(
    'admin.sdm.contracts.create',
    fn($trail) =>
    $trail->parent('admin.sdm.contracts.index')->push('Create', route('admin.sdm.contracts.create'))
);

Breadcrumbs::for(
    'admin.sdm.contracts.show',
    fn($trail, $item) =>
    $trail->parent('admin.sdm.contracts.index')->push($item->name, route('admin.sdm.contracts.show', $item))
);

Breadcrumbs::for(
    'admin.sdm.contracts.edit',
    fn($trail, $item) =>
    $trail->parent('admin.sdm.contracts.show', $item)->push('Edit', route('admin.sdm.contracts.edit', $item))
);

Breadcrumbs::for(
    'admin.sdm.contracts.data',
    fn($trail) =>
    $trail->parent('admin.sdm.contracts.index')->push('Contracts Data', route('admin.sdm.contracts.data'))
);

// Holidays
Breadcrumbs::for(
    'admin.sdm.holidays.index',
    fn($trail) =>
    $trail->parent('admin.dashboard')->push('Holidays', route('admin.sdm.holidays.index'))
);

Breadcrumbs::for(
    'admin.sdm.holidays.create',
    fn($trail) =>
    $trail->parent('admin.sdm.holidays.index')->push('Create', route('admin.sdm.holidays.create'))
);

Breadcrumbs::for(
    'admin.sdm.holidays.show',
    fn($trail, $item) =>
    $trail->parent('admin.sdm.holidays.index')->push($item->name, route('admin.sdm.holidays.show', $item))
);

Breadcrumbs::for(
    'admin.sdm.holidays.edit',
    fn($trail, $item) =>
    $trail->parent('admin.sdm.holidays.show', $item)->push('Edit', route('admin.sdm.holidays.edit', $item))
);

Breadcrumbs::for(
    'admin.sdm.holidays.data',
    fn($trail) =>
    $trail->parent('admin.sdm.holidays.index')->push('Holidays Data', route('admin.sdm.holidays.data'))
);

// Employees
Breadcrumbs::for(
    'admin.sdm.employees.index',
    fn($trail) =>
    $trail->parent('admin.dashboard')->push('Employees', route('admin.sdm.employees.index'))
);

Breadcrumbs::for(
    'admin.sdm.employees.create',
    fn($trail) =>
    $trail->parent('admin.sdm.employees.index')->push('Create', route('admin.sdm.employees.create'))
);

Breadcrumbs::for(
    'admin.sdm.employees.show',
    fn($trail, $item) =>
    $trail->parent('admin.sdm.employees.index')->push($item->name, route('admin.sdm.employees.show', $item))
);

Breadcrumbs::for(
    'admin.sdm.employees.edit',
    fn($trail, $item) =>
    $trail->parent('admin.sdm.employees.show', $item)->push('Edit', route('admin.sdm.employees.edit', $item))
);

Breadcrumbs::for(
    'admin.sdm.employees.data',
    fn($trail) =>
    $trail->parent('admin.sdm.employees.index')->push('Employees Data', route('admin.sdm.employees.data'))
);
