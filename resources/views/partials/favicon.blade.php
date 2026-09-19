@php
    $siteFavicon = \App\Models\Setting::get('site_favicon');
    if ($siteFavicon) {
        $siteFavicon = str_starts_with($siteFavicon, 'http') ? $siteFavicon : asset($siteFavicon);
    } else {
        $siteFavicon = asset('favicon.png');
    }
@endphp
<!-- Browser Tabbar Favicon -->
<link rel="icon" href="{{ $siteFavicon }}">
<link rel="shortcut icon" href="{{ $siteFavicon }}">
<link rel="apple-touch-icon" href="{{ $siteFavicon }}">
