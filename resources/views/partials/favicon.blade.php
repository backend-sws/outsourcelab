@php
    $siteFavicon = \App\Models\Setting::getFaviconUrl();
@endphp
<!-- Browser Tabbar Favicon -->
<link rel="icon" href="{{ $siteFavicon }}">
<link rel="shortcut icon" href="{{ $siteFavicon }}">
<link rel="apple-touch-icon" href="{{ $siteFavicon }}">
