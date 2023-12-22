@extends('frontend.user.layouts.dash')
  
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
  
                <div class="card-body">
  
                    <div class="alert alert-success">
                        Subscription purchase successfully!
                    </div>
  
                </div>
            </div>
        </div>
    </div>
</div>
<script>
setTimeout(function() {
  window.location.href = "https://stashpicz.com/en/user/dashboard";
}, 3000);
</script>


@endsection

