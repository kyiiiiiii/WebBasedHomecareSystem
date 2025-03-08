@extends('layouts.admin')

@section('styles')
@endsection

@section('content')
<div class="row p-3 containerShadow2 h-100 w-100" style="background-color: #e9ecef">
    <div class="col">
        <div class="row">
            <div class="col">
                <h1>Care Delivery Delivery Details</h1>
                <hr>
            </div>
        </div>
        <div class="row mb-3 ">
            <div class="col">
                <div class="row">
                    <div class="col" style="font-weight: bold; font-size: 1rem">
                        Patient Name : {{$careDelivery->patient->name}}
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        Patient ID : {{$careDelivery->patient->id}}
                    </div>
                </div>
            </div>
            <div class="col d-flex align-items-center">
                <a href="{{route('patientDetails',$careDelivery->patient->id)}}" class="btn btn-outline-dark">View Patient</a>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="row">
                    <div class="col" style="font-weight: bold; font-size: 1rem">
                        Care Delivery ID : {{$careDelivery->id}}
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        Care Delivery Type : {{$careDelivery->care_delivery_type}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="row">
                    <div class="col" style="font-weight: bold; font-size: 1rem">
                        Date : {{$careDelivery->date}}
                    </div>
                    <div class="col" style="font-weight: bold; font-size: 1rem">
                        Time : {{$careDelivery->time}}
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row mb-3">
            <div class="col">
                <div class="row">
                    <div class="col">
                        Address line 1 : {{$careDelivery->patient->address_line_1}}
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        Address line 2 : {{$careDelivery->patient->address_line_2}}
                    </div>
                </div>
                
            </div>
            
            <div class="col ">
                
                <div class="row">
                    <div class="col ">
                        City : {{$careDelivery->patient->city}}
                    </div>
                </div>
                <div class="row">
                    <div class="col ">
                        State : {{$careDelivery->patient->state}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="row">
                    <div class="col" style="font-weight: bold; font-size: 1rem">
                        Status: <span style="color: 
                            @if($careDelivery->status == 'pending') 
                                blue 
                            @elseif($careDelivery->status == 'approved') 
                                green
                            @elseif($careDelivery->status == 'completed') 
                                green 
                            @endif">
                            {{$careDelivery->status}}
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col " style="font-weight: bold; font-size: 1rem">
                        Care Delivery Date :  {{$careDelivery->date}}
                    </div>
                </div>
                <div class="row">
                    <div class="col d-flex align-items-centers" style="font-weight: bold; font-size: 1rem">
                        Expected Delivery Date: {{ \Carbon\Carbon::parse($careDelivery->date)->addDays(3)->format('Y-m-d') }}
                    </div>
                </div>
            </div>
            @if($careDelivery->status == "pending")
                <div class="col">
                    <form action="{{route('approve.caredelivery',$careDelivery->id)}}" method="POST" onsubmit="return confirm('Are you sure you want to approve this request?');">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success">Approve</button>
                    </form>
                </div>
            @elseif($careDelivery->status == "approved")
                <div class="col">
                    <form action="{{route('complete.caredelivery',$careDelivery->id)}}" method="POST" onsubmit="return confirm('Are you sure you want to complete this request?');">
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
        var careDeliveryId = {{ $careDelivery->id }}; // Prescription ID passed from controller

        // Make an AJAX request to fetch the prescription and company addresses
        fetch(`/admin/careDeliveryAddress/${careDeliveryId}`)
            .then(response => response.json())
            .then(data => {
                // Initialize the map and set its view
                var map = L.map('map').setView([0, 0], 13); // Default view (0, 0) to be updated

                // Geocode the prescription address
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(data.address)}`)
                    .then(response => response.json())
                    .then(careDeliveryLocation => {
                        if (careDeliveryLocation.length > 0) {
                            var careDeliveryLat = careDeliveryLocation[0].lat;
                            var careDeliveryLon = careDeliveryLocation[0].lon;

                            // Geocode the company address
                            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(data.company_address)}`)
                                .then(response => response.json())
                                .then(companyLocation => {
                                    if (companyLocation.length > 0) {
                                        var companyLat = companyLocation[0].lat;
                                        var companyLon = companyLocation[0].lon;

                                        // Set the map view to show both points
                                        map.setView([careDeliveryLat, careDeliveryLon], 13);

                                        // Add tile layer
                                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                            maxZoom: 19,
                                        }).addTo(map);

                                        // Add routing control to the map
                                        L.Routing.control({
                                            waypoints: [
                                                L.latLng(careDeliveryLat, careDeliveryLon),
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
                            alert('Care Delivery address not found');
                        }
                    })
                    .catch(error => console.error('Error fetching Care Delivery location data:', error));
            })
            .catch(error => console.error('Error fetching Care Delivery and company addresses:', error));
    });
</script>
@endsection