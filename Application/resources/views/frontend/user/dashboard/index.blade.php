@extends('frontend.user.layouts.dash')
@section('title', lang('Dashboard', 'dashboard'))
@section('content')
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <div class="row row-cols-1 row-cols-md-2 justify-content-center g-3">
        <div class="col">
            <div class="card-v v3 justify-content-center h-100">
                <div class="card-v-body">
                    <div class="stats">
                        <div class="stats-info">
                            <div class="stats-meta">
                                <h3 class="stats-title">{{ lang('Storage Space', 'dashboard') }}</h3>
                            </div>
                            <div class="stats-icon">
                                <i class="fa-solid fa-hard-drive"></i>
                            </div>
							<a href="http://local/stashpicz/httpdocs/en/user/plans"><button type="button" class="btn btn-primary">
  Expand
</button>
</a>
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Modal body text goes here.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>					
	<script>
		
  $(document).ready(function() {
    $('#exampleModal').on('shown.bs.modal', function() {
		alert(1);
      // Triggered when the modal is shown
      console.log('Modal shown');
    });

    $('#exampleModal').on('hidden.bs.modal', function() {
      // Triggered when the modal is hidden
      console.log('Modal hidden');
    });
  });
</script>						
                        </div>
                        @php
                            $progressClass = '';
                            if (uploadSettings()->storage->fullness > 80) {
                                $progressClass = 'bg-danger';
                            } elseif (uploadSettings()->storage->fullness < 80 && uploadSettings()->storage->fullness >= 60) {
                                $progressClass = 'bg-warning';
                            }
                        @endphp
                        <div class="space">
                            <p class="space-text">{{ uploadSettings()->storage->used->format }} /
                                <span class="text-dark">{{ uploadSettings()->formates->storage_space }}</span>
                            </p>
                            <div class="space-progress">
                                <div class="space-progress-inner {{ $progressClass }}"
                                    style="width: {{ uploadSettings()->storage->fullness }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card-v v3 justify-content-center h-100">
                <div class="card-v-body">
                    <div class="stats">
                        <div class="stats-info">
                            <div class="stats-meta">
                                <h3 class="stats-title">{{ lang('Total Uploads', 'dashboard') }}</h3>
                                <p class="stats-text">{{ number_format($countFileEntries) }}</p>
                            </div>
                            <div class="stats-icon">
                                <i class="fa-solid fa-images"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card-v v3 justify-content-center h-100">
                <div class="card-v-body">
                    <div class="stats">
                        <div class="stats-info">
                            <div class="stats-meta">
                                <h3 class="stats-title">{{ lang('Total Views', 'dashboard') }}</h3>
                                <p class="stats-text">{{ number_format($countViews) }}</p>
                            </div>
                            <div class="stats-icon">
                                <i class="fa-solid fa-eye"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-v v3 mt-4">
        <div class="card-v-body">
            <h5 class="mb-4">{{ lang('Your upload statistics for current month', 'dashboard') }}</h5>
            <h5 class="mb-4">Total: {{ array_sum(json_decode($uploadCount)) }}</h5>
            <div class="dash-chart">
                <canvas id="uploads-chart"></canvas>
            </div>
        </div>
    </div>

    <div class="card-v v3 mt-4">
        <div class="card-v-body">
            <h5 class="mb-4">{{ lang('Your view statistics for current month', 'dashboard') }}</h5>
            <h5 class="mb-4">Total: {{ array_sum(json_decode($viewsCount)) }}</h5>
            <div class="dash-chart">
                <canvas id="views-chart"></canvas>
            </div>
        </div>
    </div>    
    @push('scripts_libs')
		 
        <script src="{{ asset('assets/vendor/libs/chartjs/chart.min.js') }}"></script>
    @endpush
@endsection

