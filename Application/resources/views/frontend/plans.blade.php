@extends('frontend.user.layouts.dash')
  
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Select Plane:</div>
 
                <div class="card-body">
 
                    <div class="row">
                        @foreach($plans as $plan)
                            <div class="col-md-6">
                                <div class="card mb-3">
                                  <div class="card-header"> 
                                        ${{ $plan->price }}/Mo
                                  </div>
                                  <div class="card-body">
                                    <h5 class="card-title">{{ $plan->name }}</h5>
                                    <p class="card-text">More features soon!</p>


                                    @if($canceled)
                                    <h5 class="card-title">Active</h5>
                                    <a class="btn btn-primary pull-right" style="background-color: grey; border: 1px solid grey; cursor: not-allowed;">Cancel</a>
                                    
                                    <p>Your subscription expires at {{$expires}}</p>
                                    @elseif($sub)
                                    
                                    <h5 class="card-title">Active</h5>
                                    <a href="{{ route('user.plan.cancel', $plan->slug) }}" class="btn btn-primary pull-right">Cancel</a>
                                    
                                
  
                                    @else
                                    <a href="{{ route('user.plan.show', $plan->slug) }}" class="btn btn-primary pull-right">Choose</a>

                                    @endif
                                  </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection