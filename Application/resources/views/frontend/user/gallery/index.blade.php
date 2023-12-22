@extends('frontend.user.layouts.dash')
@section('title', lang('My Gallery', 'gallery'))
@section('upload', true)
@section('content')
    @if ($fileEntries->count() > 0)
        <div class="section-body">
            <div class="filemanager-actions">
                <div class="form-check p-0" data-select="{{ lang('Select All', 'gallery') }}"
                    data-unselect="{{ lang('Unselect All', 'gallery') }}">
                    <input id="selectAll" type="checkbox" class="d-none filemanager-select-all" />
                    <label type="checkbox" class="btn btn-secondary btn-md"
                        for="selectAll">{{ lang('Select All', 'gallery') }}</label>
                </div>
                <form action="{{ route('user.gallery.destroy.all') }}" method="POST">
                    @csrf
                    <input type="hidden" name="ids" id="filesSelectedInput" />
                    <button class="btn btn-danger btn-md confirm-action-form"><i
                            class="fa-regular fa-trash-can me-2"></i>{{ lang('Delete all Selected', 'gallery') }}</button>
                </form>
            </div>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xxl-3 g-3">
                @foreach ($fileEntries as $fileEntry)
                    <div class="col">
                        <div class="filemanager-file">
                            <div class="filemanager-file-actions">
                                <div class="form-check">
                                    <input id="{{ $fileEntry->shared_id }}" type="checkbox" class="form-check-input" />
                                </div>
                                <div class="drop-down" data-dropdown data-dropdown-position="top">
                                    <div class="drop-down-btn p-1">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </div>
                                    <div class="drop-down-menu">
                                        @if ($fileEntry->access_status)
                                            <a href="#" class="drop-down-item fileManager-share-file"
                                                data-share='{"filename":"{{ $fileEntry->name }}","share_link":"{{ route('file.view', $fileEntry->shared_id) }}","reddit_link":"{{ route('file.view', $fileEntry->shared_id) }}", "direct_link":"{{ route('file.secure', $fileEntry->filename) }}"}'>
                                                <i class="fa-solid fa-share-from-square"></i>
                                                {{ lang('Share', 'gallery') }}
                                            </a>
                                        @endif
                                        <a href="{{ route('file.view', $fileEntry->shared_id) }}" target="_blank"
                                            class="drop-down-item">
                                            <i class="fa fa-eye"></i>
                                            {{ lang('Preview', 'gallery') }}
                                        </a>
                                        @if (uploadSettings()->upload->allow_downloading)
                                            <a href="{{ route('user.gallery.download', $fileEntry->shared_id) }}"
                                                class="drop-down-item">
                                                <i class="fa-solid fa-download"></i>
                                                {{ lang('Download', 'gallery') }}
                                            </a>
                                        @endif
                                        <a href="{{ route('user.gallery.edit', $fileEntry->shared_id) }}"
                                            class="drop-down-item">
                                            <i class="fa fa-edit"></i>
                                            {{ lang('Edit details', 'gallery') }}
                                        </a>
                                        <a href="#" class="drop-down-item text-danger delete-file"
                                            data-id="{{ $fileEntry->shared_id }}">
                                            <i class="fa-regular fa-trash-can"></i>
                                            {{ lang('Delete', 'gallery') }}
                                        </a>
                                    </div>
                                    <form id="deleteFile{{ $fileEntry->shared_id }}"
                                        action="{{ route('user.gallery.destroy', $fileEntry->shared_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                            <a href="{{ route('user.gallery.edit', $fileEntry->shared_id) }}"
                                class="filemanager-file-icon filemanager-link">
                                <?php
                                $temp= explode('.',$fileEntry->name);
                                $extension = end($temp);
                                ?>
                                @if(in_array($extension, array('mp4', 'webm', 'ogg', 'mpeg', 'mov', 'MOV')))
                               

                                <?php



$thumbnail = "thumbnail-" . $fileEntry->filename . ".gif";

echo '<img src=http://local/stashpicz/httpdocs/images/thumbnails/'.$thumbnail.'>';
?>
                                @else
                                
                               
                                <img src="{{ route('file.secure', $fileEntry->filename) }}"
                                    alt="{{ $fileEntry->name }}" />
                               @endif     
                            </a>
                            <a href="{{ route('user.gallery.edit', $fileEntry->shared_id) }}"
                                class="filemanager-file-title filemanager-link">{{ $fileEntry->name }}</a>
                            <p class="filemanager-file-meta mb-0">{{ vDate($fileEntry->created_at) }}</p>

                            
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $fileEntries->links() }}
        </div>
        <div id="shareModal" class="modal fade share-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form class="modal-content">
                    <div class="modal-header border-0 pb-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 pt-1 mb-1">
                        <h5 class="mb-4"><i class="fas fa-share-alt me-2"></i>{{ lang('Share this image', 'gallery') }}
                        </h5>
                        <p class="mb-3 text-ellipsis filename"></p>
                        <div class="mb-3">
                            <div class="share v2"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>{{ lang('Share link', 'gallery') }}</strong></label>
                            <div class="input-group">
                                <input id="copy-share-link" type="text" class="form-control" value="" readonly>
                                <button type="button" class="btn btn-primary btn-md btn-copy"
                                    data-clipboard-target="#copy-share-link"><i class="far fa-clone"></i></button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>{{ lang('Reddit Link', 'gallery') }}</strong></label>
                            <div class="input-group">
                                <input id="reddit" type="text" class="form-control" value="" readonly>
                                <button type="button" class="btn btn-primary btn-md btn-copy"
                                    data-clipboard-target="#reddit"><i class="far fa-clone"></i></button>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label"><strong>{{ lang('HTML code', 'gallery') }}</strong></label>
                            <div class="textarea-btn">
                                <textarea id="htmlCode" class="form-control" rows="5" readonly></textarea>
                                <button type="button" class="btn btn-primary btn-copy"
                                    data-clipboard-target="#htmlCode">{{ lang('Copy', 'gallery') }}</button>
                            </div>
                        </div>
                        <label class="form-label"><strong>{{ lang('BBCode', 'gallery') }}</strong></label>
                        <div class="textarea-btn">
                            <textarea id="bbCode" class="form-control" rows="5" readonly></textarea>
                            <button type="button" class="btn btn-primary btn-copy"
                                data-clipboard-target="#bbCode">{{ lang('Copy', 'gallery') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @else
        @section('empty', true)
        @if (request()->has('search'))
            @include('frontend.global.includes.noResults')
        @else
            @include('frontend.user.includes.empty')
        @endif
    @endif
    @push('scripts_libs')
        <script src="{{ asset('assets/vendor/libs/clipboard/clipboard.min.js') }}"></script>
    @endpush
@endsection
