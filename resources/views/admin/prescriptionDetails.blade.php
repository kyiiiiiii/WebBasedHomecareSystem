@extends('layouts.admin')

@section('styles')
@endsection

@section('content')
<div class="row p-3 containerShadow2 h-100 w-100" style="background-color: #e9ecef">
    <div class="col">
        <div class="row">
            <div class="col">
                <h1>Prescription Delivery Details</h1>
                <hr>
            </div>
        </div>
        <div class="row mb-3 ">
            <div class="col">
                <div class="row">
                    <div class="col" style="font-weight: bold; font-size: 1rem">
                        Patient Name : {{$prescription->patient->name}}
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        Patient ID : {{$prescription->patient->id}}
                    </div>
                </div>
            </div>
            <div class="col d-flex align-items-center">
                <a href="{{route('patientDetails',$prescription->patient->id)}}" class="btn btn-outline-dark">View Patient</a>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="row">
                    <div class="col" style="font-weight: bold; font-size: 1rem">
                        Prescription ID : {{$prescription->id}}
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        Dosage : {{$prescription->dosage}}
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col" style="font-weight: bold; font-size: 1rem">
                        -
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        Quantity Requested : {{$prescription->quantity_requested}}
                    </div>
                </div>
                
            </div>
        </div>
        <hr>
        <div class="row ">
            <div class="col" style="font-weight: bold; font-size: 1rem">
                Delivery Information
                
            </div>

        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="row">
                    <div class="col">
                        Address line 1 : {{$prescription->address_line1}}
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        Address line 2 : {{$prescription->address_line2}}
                    </div>
                </div>
                
            </div>
            
            <div class="col ">
                
                <div class="row">
                    <div class="col ">
                        City : {{$prescription->city}}
                    </div>
                </div>
                <div class="row">
                    <div class="col ">
                        State : {{$prescription->state}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="row">
                    <div class="col" style="font-weight: bold; font-size: 1rem">
                        Status: <span style="color: 
                            @if($prescription->status == 'pending') 
                                blue 
                            @elseif($prescription->status == 'approved') 
                                green
                            @elseif($prescription->status == 'completed') 
                                green
                            @endif">
                            {{$prescription->status}}
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col " style="font-weight: bold; font-size: 1rem">
                        Delivery Date :  {{$prescription->prescription_date}}
                    </div>
                </div>
                
            </div>
            @if($prescription->status == "pending")
                <div class="col">
                    <form action="{{ route('approvePrescription', $prescription->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to approve this prescription?');">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success">Approve</button>
                    </form>
                </div>
            @elseif($prescription->status == "approved")
                <div class="col">
                    <form action="{{ route('completePrescription', $prescription->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to complete this prescription?');">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success">Complete</button>
                    </form>
                </div>
            @endif
        
        </div>
        <hr>
        <div class="row mb-3">
            <div class="col">
                 <div id="map" style="height: 400px;"></div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var prescriptionId = {{ $prescription->id }}; // Prescription ID passed from controller

        // Make an AJAX request to fetch the prescription and company addresses
        fetch(`/getPrescriptionAddress/${prescriptionId}`)
            .then(response => response.json())
            .then(data => {
                // Initialize the map and set its view
                var map = L.map('map').setView([0, 0], 13); // Default view (0, 0) to be updated

                // Geocode the prescription address
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(data.address)}`)
                    .then(response => response.json())
                    .then(prescriptionLocation => {
                        if (prescriptionLocation.length > 0) {
                            var prescriptionLat = prescriptionLocation[0].lat;
                            var prescriptionLon = prescriptionLocation[0].lon;

                            // Geocode the company address
                            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(data.company_address)}`)
                                .then(response => response.json())
                                .then(companyLocation => {
                                    if (companyLocation.length > 0) {
                                        var companyLat = companyLocation[0].lat;
                                        var companyLon = companyLocation[0].lon;

                                        // Set the map view to show both points
                                        map.setView([prescriptionLat, prescriptionLon], 13);

                                        // Add tile layer
                                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                            maxZoom: 19,
                                        }).addTo(map);

                                        // Add routing control to the map
                                        L.Routing.control({
                                            waypoints: [
                                                L.latLng(prescriptionLat, prescriptionLon),
                                                L.latLng(companyLat, companyLon)
                                            ],
                                            routeWhileDragging: true
                                        }).addTo(map);
                                    } else {
                                        alert('Company address not found');
                                    }
                                })
                                .catch(error => console.error('Error fetching company location data:', error));
                        } else {
                            alert('Prescription address not found');
                        }
                    })
                    .catch(error => console.error('Error fetching prescription location data:', error));
            })
            .catch(error => console.error('Error fetching prescription and company addresses:', error));
    });
</script>

@endsection