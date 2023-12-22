@extends('frontend.layouts.pages')
@section('hide_header', true)
@section('section_class', 'pt-0 pb-0')
@section('section', lang('image', 'image page'))
@section('title', $fileEntry->name)
@section('og_image', route('file.secure', $fileEntry->filename))
@section('content')

@if($fileEntry->nsfw === "true")
  <style>
    /* styles for the modal */
    .nsfwmodal {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 9999; display: flex; justify-content: center; align-items: center;
    }
    @media only screen and (max-width: 600px){
    .nsfwmodal {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 9999; display: flex; justify-content: center; align-items: center;
    }


    }
    /* styles for the warning text */
    #warning {
		
      background-color: white;
      padding: 20px;
	   width: 80%;
      height: 80%;	
      border-radius: 10px;
      text-align: center;
    }

 /* CSS */
.button-31 {
  appearance: button;
  background-color: #808080;
  position:relative;
  top: 600px;
  border: solid transparent;
  border-radius: 16px;
  border-width: 0 0 4px;
  box-sizing: border-box;
  color: #FF0000;
  cursor: pointer;
  display: inline-block;
  font-family: din-round,sans-serif;
  font-size: 15px;
  font-weight: 700;
  letter-spacing: .8px;
  line-height: 20px;
  margin: 0;
  margin-left: 30px;
  outline: none;
  overflow: visible;
  padding: 13px 16px;
  text-align: center;
  text-transform: uppercase;
  touch-action: manipulation;
  transform: translateZ(0);
  transition: filter .2s;
  user-select: none;
  -webkit-user-select: none;
  vertical-align: middle;
  white-space: nowrap;
  width: 30%;
}

.button-32 {
  appearance: button;
  background-color: #808080;
  position:relative;
  top: 600px;
  border: solid transparent;
  border-radius: 16px;
  border-width: 0 0 4px;
  box-sizing: border-box;
  color: #FF0000;
  cursor: pointer;
  display: inline-block;
  font-family: din-round,sans-serif;
  font-size: 15px;
  font-weight: 700;
  letter-spacing: .8px;
  line-height: 20px;
  margin: 0;
  margin-left: 50px;
  outline: none;
  overflow: visible;
  padding: 13px 16px;
  text-align: center;
  text-transform: uppercase;
  touch-action: manipulation;
  transform: translateZ(0);
  transition: filter .2s;
  user-select: none;
  -webkit-user-select: none;
  vertical-align: middle;
  white-space: nowrap;
  width: 30%;
}

.warning{
    position: absolute;
    left: 40%; 
    top: 200px; 
    width: 20%;
}
@media only screen and (max-width: 600px){
.warning {
    position: absolute;
    left: 50px; 
    top: 200px; 
    width: 80%;
}
}

  </style>

<div id="modal" class="nsfwmodal" >
    <!-- the warning text -->
    <div id="warning" style="background-color: #fff; width: 100%; height: 100%; padding: 20px; border: 1px solid #000; text-align: center;">
        
        <img src="http://local/stashpicz/httpdocs/images/nsfw-warning.png" class="warning" alt="NSFW Image" >
        
        <button class="button-31" id="yes" role="button">ENTER</button>
        <button class="button-32" id="exit" role="button">EXIT</button>
    </div>
</div>
 <script>
    // get the modal and the buttons
    const modal = document.querySelector('#modal');
    const yesButton = document.querySelector('#yes');
    const noButton = document.querySelector('#exit');
    
    // hide the modal by default
    modal.style.display = 'none';
    
    // show the modal when the page loads
 
      modal.style.display = 'flex';
    
    
    // handle the button clicks
    yesButton.addEventListener('click', function() {
      modal.style.display = 'none';
    });
    
    noButton.addEventListener('click', function() {
      close();
    });
  </script>

