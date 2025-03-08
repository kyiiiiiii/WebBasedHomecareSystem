@extends('layouts.admin')

@section('styles')
@endsection

@section('content')
<div class="row p-3 w-100 h-100 containerShadow2">
    <form action="{{ route('addAdminPrescriptionRequest') }}" method="POST">
        @csrf
        <div class="col">
            <div class="row mb-3">
                <div class="col d-flex align-items-center textstyle3 justify-content-center" style="font-size:1.5rem">
                    Prescription Request Form
                    <hr>
                </div>
            </div>
            @if(session('add_admin_prescription_success'))
                <div class="alert alert-success">
                    {{ session('add_admin_prescription_success') }}
                </div>
            @elseif(session('add_admin_prescription_failed'))
                <div class="alert alert-danger">
                    {{ session('add_admin_prescription_failed') }}
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
                    <input type="text" class="form-control" name="id" id='id' value="">
                </div>
            </div>
            <div class="row mb-3 d-flex align-items-center">
                <div class="col-md-2">Patient Name : </div>
                <div class="col">
                    <input type="text" class="form-control" name="name" id='name' value="">
                </div>
                <div class="col-md-2">Contact : </div>
                <div class="col">
                    <input type="text" class="form-control" name="contact" id="contact" value="">
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
                    <input type="text" class="form-control" name="p_id" id='p_id' value="">
                </div>
            </div>
            <div class="row mb-3 d-flex align-items-center">
                <div class="col-md-2">Dosage : </div>
                <div class="col">
                    <input type="text" class="form-control" name="dosage" id='dosage' value="">
                </div>
                <div class="col-md-2">Quantity Requested : </div>
                <div class="col">
                    <input type="text" class="form-control" name="quantity" id="quantity" value="">
                </div>
            </div>
            <div class="row mb-3 d-flex align-items-center">
                <div class="col-md-2">Prescription Date : </div>
                <div class="col">
                    <input type="date" class="form-control" name="date" id="date" value="">
                </div>
            </div>
            
            <div class="row d-flex align-items-center">
                <div class="col" style="font-size:1.2rem">
                    Delivery Information
                    <hr>
                </div>
            </div>
            <div class="row mb-3 d-flex align-items-center">
                <div class="col-md-2">Address Line1 : </div>
                <div class="col">
                    <input type="text" class="form-control" name="address1" id='address1' value="">
                </div>
            </div>
            <div class="row mb-3 d-flex align-items-center">
                <div class="col-md-2">Address line2 : </div>
                <div class="col">
                    <input type="text" class="form-control" name="address2" id="address2" value="">
                </div>
            </div>
            <div class="row mb-5 d-flex align-items-center">
                <div class="col-md-2">City : </div>
                <div class="col">
                    <input type="text" class="form-control" name="city" id='city' value="">
                </div>
                <div class="col-md-1 d-flex align-items-center">State : </div>
                <div class="col">
                    <input type="text" class="form-control" name="state" id="state" value="">
                </div>
                <div class="col-md-2 d-flex align-items-center">Postal/Zip Code : </div>
                <div class="col">
                    <input type="text" class="form-control" name="postal" id="postal" value="">
                </div>
            </div>
            <div class="row">
                <div class="col d-flex justify-content-end">
                    <a href="{{route("showPrescriptionPage")}}" class="btn btn-outline-danger col me-3 ">Back</a>
                    <button type="submit" class="btn btn-outline-dark color2 textstyle5 col">Request</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection