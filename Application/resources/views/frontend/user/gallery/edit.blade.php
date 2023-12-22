@extends('frontend.user.layouts.dash')
@section('section', lang('My Gallery', 'gallery'))
@section('title', $fileEntry->name)
@section('back', route('user.gallery.index'))
@section('content')
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card-v shadow-sm border-0">
                <div class="card-v-body p-0">
                    <div class="mb-4">
                    <div class="fileviewer">
    <div class="container-lg">
        <div class="fileviewer-body">
            {!! ads_image_page_image_top() !!}
            <div class="fileviewer-file">
                <?php
                // replace $fileEntry->filename with the name of your file
                $filename = $fileEntry->filename;
                
                // get the file extension
                $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                
                // check if the file is a video
                if (in_array($file_ext, array('mp4', 'webm', 'ogg', 'mpeg', 'mov', 'MOV'))) {
                    // generate video tag
                    echo '<video src="' . route('file.secure', $filename) . '" style="width:70%;" controls></video>';
                }
                // check if the file is an image
                else if (in_array($file_ext, array('jpg', 'jpeg', 'png', 'gif'))) {
                    // generate image tag
                    echo '<img src="' . route('file.secure', $filename) . '" alt="' . $fileEntry->name . '" title="' . $fileEntry->name . '">';
                }
                // file is not a video or an image
                else {
                    echo 'Unsupported file type';
                }
                ?>
            </div>
            {!! ads_image_page_image_bottom() !!}
        </div>
    </div>
</div>
                        <div class="d-flex justify-content-between">
                            <h5>{{ $fileEntry->name }}</h5>
                            <p class="text-muted">
                                <span class="me-2"><i
                                        class="fa fa-eye me-2"></i>{{ formatNumber($fileEntry->views) }}</span>
                                <span><i class="fa fa-download me-2"></i>{{ formatNumber($fileEntry->downloads) }}</span>
                            </p>
                        </div>
                    </div>
                    <form action="{{ route('user.gallery.update', $fileEntry->shared_id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label">{{ lang('Image Name', 'gallery') }} : <span
                                    class="red">*</span></label>
                            <input type="text" name="filename" class="form-control form-control-md"
                                value="{{ $fileEntry->name }}">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">{{ lang('Access status', 'gallery') }} : <span
                                    class="red">*</span></label>
                            <select name="access_status" class="form-select form-select-md">
                                <option value="1" {{ $fileEntry->access_status == 1 ? 'selected' : '' }}>
                                    {{ lang('Public', 'gallery') }}</option>
                                <option value="0" {{ $fileEntry->access_status == 0 ? 'selected' : '' }}>
                                    {{ lang('Private', 'gallery') }}</option>
                            </select>
                        </div>
                        @if (uploadSettings()->upload->password_protection)
                            <div class="mb-3">
                                <label class="form-label">{{ lang('Image Password (Optional)', 'gallery') }}</label>
                                <div class="input-group input-icon input-password">
                                    <input type="password" name="password" class="form-control form-control-md"
                                        placeholder="{{ lang('Enter Password', 'gallery') }}">
                                    <button type="button" id="input-group-button-right">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                                <small
                                    class="text-muted">{{ lang('Leave password empty to remove it', 'gallery') }}</small>
                            </div>
                        @endif
                        @if ($fileEntry->password)
                            <div class="alert alert-success">
                                <i class="fa fa-lock me-2"></i>{{ lang('Image protected by password', 'gallery') }}
                            </div>
                        @endif
                        <button class="btn btn-primary btn-md">{{ lang('Save changes', 'gallery') }}</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card-v shadow-sm border-0 h-100">
                <div class="card-v-body p-0">
                    @if ($fileEntry->access_status)
                        <button class="btn btn-success btn-lg w-100 mb-3 fileManager-share-file"
                            data-share='{"filename":"{{ $fileEntry->name }}","share_link":"{{ route('file.view', $fileEntry->shared_id) }}", "direct_link":"{{ route('file.secure', $fileEntry->filename) }}"}'>
                            <i class="fas fa-share-alt me-2"></i>{{ lang('Share', 'gallery') }}</button>
                    @endif
                    <a href="{{ route('file.view', $fileEntry->shared_id) }}" target="_blank"
                        class="btn btn-dark btn-lg w-100 mb-3"><i
                            class="fa fa-eye me-2"></i>{{ lang('Preview', 'gallery') }}</a>
                    <a href="{{ route('user.gallery.download', $fileEntry->shared_id) }}"
                        class="btn btn-primary btn-lg w-100 mb-3"><i
                            class="fa fa-download me-2"></i>{{ lang('Download', 'gallery') }}</a>
                    <form action="{{ route('user.gallery.destroy', $fileEntry->shared_id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger w-100  btn-lg confirm-action-form"><i
                                class="fa-regular fa-trash-can me-2"></i>{{ lang('Delete', 'gallery') }}</button>
                    </form>
                </div>
            </div>
        </div>
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
    @push('scripts_libs')
        <script src="{{ asset('assets/vendor/libs/clipboard/clipboard.min.js') }}"></script>
    @endpush
@endsection
