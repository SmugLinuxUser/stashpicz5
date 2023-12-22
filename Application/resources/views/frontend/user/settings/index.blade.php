@extends('frontend.user.layouts.dash')
@section('title', lang('Settings', 'user'))
@section('content')
    <div class="settingsbox">
        <div class="row g-3">
            <div class="col-xl-3">
                @include('frontend.user.includes.list')
            </div>
            <div class="col-xl-9">
                <div class="card-v v3 p-0">
                    <div class="settings-form">
                        <div class="settings-form-header">
                            <h5 class="mb-0">{{ lang('Account details', 'user') }}</h5>
                        </div>
                        <div class="settings-form-body">
                            <form id="deatilsForm" action="{{ route('user.settings.details.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row row-cols-1 row-cols-sm-2 g-3 mb-3">
                                    <div class="col">
                                        <label class="form-label">{{ lang('First Name', 'forms') }} : <span
                                                class="red">*</span></label>
                                        <input type="firstname" name="firstname" class="form-control form-control-md"
                                            placeholder="{{ lang('First Name', 'forms') }}" maxlength="50"
                                            value="{{ $user->firstname }}" required>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">{{ lang('Last Name', 'forms') }} : <span
                                                class="red">*</span></label>
                                        <input type="lastname" name="lastname" class="form-control form-control-md"
                                            placeholder="{{ lang('Last Name', 'forms') }}" maxlength="50"
                                            value="{{ $user->lastname }}" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">{{ lang('Username', 'forms') }} : </label>
                                    <input class="form-control form-control-md"
                                        placeholder="{{ lang('Username', 'forms') }}" value="{{ $user->username }}"
                                        readonly>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">{{ lang('Email address', 'forms') }} : <span
                                            class="red">*</span></label>
                                    <input type="email" name="email" class="form-control form-control-md"
                                        placeholder="{{ lang('Email address', 'forms') }}" value="{{ $user->email }}"
                                        required>
                                </div>
                                @if((Auth::user()) and is_file(storage_path("app/public/" . "/uploads/users/" . hashid(userAuthInfo()->id) . "/" . "watermark.jpg")))
                                <img id="water" src="{{ 'http://local/stashpicz/httpdocs/Application/storage/' . 'app/public' . '/uploads/users/' . hashid(userAuthInfo()->id) . '/' . 'watermark.jpg' }}" alt="water"
                        class="rounded-circle mb-3" width="120px" height="120px">

                                @endif
                                <label class="form-label">{{ lang('Watermark logo', 'forms') }} : </span></label>
                                    
                                        <input type="file" name="watermark" id="watermark">
                                </div>                                
                                <button class="btn btn-primary btn-md">
                                    {{ lang('Save Changes', 'user') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
