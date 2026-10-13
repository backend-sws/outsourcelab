<?php
    $siteFavicon = \App\Models\Setting::getFaviconUrl();
?>
<!-- Browser Tabbar Favicon -->
<link rel="icon" href="<?php echo e($siteFavicon); ?>">
<link rel="shortcut icon" href="<?php echo e($siteFavicon); ?>">
<link rel="apple-touch-icon" href="<?php echo e($siteFavicon); ?>">
<?php /**PATH D:\lab\lab\resources\views/partials/favicon.blade.php ENDPATH**/ ?>