@extends('layouts.admin')

@section('content')
<div class="row h-100 w-100">
    <div class="col">
        <div class="row mt-4 mb-3">
            <h1 class="col-12 p-0 col-md textstyle3" style="font-size: 1.5rem">
                Prescription Requests
            </h1>
            <div class="col-12 col-md d-flex justify-content-start justify-content-md-end align-items-center">
                <a href="{{route('showPrescriptionRequestForm')}}" class="btn btn-danger textstyle">
                    <i class="fa-regular fa-plus me-2"></i> Add Request
                </a>
            </div>
        </div>
        
        <div class="row mb-3">
            <hr>    
            <div class="col p-0 d-flex">
                <div class="search-container">
                    <i class="fas fa-search"></i>
                    <input type="text" id="search" placeholder="Search..." class="form-control">
                </div>
                <button class="px-3" style="background-color:lightgray; border:none;">Search</button>
            </div>
        </div>
        @if(session('delete_prescription_success'))
            <div class="alert alert-success">
                {{ session('delete_prescription_success') }}
            </div>
        @elseif(session('delete_prescription_error'))
            <div class="alert alert-danger">
                {{ session('delete_prescription_error') }}
            </div>
        @endif
        <div class="row mb-3">
            <div class="col p-0 d-flex justify-content-start align-items-center">
                Showing {{ $prescriptions->firstItem() }} to {{ $prescriptions->lastItem() }} of {{ $prescriptions->total() }} results
            </div>
            <div class="col d-flex justify-content-end align-items-center">
                <input type="checkbox" id="sortById">
                <label for="sortById" class="mx-2">Sort by ID</label>
                <input type="checkbox" name="hideApproved" id="hideApproved">
                <label for="hideApproved" class="mx-2">Hide Approved</label>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="row p-2 textstyle3 align-items-center" style="background-color: lightgray; color:grey">
                    <div class="col">ID</div>
                    <div class="col">Requested By</div>
                    <div class="col">Status</div>
                    <div class="col">Address</div>
                    <div class="col">Prescription Date</div>
                    <div class="col"></div>
                </div>

                <div id="prescriptionList">
                    @foreach($prescriptions as $prescription)
                        <div class="row p-3 textstyle4 align-items-center prescription-row" data-id="{{ $prescription->id }}" data-patient="{{ $prescription->patient_name }}" data-status="{{ $prescription->status }}" data-address="{{ $prescription->address_line1 }}" data-date="{{ $prescription->prescription_date }}">
                            <div class="col">{{ $prescription->id }}</div>
                            <div class="col">{{ $prescription->patient_name }}</div>
                            <div class="col">{{ $prescription->status }}</div>
                            <div class="col">{{ $prescription->address_line1 }}</div>
                            <div class="col">{{ $prescription->prescription_date }}</div>
                            <div class="col-md-1 mt-md-0 mt-3">
                                <a href="{{ route('prescriptionDetails', $prescription->id) }}" class="btn btn-dark textstyle color3 form-control">View</a>
                            </div>
                            <div class="col-1 d-flex align-items-center justify-content-center">
                                <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-{{ $prescription->id }}">
                                    <i class="fa-solid fa-trash-can text-danger" style="font-size: 1.5rem"></i>
                                </button>
                            </div>
                        </div>

                        <div class="modal fade" id="confirmDeleteModal-{{ $prescription->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
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
                                                Do you want to delete this prescription record? The process cannot be undone.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('deletePrescriptionRequest', $prescription->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row p-2">
                    @if ($prescriptions->total() > 10)
                        <ul class="col pagination justify-content-center">
                            @if ($prescriptions->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link" aria-disabled="true">&laquo;</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $prescriptions->previousPageUrl() }}" aria-label="Previous">&laquo;</a>
                                </li>
                            @endif

                            @for ($i = 1; $i <= $prescriptions->lastPage(); $i++)
                                <li class="page-item {{ ($prescriptions->currentPage() == $i) ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $prescriptions->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            @if ($prescriptions->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $prescriptions->nextPageUrl() }}" aria-label="Next">&raquo;</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link" aria-disabled="true">&raquo;</span>
                                </li>
                            @endif
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const prescriptionsData = @json($prescriptions->items()); // Only the items array
    console.log('Prescriptions Data:', prescriptionsData); // Debugging line

    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search');
        const hideApprovedCheckbox = document.getElementById('hideApproved');
        const sortByIdCheckbox = document.getElementById('sortById');
        const prescriptionList = document.getElementById('prescriptionList');

        function filterRows() {
            const searchText = searchInput.value.toLowerCase().trim();
            const hideApproved = hideApprovedCheckbox.checked;

            let filteredPrescriptions = prescriptionsData.filter(prescription => {
                const matchesId = prescription.id.toString().toLowerCase().includes(searchText);
                const matchesPatientName = prescription.patient_name.toLowerCase().includes(searchText);
                const matchesStatus = prescription.status.toLowerCase().includes(searchText);
                const matchesAddress = prescription.address_line1.toLowerCase().includes(searchText);
                const matchesDate = prescription.prescription_date.toLowerCase().includes(searchText);

                const matchesSearch = matchesId || matchesPatientName || matchesStatus || matchesAddress || matchesDate;
                const matchesHideApproved = !hideApproved || (hideApproved && prescription.status !== 'approved');

                return matchesSearch && matchesHideApproved;
            });

            // Clear the current displayed rows
            prescriptionList.innerHTML = '';

            // Append filtered prescriptions to the list
            filteredPrescriptions.forEach(prescription => {
                const row = document.createElement('div');
                row.className = 'row p-3 textstyle4 align-items-center prescription-row';
                row.innerHTML = `
                    <div class="col">${prescription.id}</div>
                    <div class="col">${prescription.patient_name}</div>
                    <div class="col">${prescription.status}</div>
                    <div class="col">${prescription.address_line1}</div>
                    <div class="col">${prescription.prescription_date}</div>
                    <div class="col-md-1 mt-md-0 mt-3">
                        <a href="/prescriptions/${prescription.id}" class="btn btn-dark textstyle color3 form-control">View</a>
                    </div>
                    <div class="col-1 d-flex align-items-center justify-content-center">
                        <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-${prescription.id}">
                            <i class="fa-solid fa-trash-can text-danger" style="font-size: 1.5rem"></i>
                        </button>
                    </div>
                `;
                prescriptionList.appendChild(row);
            });
        }

        searchInput.addEventListener('input', filterRows);
        hideApprovedCheckbox.addEventListener('change', filterRows);
        sortByIdCheckbox.addEventListener('change', filterRows);
    });
</script>

@endsection
