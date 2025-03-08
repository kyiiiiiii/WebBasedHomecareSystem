@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('content')
<div class="row h-100 w-100">
    <div class="col">
        <div class="row color2 containerShadow2 p-4 textstyle mb-3">
            <h1 class="col-12 col-md" style="font-size: 2rem">
                Patients
            </h1>
            
        </div>
        
        <div class="row mb-3 gap-3">
            <div class="col-md-2 textstyle3 containerShadow2 p-5">
                <div class="row align-items-center justify-content-center text-center">
                    <div class="col">
                        <div class="label pb-lg-4">Total Patients</div>
                        <i class="fa-solid fa-user d-none d-md-block" style="font-size: 2.0rem; color:#1d3557;"></i>
                        <div class="value" style="font-size: 2rem; color:rgb(13, 116, 201)">{{$totalPatients}}</div>
                    </div>
                </div>
            </div>
            
            <div class="col containerShadow2 textstyle">
                <canvas id="patientDensityChart" style="max-height: 210px;"></canvas>
            </div>
            <div class="col-md-2 p-1 textstyle3 containerShadow2">
                <canvas id="patientGenderChart" style="max-height: 200px;"></canvas>
            </div>
        </div>
        @if(session('delete_patient_success'))
            <div class="alert alert-success">
                {{ session('delete_patient_success') }}
            </div>
        @elseif(session('delete_patient_error'))
            <div class="alert alert-danger">
                {{ session('delete_patient_error') }}
            </div>
        @endif
        <div class="row containerShadow2">
            <div class="col">
                <div class="row p-2 color2 textstyle text-center align-items-center">
                    <div class="col">User ID</div>
                    <div class="col">User Name</div>
                    <div class="col">Gender</div>
                    <div class="col">Date of Registration</div>
                    <div class="col"></div>
                </div>

                @foreach($patients as $patient)
                    <div class="row p-1 textstyle4 text-center align-items-center">
                        <div class="col">{{ $patient->id }}</div>
                        <div class="col">{{ $patient->name }}</div>
                        <div class="col">{{ $patient->gender }}</div>
                        <div class="col">{{ $patient->created_at->format('d/m/Y') }}</div>
                        <div class="col-md-1 mt-md-0 mt-3">
                            <a href="{{ route('patientDetails', $patient->id) }}" class="btn btn-dark textstyle color3 form-control">View</a>
                        </div>
                        <div class="col-md-1 d-flex align-items-center justify-content-center">
                            <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-{{ $patient->id }}">
                                <i class="fa-solid fa-trash-can text-danger" style="font-size: 1.5rem"></i>
                            </button>
                        </div>
                        
                    </div>
                    <hr>
                    <!-- Modal for Delete Confirmation -->
                    <div class="modal fade" id="confirmDeleteModal-{{ $patient->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
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
                                            Do you want to delete this patient record? The process cannot be undone.
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form action="{{ route('deletePatientData', $patient->id) }}" method="POST" style="display: inline;">
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
                    <ul class="col pagination justify-content-center">
                        <!-- Previous Page Link -->
                        @if ($patients->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link" aria-disabled="true">&laquo;</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $patients->previousPageUrl() }}" aria-label="Previous">&laquo;</a>
                            </li>
                        @endif

                        <!-- Page Links -->
                        @for ($i = 1; $i <= $patients->lastPage(); $i++)
                            <li class="page-item {{ ($patients->currentPage() == $i) ? 'active' : '' }}">
                                <a class="page-link" href="{{ $patients->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <!-- Next Page Link -->
                        @if ($patients->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $patients->nextPageUrl() }}" aria-label="Next">&raquo;</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link" aria-disabled="true">&raquo;</span>
                            </li>
                        @endif
                    </ul>
                </div>
                
                <div class="row">
                    <div class="col d-flex justify-content-center align-items-center">
                        Showing {{ $patients->firstItem() }} to {{ $patients->lastItem() }} of {{ $patients->total() }} results
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
