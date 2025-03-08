@extends('layouts.patient')

@section('styles')
@endsection

@section('content')
<div class="row w-100 h-100">
    <div class="col">
        <div class="row">
            <div class="col">
                <h1 class="text-center p-3">My Care team</h1>
                <hr>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col text-center" style="font-size:1.2rem">
                Your health and comfort are our top priorities. Our team of skilled caregivers is here to ensure that you receive the personalized care you deserve. Meet the healthcare professionals who are devoted to supporting your journey to wellness.
            </div>
        </div>
        <div class="row">
            <div class="col " style="overflow-x: hidden; overflow-y: auto; max-height: 75vh; min-height: 75vh">
                @foreach($employees->chunk(3) as $chunk)
                    <div class="row mb-4"> 
                        @foreach($chunk as $employee)
                            <div class="col-md-4 d-flex  justify-content-center">
                                <a href='{{route('getCaregiverDetails',$employee->id)}}' class="card hover-effect p-3 containerShadow2 fade-in text-decoration-none" style="width: 18rem;">
                                    <img class="card-img-top" src="data:image/jpeg;base64,{{ base64_encode($employee->profile_image) }}" alt="Profile Image">
                                    <div class="card-body text-center">
                                        <h5 class="card-title textstyle3">Dr. {{ $employee->name }}</h5>
                                        <p class="card-text">{{ $employee->role }}</p>
                                        <p class="card-text">{{ $employee->contact_info }}</p>
                                        
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