@endif



    <div class="fileviewer">
        <div class="container-lg">
            <div class="fileviewer-body">
                {!! ads_image_page_image_top() !!}
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
                if (in_array($file_ext, array('mp4', 'webm', 'ogg', 'mpeg','mov','MOV'))) {
                    // generate video tag
                    echo '<video class="videofile" src="' . $hope . '" style="width:70%;" controls></video>';

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
<a href="//www.dmca.com/Protection/Status.aspx?ID=c335e4b7-d0ac-4d77-98d8-4b1918e69ae7" title="DMCA.com Protection Status" class="dmca-badge"> <img src ="https://images.dmca.com/Badges/dmca_protected_sml_120m.png?ID=c335e4b7-d0ac-4d77-98d8-4b1918e69ae7"  alt="DMCA.com Protection Status" /></a>  <script src="https://images.dmca.com/Badges/DMCABadgeHelper.min.js"> </script>
<script>
// Create a new XMLHttpRequest object
var xhr = new XMLHttpRequest();

// Define the URL to send the request to
var url = "http://local/stashpicz/httpdocs/ib/embed.show";

// Open a connection to the server
xhr.open("GET", url, true);

// Set the request header to accept JSON
xhr.setRequestHeader("Accept", "application/json");

// Define a callback function to handle the response
xhr.onload = function() {
// Check if the request was successful
if (xhr.status === 200) {
// Parse the JSON response
var data = JSON.parse(xhr.responseText);
// Do something with the data
console.log(data);
} else {
// Handle the error
console.error("Request failed: " + xhr.statusText);
}
};

// Send the request
xhr.send();


</script>
                {!! ads_image_page_image_bottom() !!}
                <div class="border-top mt-5 pt-4 mb-4">
                    <div class="row row-cols-auto align-items-center justify-content-between g-3">
                        <div class="col">
                            <div class="fileviewer-user">
                                <div class="fileviewer-user-img">
                                    <img src="{{ fileUser($fileEntry)->avatar }}" alt="{{ fileUser($fileEntry)->name }}" />
                                </div>
                                <div class="fileviewer-user-info">
                                    <h5 class="fileviewer-user-title mb-2">{{ fileUser($fileEntry)->name }}</h5>
                                    <div class="fileviewer-user-meta">
                                        <div class="fileviewer-user-meta-item">
                                            <i class="fa-solid fa-calendar me-1"></i>
                                            {{ vDate($fileEntry->created_at) }}
                                        </div>
                                        <div class="fileviewer-user-meta-item ms-2">
                                            <i class="fa-solid fa-eye me-1"></i>
                                            {{ formatNumber($fileEntry->views) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row row-cols-auto g-2">
                                @if (uploadSettings()->upload->allow_downloading)
                                    <div class="col">
                                        <button class="btn btn-primary btn-md download-file"
                                            data-id="{{ $fileEntry->shared_id }}">
                                            <i class="fa fa-download me-1"></i>
                                            {{ lang('Download', 'image page') }}
                                        </button>
                                    </div>
                                @endif
                                <div class="col">
                                    <button class="fileviewer-sidebar-open btn btn-danger btn-md">
                                        <i class="fa-solid fa-share-nodes me-1"></i>
                                        {{ lang('Share', 'image page') }}
                                    </button>
                                </div>
                                @php
                                    $reportFileStatus = auth()->user() && $fileEntry->user_id == userAuthInfo()->id ? false : true;
                                @endphp
                                @if ($reportFileStatus)
                                    <div class="col">
                                        <a data-bs-toggle="modal" data-bs-target="#report" class="btn btn-secondary btn-md">
                                            <i class="fa-regular fa-flag me-1"></i>
                                            {{ lang('Report', 'image page') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <aside class="fileviewer-sidebar">
            <div class="overlay"></div>
            <div class="fileviewer-sidebar-content">
                <div class="fileviewer-sidebar-header">
                    <h5 class="fileviewer-sidebar-title">{{ lang('Share', 'image page') }}</h5>
                    <a class="fileviewer-sidebar-close">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
                <div class="fileviewer-sidebar-body" data-simplebar>
                    @if ($fileEntry->access_status)
                        <div class="fileviewer-sidebar-section">
                            <div class="share v2">
                                @include('frontend.blog.includes.share-buttons')
                            </div>
                        </div>
                        <div class="fileviewer-sidebar-section">
                            <p class="fileviewer-sidebar-section-title">{{ lang('Share Link', 'image page') }}</p>
                            <div class="input-group">
                                <input id="downloadLink" type="text" class="form-control form-control-md"
                                    value="{{ route('file.view', $fileEntry->shared_id) }}" readonly />
                                <button type="button" class="btn btn-primary btn-copy px-20p"
                                    data-clipboard-target="#downloadLink">
                                    <i class="fa-regular fa-clone fa-lg"></i>
                                </button>
                            </div>
                            
                        </div>
                       <?php
                       
                       ?>
                        <div class="fileviewer-sidebar-section">
                            <p class="fileviewer-sidebar-section-title">{{ lang('Reddit Link', 'image page') }}</p>
                            <div class="input-group">
                            <?php
                                $temp= explode('.',$fileEntry->name);
                                $extension = end($temp);
                                ?>   
                            @if(in_array($extension, array('mp4', 'webm', 'ogg', 'mpeg', 'mov', 'MOV'))) 
                            <input id="RedditLink" type="text" class="form-control form-control-md"
                                    value="{{ 'http://local/stashpicz/httpdocs/images/thumbnails/' . 'thumbnail-' . $fileEntry->filename . '.gif' }}" readonly />

                            @else
                                <input id="RedditLink" type="text" class="form-control form-control-md"
                                    value="{{ route('file.secure', $fileEntry->filename) }}" readonly />
                             @endif       
                                <button type="button" class="btn btn-primary btn-copy px-20p"
                                    data-clipboard-target="#RedditLink">
                                    <i class="fa-regular fa-clone fa-lg"></i>
                                </button>
                            </div>
                            
                        </div>
                        <div class="fileviewer-sidebar-section">
                            <p class="fileviewer-sidebar-section-title">{{ lang('HTML Code', 'image page') }}</p>
                            <div class="textarea-btn">
                                <textarea id="htmlCode" class="form-control" rows="5" readonly><a target="_blank" href="{{ route('file.view', $fileEntry->shared_id) }}"><img src="{{ route('file.secure', $fileEntry->filename) }}" alt="{{ $fileEntry->name }}"/></a></textarea>
                                <button class="btn btn-primary btn-copy"
                                    data-clipboard-target="#htmlCode">{{ lang('Copy', 'image page') }}</button>
                            </div>
                        </div>
                        <div class="fileviewer-sidebar-section">
                            <p class="fileviewer-sidebar-section-title">{{ lang('BBCode', 'image page') }}</p>
                            <div class="textarea-btn">
                                <textarea id="bbCode" class="form-control" rows="5" readonly>[url={{ route('file.view', $fileEntry->shared_id) }}][img]{{ route('file.secure', $fileEntry->filename) }}[/img][/url]</textarea>
                                <button class="btn btn-primary btn-copy"
                                    data-clipboard-target="#bbCode">{{ lang('Copy', 'image page') }}</button>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger">
                            <div class="row">
                                <div class="col-1">
                                    <i class="fas fa-exclamation-circle me-2 fa-lg"></i>
                                </div>
                                <div class="col">
                                    {{ lang('Images with private access cannot be shared', 'image page') }}
                                    <a
                                        href="{{ route('user.gallery.edit', $fileEntry->shared_id) }}">{{ lang('Change access status', 'image page') }}</a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </aside>
    </div>
    {!! ads_image_page_center() !!}
    @if ($blogArticles->count() > 0 && $settings['website_blog_status'])
        <section class="section">
            <div class="container-lg">
                <div class="section-inner">
                    <div class="section-header">
                        <div class="section-title">
                            <h5>{{ lang('Latest blog posts', 'image page') }}</h5>
                        </div>
                    </div>
                    <div class="section-body">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 justify-content-center g-3">
                            @foreach ($blogArticles as $blogArticle)
                                <div class="col">
                                    <div class="blog-post">
                                        <div class="blog-post-header">
                                            <a href="{{ route('blog.article', $blogArticle->slug) }}">
                                                <img src="{{ asset($blogArticle->image) }}"
                                                    alt="{{ $blogArticle->title }}" class="blog-post-img" />
                                            </a>
                                        </div>
                                        <div class="blog-post-body">
                                            <a class="blog-post-cate"
                                                href="{{ route('blog.category', $blogArticle->blogCategory->slug) }}">
                                                {{ $blogArticle->blogCategory->name }}
                                            </a>
                                            <a href="{{ route('blog.article', $blogArticle->slug) }}"
                                                class="blog-post-title">
                                                <h6>{{ $blogArticle->title }}</h6>
                                            </a>
                                            <p class="blog-post-text">
                                                {{ shortertext($blogArticle->short_description, 120) }}
                                            </p>
                                        </div>
                                        <div class="blog-post-footer">
                                            <div class="blog-post-user-img">
                                                <img src="{{ asset($blogArticle->admin->avatar) }}"
                                                    alt="{{ oneName($blogArticle->admin) }}" />
                                            </div>
                                            <div class="blog-post-user-info">
                                                <span
                                                    class="blog-post-user-name">{{ oneName($blogArticle->admin) }}</span>
                                                <time class="blog-post-time">{{ vDate($blogArticle->created_at) }}</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-center mt-5">
                            <a href="{{ route('blog.index') }}"
                                class="btn btn-primary-icon btn-md">{{ lang('View More', 'image page') }}<i
                                    class="fas {{ currentLanguage()->direction == 2 ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    {!! ads_image_page_bottom() !!}
    @if ($reportFileStatus)
        <div id="report" class="modal fade" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ lang('Report this image', 'image page') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('file.report', $fileEntry->shared_id) }}" method="POST">
                            @csrf
                            <div class="row g-3 mb-3">
                                <div class="col-lg-6">
                                    <label class="form-label">{{ lang('Name', 'image page') }} : <span
                                            class="red">*</span></label>
                                    <input type="name" name="name" class="form-control form-control-md"
                                        value="{{ userAuthInfo()->name ?? '' }}" required>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label">{{ lang('Email', 'image page') }} : <span
                                            class="red">*</span></label>
                                    <input type="email" name="email" class="form-control form-control-md"
                                        value="{{ userAuthInfo()->email ?? '' }}" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ lang('Reason for reporting', 'image page') }} :
                                    <span class="red">*</span></label>
                                <select name="reason" class="form-select form-select-md" required>
                                    @foreach (reportReasons() as $reasonsKey => $reasonsValue)
                                        <option value="{{ $reasonsKey }}">{{ $reasonsValue }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ lang('Details', 'image page') }} : <span
                                        class="red">*</span></label>
                                <textarea name="details" class="form-control" rows="7"
                                    placeholder="{{ lang('Describe the reason why you reported the image to a maximum of 600 characters', 'image page') }}"
                                    required></textarea>
                            </div>
                            {!! display_captcha() !!}
                            <button type="submit"
                                class="btn btn-primary btn-md">{{ lang('Send', 'image page') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @push('scripts_libs')
        <script src="{{ asset('assets/vendor/libs/clipboard/clipboard.min.js') }}"></script>
    @endpush
    @push('scripts')
        {!! google_captcha() !!}
    @endpush
@endsection
