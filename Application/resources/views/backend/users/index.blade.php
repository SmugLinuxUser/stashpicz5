@extends('backend.layouts.grid')
@section('title', __('Users'))
@section('link', route('admin.users.create'))
@section('content')
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-6 col-xxl-3">
            <div class="vironeer-counter-box bg-c-4">
                <h3 class="vironeer-counter-box-title">{{ __('Active Users') }}</h3>
                <p class="vironeer-counter-box-number">{{ $activeUsersCount }}</p>
                <span class="vironeer-counter-box-icon">
                    <i class="fa fa-users"></i>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl-3">
            <div class="vironeer-counter-box bg-c-7">
                <h3 class="vironeer-counter-box-title">{{ __('Banned Users') }}</h3>
                <p class="vironeer-counter-box-number">{{ $bannedUserscount }}</p>
                <span class="vironeer-counter-box-icon">
                    <i class="fa fa-ban"></i>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl-3">
            <div class="vironeer-counter-box bg-c-1">
                <h3 class="vironeer-counter-box-title">{{ __('Verified Users') }}</h3>
                <p class="vironeer-counter-box-number">{{ $verifiedUserscount }}</p>
                <span class="vironeer-counter-box-icon">
                    <i class="fas fa-user-check"></i>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl-3">
            <div class="vironeer-counter-box bg-secondary">
                <h3 class="vironeer-counter-box-title">{{ __('Unverified Users') }}</h3>
                <p class="vironeer-counter-box-number">{{ $unverifiedUserscount }}</p>
                <span class="vironeer-counter-box-icon">
                    <i class="fas fa-user-alt-slash"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="custom-card card">
        <div class="card-header p-3 border-bottom-small">
            <form action="{{ request()->url() }}" method="GET">
                <div class="input-group vironeer-custom-input-group">
                    <input type="text" name="search" class="form-control" placeholder="{{ __('Search on users...') }}"
                        value="{{ request()->input('search') ?? '' }}" required>
                    <button class="btn btn-secondary" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">{{ __('Filter') }}</button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item"
                                href="{{ request()->url() . '?filter=active' }}">{{ __('Active') }}</a></li>
                        <li><a class="dropdown-item"
                                href="{{ request()->url() . '?filter=banned' }}">{{ __('Banned') }}</a></li>
                    </ul>
                </div>
            </form>
        </div>
        <div>
            @if ($users->count() > 0)
                <div class="table-responsive">
                    <table class="vironeer-normal-table table w-100">
                        <thead>
                            <tr>
                                <th class="tb-w-3x">#</th>
                                <th class="tb-w-20x">{{ __('User details') }}</th>
                                <th class="tb-w-7x">{{ __('Username') }}</th>
                                <th class="tb-w-3x text-center">{{ __('Email status') }}</th>
                                <th class="tb-w-3x text-center">{{ __('Account status') }}</th>
                                <th class="tb-w-3x text-center">{{ __('Registred date') }}</th>
                                <th class="tb-w-3x text-center">{{ __('Storage') }}</th>
                                <th class="text-end"><i class="fas fa-sliders-h me-1"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        <div class="vironeer-user-box">
                                            <a class="vironeer-user-avatar"
                                                href="{{ route('admin.users.edit', $user->id) }}">
                                                <img src="{{ asset($user->avatar) }}" alt="User" />
                                            </a>
                                            <div>
                                                <a class="text-reset"
                                                    href="{{ route('admin.users.edit', $user->id) }}">{{ $user->firstname . ' ' . $user->lastname }}</a>
                                                <p class="text-muted mb-0">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td><i class="fa fa-user me-2"></i>{{ $user->username }}</td>
                                    <td class="text-center">
                                        @if ($user->email_verified_at)
                                            <span class="badge bg-c-1">{{ __('Verified') }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ __('Unverified') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($user->status)
                                            <span class="badge bg-success">{{ __('Active') }}</span>
                                        @else
                                            <span class="badge bg-c-7">{{ __('Banned') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ vDate($user->created_at) }}</td>
                                    <td><span class="badge bg-c-7">{{ formatBytes($user->storage) }}</span></td>
                                    <td>
                                        <div class="text-end">
                                            <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                                aria-expanded="true">
                                                <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-sm-end"
                                                data-popper-placement="bottom-end">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.users.edit', $user->id) }}"><i
                                                            class="fas fa-desktop me-2"></i>{{ __('Account details') }}</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.uploads.users.index') . '?user=' . hashid($user->id) }}"><i
                                                            class="fas fa-cloud-upload-alt me-2"></i>{{ __('Uploaded Images') }}</a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider" />
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                        method="POST">
                                                        @csrf @method('DELETE')
                                                        <button class="vironeer-able-to-delete dropdown-item text-danger"><i
                                                                class="far fa-trash-alt me-2"></i>{{ __('Delete') }}</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                @include('backend.includes.empty')
            @endif
        </div>
    </div>
    {{ $users->links() }}
@endsection
