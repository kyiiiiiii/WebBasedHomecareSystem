@extends('layouts.admin')

@section('styles')
    <!-- Any additional styles you may need -->
@endsection

@section('content')
<div class="row h-100 w-100">
    <div class="col">
        <div class="row mt-4  mb-3">
            <h1 class="col-12 p-0 col-md textstyle3" style="font-size: 1.5rem">
                Care Delivery Requests
            </h1>
            <div class="col-12 col-md d-flex justify-content-start justify-content-md-end align-items-center">
                <a href="#" class="btn btn-danger textstyle"><i class="fa-regular fa-plus me-2"></i> Add Request</a>
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
        @if(session('delete_careDelivery_success'))
            <div class="alert alert-success">
                {{ session('delete_careDelivery_success') }}
            </div>
        @elseif(session('delete_careDelivery_error'))
            <div class="alert alert-danger">
                {{ session('delete_careDelivery_error') }}
            </div>
        @endif
        <div class="row mb-3">
            <div class="col p-0 d-flex justify-content-start align-items-center">
                Showing {{ $caredeliveries->firstItem() }} to {{ $caredeliveries->lastItem() }} of {{ $caredeliveries->total() }} results
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
                    <div class="col-md-2"></div>
                </div>
                <div id="prescriptionList">
                    @foreach($caredeliveries as $caredelivery)
                        <div class="row p-3 textstyle4 align-items-center prescription-row">
                            <div class="col">{{ $caredelivery->id }}</div>
                            <div class="col">{{ $caredelivery->patient->name }}</div>
                            <div class="col">{{ $caredelivery->status }}</div>
                            <div class="col">{{ $caredelivery->patient->address_line_1 }}</div>
                            <div class="col">{{ $caredelivery->date}}</div>
                            <div class="col-md-1 mt-md-0 mt-3">
                                <a href="{{{route('showCareDeliveryDetails',$caredelivery->id)}}}" class="btn btn-dark textstyle color3 form-control">View</a>
                            </div>
                            <div class="col-md-1 d-flex align-items-center justify-content-center">
                                <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-{{ $caredelivery->id }}">
                                    <i class="fa-solid fa-trash-can text-danger" style="font-size: 1.5rem"></i>
                                </button>
                            </div>
                        </div>
                        <div class="modal fade" id="confirmDeleteModal-{{ $caredelivery->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
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
                                                Do you want to delete this request? The process cannot be undone.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('deleteCareDeliveryRequest', $caredelivery->id) }}" method="POST" style="display: inline;">
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
                    @if ($caredeliveries->total() > 10)
                        <ul class="col pagination justify-content-center">
                            <!-- Previous Page Link -->
                            @if ($caredeliveries->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link" aria-disabled="true">&laquo;</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $caredeliveries->previousPageUrl() }}" aria-label="Previous">&laquo;</a>
                                </li>
                            @endif
                
                            <!-- Page Links -->
                            @for ($i = 1; $i <= $caredeliveries->lastPage(); $i++)
                                <li class="page-item {{ ($caredeliveries->currentPage() == $i) ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $caredeliveries->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                
                            <!-- Next Page Link -->
                            @if ($caredeliveries->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $caredeliveries->nextPageUrl() }}" aria-label="Next">&raquo;</a>
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
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search');
    const hideApprovedCheckbox = document.getElementById('hideApproved');
    const sortByIdCheckbox = document.getElementById('sortById');
    const prescriptionRows = document.querySelectorAll('.prescription-row');

    function filterRows() {
        const searchText = searchInput.value.toLowerCase().trim();
        const hideApproved = hideApprovedCheckbox.checked;
        const sortById = sortByIdCheckbox.checked;

        console.log("Search Text:", searchText);
        console.log("Hide Approved Checked:", hideApproved);
        console.log("Sort by ID Checked:", sortById);

        let rowsArray = Array.from(prescriptionRows);

        if (sortById) {
            rowsArray.sort((a, b) => {
                const idA = parseInt(a.children[0].textContent);
                const idB = parseInt(b.children[0].textContent);
                return idA - idB;
            });
        }

        rowsArray.forEach(row => {
            const id = row.children[0].textContent.toLowerCase().trim();
            const patientName = row.children[1].textContent.toLowerCase().trim();
            const status = row.children[2].textContent.toLowerCase().trim();
            const address = row.children[3].textContent.toLowerCase().trim();
            const date = row.children[4].textContent.toLowerCase().trim();

            console.log("Row Data - ID:", id, "Patient Name:", patientName, "Status:", status, "Address:", address, "Date:", date);

            const matchesId = searchText === "" || id === searchText;
            const matchesPatientName = patientName.includes(searchText);
            const matchesStatus = status.includes(searchText);
            const matchesAddress = address.includes(searchText);
            const matchesDate = date.includes(searchText);

            console.log("Matches ID:", matchesId, "Matches Patient Name:", matchesPatientName, "Matches Status:", matchesStatus, "Matches Address:", matchesAddress, "Matches Date:", matchesDate);

            const matchesSearch = matchesId || matchesPatientName || matchesStatus || matchesAddress || matchesDate;
            const matchesHideApproved = !hideApproved || (hideApproved && status !== 'approved');

            console.log("Matches Search:", matchesSearch, "Matches Hide Approved:", matchesHideApproved);

            if (matchesSearch && matchesHideApproved) {
                console.log("Row is shown");
                row.style.display = '';
            } else {
                console.log("Row is hidden");
                row.style.display = 'none';
            }
        });

        // Append sorted rows back to the list
        const prescriptionList = document.getElementById('prescriptionList');
        prescriptionList.innerHTML = '';
        rowsArray.forEach(row => {
            prescriptionList.appendChild(row);
        });
    }

    searchInput.addEventListener('input', filterRows);
    hideApprovedCheckbox.addEventListener('change', filterRows);
    sortByIdCheckbox.addEventListener('change', filterRows);
});
</script>

@endsection
