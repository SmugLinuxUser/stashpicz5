<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OembedController extends Controller
{
/**
* Show the oembed response for a given resource.
*/
public function show(Request $request)
{
// Validate the request parameters


// Generate the oembed response data
$oembed = [
'type' => 'video', // The type of the resource, e.g. video, photo, link, etc.
'version' => '1.0', // The oembed version number
'title' => 'Some awesome video', // The title of the resource
'author_name' => 'Some awesome author', // The name of the author or owner of the resource
'author_url' => 'https://example.com/author', // The URL of the author or owner of the resource
'provider_name' => 'Some awesome provider', // The name of the provider of the resource
'provider_url' => 'https://example.com/provider', // The URL of the provider of the resource
'width' => 640, // The width of the embedded resource in pixels
'height' => 480, // The height of the embedded resource in pixels
'html' => '<iframe src="https://example.com/embed" width="640" height="480" frameborder="0" allowfullscreen></iframe>', // The HTML code to embed the resource
];

// Return the oembed response data as a JSON response
return response()->json($oembed)
->header('Content-Type', 'application/json+oembed');
}
}
