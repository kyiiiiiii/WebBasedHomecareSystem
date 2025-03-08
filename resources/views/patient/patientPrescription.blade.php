@extends('layouts.patient')

@section('styles')
@endsection

@section('content')
<div class="row p-3 w-100 h-100 containerShadow2">
    <form action="{{ route('addPrescriptionRequest') }}" method="POST">
        @csrf
        <div class="col">
            <div class="row mb-3">
                <div class="col d-flex align-items-center textstyle3 justify-content-center" style="font-size:1.5rem">
                    Prescription Request Form
                    <hr>
                </div>
            </div>
            @if(session("add_patient_prescription_success"))
                <div class="alert alert-success">
                    {{ session('add_patient_prescription_success') }}
                </div>
            @endif
            @if(session("add_patient_prescription_error"))
                <div class="alert alert-danger">
                    {{ session('add_patient_prescription_error') }}
                </div>
            @endif
            <div class="row mb-3" style="font-size:1.2rem">
                <div class="col">
                    Patient Information
                    <hr>
                </div>
            </div>
            <div class="row mb-3 d-flex align-items-center">
                <div class="col-md-2 ">Patient ID : </div>
                <div class="col ">
                    <input type="text" class="form-control @error('id') is-invalid @enderror" name="id" id='id' value="{{$patient->id}}" readonly>
                </div>
            </div>
            <div class="row mb-3 d-flex align-items-center">
                <div class="col-md-2">Patient Name : </div>
                <div class="col">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id='name' value="{{$patient->name}}" readonly>
                </div>
                <div class="col-md-2">Contact : </div>
                <div class="col">
                    <input type="text" class="form-control @error('contact') is-invalid @enderror" name="contact" id="contact" value="{{$patient->contact}}" readonly>
                </div>
            </div>
            
            <div class="row d-flex align-items-center">
                <div class="col" style="font-size:1.2rem">
                    Prescription Request Information
                    <hr>
                </div>
            </div>
            <div class="row mb-3 d-flex align-items-center">
                <div class="col-md-2">Prescription ID : </div>
                <div class="col">
                    <input type="text" class="form-control @error('p_id') is-invalid @enderror" name="p_id" id='p_id' value="">
                </div>
            </div>
            <div class="row mb-3 d-flex align-items-center">
                <div class="col-md-2">Dosage : </div>
                <div class="col">
                    <input type="text" class="form-control @error('dosage') is-invalid @enderror" name="dosage" id='dosage' value="">
                </div>
                <div class="col-md-2">Quantity Requested : </div>
                <div class="col">
                    <input type="text" class="form-control @error('quantity') is-invalid @enderror" name="quantity" id="quantity" value="">
                </div>
            </div>
            <div class="row mb-3 d-flex align-items-center">
                <div class="col-md-2">Prescription Date : </div>
                <div class="col">
                    <input type="date" class="form-control @error('date') is-invalid @enderror" name="date" id="date" value="" min="{{ date('Y-m-d') }}">
                </div>
            </div>
            
            <div class="row d-flex align-items-center">
                <div class="col" style="font-size:1.2rem">
                    Delivery Information
                    <hr>
                </div>
            </div>
            <span class="text-danger ">*Please Ensure that your Address is correct, if not please update the addres on your profile.</span>
            <div class="row mb-3 d-flex align-items-center">
                <div class="col-md-2">Address Line1 : </div>
                <div class="col">
                    <input type="text" class="form-control @error('address1') is-invalid @enderror" name="address1" id='address1' value="{{$patient->address_line_1}}" readonly>
                </div>
            </div>
            <div class="row mb-3 d-flex align-items-center">
                <div class="col-md-2">Address line2 : </div>
                <div class="col">
                    <input type="text" class="form-control @error('address2') is-invalid @enderror" name="address2" id="address1" value="{{$patient->address_line_2}}" readonly>
                </div>
            </div>
            <div class="row mb-5 d-flex align-items-center">
                <div class="col-md-2">City : </div>
                <div class="col">
                    <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" id='city' value="{{$patient->city}}" readonly>
                </div>
                <div class="col-md-1 d-flex align-items-center">State : </div>
                <div class="col">
                    <input type="text" class="form-control @error('state') is-invalid @enderror" name="state" id="state" value="{{$patient->state}}" readonly>
                </div>
                <div class="col-md-2 d-flex align-items-center">Postal/Zip Code : </div>
                <div class="col">
                    <input type="text" class="form-control @error('postal') is-invalid @enderror" name="postal" id="postal" value="{{$patient->postal_code}}" readonly>
                </div>
            </div>
            <div class="row">
                <div class="col d-flex justify-content-end">
                    <a href="{{route("showPatientHome")}}" class="btn btn-outline-danger col me-3 ">Back</a>
                    <button type="submit" class="btn btn-outline-dark color7 textstyle5 col">Request</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection