@extends('layouts.patient')


@section('content')
<div class="row w-100 h-100 align-items-center">
    <div class="col">
        <form action="{{ route('careDelivery.store', ['id' => $patient->id]) }}" method="POST">
            @csrf
            <div class="row containerShadow2 p-md-4 p-3" style="background-color: #e9ecef; min-height:80vh">
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <h1>New Care Delivery Request</h1>
                            <hr>
                        </div>
                    </div>
                    
                    @if(session("add_patient_careDelivery_success"))
                        <div class="alert alert-success">
                            {{ session('add_patient_careDelivery_success') }}
                        </div>
                    @endif
                    @if(session('add_patient_careDelivery_error'))
                        <div class="alert alert-danger">
                            {{ session('add_patient_careDelivery_error') }}
                        </div>
                    @endif
                    <div class="row align-items-center mb-sm-3 mb-2">
                        <div class="col-sm-2 textstyle3">
                            Patient Name:
                        </div>
                        <div class="col">
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{$patient->name}}" readonly>
                            <div id="patientIDFeedback"></div> <!-- Feedback message for validation -->
                        </div>
                    </div>

        
                    <div class="row align-items-center mb-sm-3 mb-2">
                        <div class="col-sm-2 textstyle3">
                            Care Delivery Type:
                        </div>
                        <div class="col-sm align-items-center mb-sm-0 mb-2">
                            <select name="care_delivery_type" id="care_delivery_type" class="form-select">
                                <option value="HomeMedicalCheckup">Home Medical Checkup</option>
                                <option value="HomeNursing">Home Nursing</option>
                                <option value="HomePhysiotherapy">Home Physiotherapy</option>
                                <option value="HomePalliativeCare">Home Palliative Care</option>
                                <option value="HomeMentalHealthCounseling">Home Mental Health Counseling</option>
                                <option value="HomeMedicationDelivery">Home Medication Delivery and Administration</option>
                                <option value="HomeLaboratoryServices">Home Laboratory Services</option>
                                <option value="HomeVaccination">Home Vaccination</option>
                                <option value="ElderlyCare">Elderly Care</option>
                                <option value="PostSurgicalCare">Post-Surgical Care</option>
                                <option value="MaternityAndInfantCare">Maternity and Infant Care</option>
                            </select>
                        </div>
                        <div class="col-sm-1 textstyle3">
                            Date:
                        </div>
                        <div class="col-sm mb-sm-0 mb-2">
                            <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" min="{{ date('Y-m-d') }}">
                        </div>
                    </div>

                    <div class="row align-items-center mb-sm-3 mb-2">
                        <div class="col-sm-2 textstyle3">
                            Address:
                        </div>
                        <div class="col">
                            <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{$patient->address_line_1}}" readonly>
                            <div id="patientIDFeedback"></div> <!-- Feedback message for validation -->
                        </div>
                    </div>
                    <div class="row align-items-center mb-sm-3 mb-2">
                        <div class="col-sm-2">
                            .
                        </div>
                        <div class="col">
                            <span class="text-danger">*Please Ensure that your Address appear on Map, if not please update the addres on your profile.</span>
                            <div id="map" style="height: 250px"></div>
                        </div>
                    </div>
                    <div class="row align-items-center mb-sm-3 mb-2">
                        <div class="col-sm-2 textstyle3">
                            Care Delivery Time:
                        </div>
                        <div class="col-sm">
                            <input type="time" name="time" id="time" class="form-control @error('time') is-invalid @enderror" style="width: 50%">
                        </div>
                    </div>
                    <div class="row mb-sm-3 mb-2">
                        <div class="col-sm-2 textstyle3">
                            Notes:
                        </div>
                        <div class="col-sm">
                            <textarea name="notes" id="notes" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-end align-items-center">
                            <a href="{{route('showPatientHome')}}" class="btn btn-outline-danger px-4 mx-3">Back</a>
                            <button type="submit" class="btn btn-outline-dark px-4">Add</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        console.log("DOM fully loaded and parsed.");

        var patientId = {{ $patient->id }}; // Patient ID passed from the controller
        console.log("Patient ID:", patientId);

        // Make an AJAX request to fetch the patient's address
        fetch(`/patient/address/${patientId}`)
            .then(response => {
                
                return response.json();
            })
            .then(data => {
                
                // Initialize the map and set its view to a default location
                var map = L.map('map').setView([0, 0], 13);
                console.log("Map initialized.");

                // Geocode the patient's address
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(data.address_line_1)}`)
                    .then(response => {
                        return response.json();
                    })
                    .then(locationData => {

                        if (locationData.length > 0) {
                            var lat = locationData[0].lat;
                            var lon = locationData[0].lon;

                            // Set the map view to the patient's location
                            map.setView([lat, lon], 13);

                            // Add tile layer
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                maxZoom: 19,
                            }).addTo(map);

                            // Add a marker at the patient's location
                            L.marker([lat, lon]).addTo(map)
                                .bindPopup(data.address_line_1)
                                .openPopup();
                        } else {
                            console.error('Patient address not found');
                            alert('Patient address not found');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching location data:', error);
                    });
            })
            .catch(error => {
                console.error('Error fetching patient address:', error);
            });
    });
</script>




@endsection
