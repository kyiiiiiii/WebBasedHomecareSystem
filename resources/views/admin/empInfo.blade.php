@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('content')
<div class="row w-100 h-100">
    <div class="col">
        <div class="row color2 containerShadow2 p-4 textstyle mb-3">
            <h1 class="col-12 col-md" style="font-size: 2rem">
                Employees
            </h1>
            <div class="col-12 col-md d-flex justify-content-start justify-content-md-end align-items-center">
                <a href="{{ route('showEmpForm') }}" class="btn btn-outline-light textstyle">
                    <i class="fa-regular fa-plus me-2"></i> Add Employee
                </a>
            </div>
        </div>

        <div class="row mb-3 gap-3">
            <div class="col-md-2 textstyle containerShadow2">
                <div class="row p-1 color2 textstyle5">
                    <div class="col d-flex justify-content-center">
                        Statistic
                    </div>
                </div>
                <div class="row">
                    <div class="col d-flex justify-content-center align-items-center">
                        <canvas class="p-2" id="employeeTypeChart" style="max-height:200px"></canvas>
                    </div>
                </div>
            </div>
            <div class="col textstyle containerShadow2">
                <div class="row p-1 color2 textstyle5">
                    <div class="col d-flex justify-content-center">
                        Statistic
                    </div>
                </div>
                <div class="row">
                    <div class="col d-flex justify-content-center align-items-center">
                        <canvas id="turnoverRateChart" style="max-height:200px"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-2 textstyle3 containerShadow2 p-5">
                <div class="row align-items-center justify-content-center text-center">
                    <div class="col">
                        <div class="label pb-lg-4">Total Employees</div>
                        <i class="fa-solid fa-user d-none d-md-block" style="font-size: 2.0rem; color:#1d3557;"></i>
                        <div class="value" style="font-size: 2rem; color:rgb(13, 116, 201)">{{ $totalEmployees }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row containerShadow2">
            <div class="col">
                <div class="row containerShadow2">
                    <div class="col">
                        <div class="row color2 textstyle p-2 align-items-center text-center">
                            <div class="col">Employee ID</div>
                            <div class="col">Employee Name</div>
                            <div class="col">Employee Type</div>
                            <div class="col">Role</div>
                            <div class="col">Status</div>
                            <div class="col">Joined At</div>
                            <div class="col-md-2"></div>
                        </div>
                        @foreach($employees as $employee)
                        <div class="p-2 row align-items-center textstyle4 text-center">
                            <div class="col">{{ $employee->id }}</div>
                            <div class="col">{{ $employee->name }}</div>
                            <div class="col">{{ $employee->type }}</div>
                            <div class="col">{{ $employee->role }}</div>
                            <div class="col text-center">{{ $employee->status }}</div>
                            <div class="col">{{ $employee->created_at->format('d/m/Y') }}</div>
                            <div class="col-md-1 mt-md-0 mt-3">
                                <a href="{{ route('empDetails', $employee->id) }}" class="btn btn-dark textstyle color3 form-control">View</a>
                            </div>
                            <div class="col-md-1 d-flex align-items-center justify-content-center">
                                <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-{{ $employee->id }}">
                                    <i class="fa-solid fa-trash-can text-danger" style="font-size: 1.5rem"></i>
                                </button>
                            </div>
                        </div>
                        <hr>

                        <div class="modal fade" id="confirmDeleteModal-{{ $employee->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmDeleteModalLabel">Delete Confirmation</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col d-flex justify-content-center mb-3">
                                                <i class="fa-solid fa-exclamation text-danger" style="font-size: 3rem;"></i>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col d-flex justify-content-center text-center" style="font-size: 1.2rem;">
                                                Do you want to delete this employee record? The process cannot be undone.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('deleteEmployee', $employee->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        <div class="row p-2">
                            @if ($employees->total() > 10)
                                <ul class="col pagination justify-content-center">
                                    @if ($employees->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link" aria-disabled="true">&laquo;</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $employees->previousPageUrl() }}" aria-label="Previous">&laquo;</a>
                                        </li>
                                    @endif

                                    @for ($i = 1; $i <= $employees->lastPage(); $i++)
                                        <li class="page-item {{ ($employees->currentPage() == $i) ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $employees->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    @if ($employees->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $employees->nextPageUrl() }}" aria-label="Next">&raquo;</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link" aria-disabled="true">&raquo;</span>
                                        </li>
                                    @endif
                                </ul>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col d-flex justify-content-center align-items-center">
                                Showing {{ $employees->firstItem() }} to {{ $employees->lastItem() }} of {{ $employees->total() }} results
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
