<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css">
        <link rel="stylesheet" type="text/css" href="../../public/css/main.css">
        <script src="../../public/js/main.js"></script>
        <?php $settings = $_SESSION['settings']; ?>
        <link rel="shortcut icon" href="../../public/images/<?php echo htmlspecialchars($settings['image_icon']); ?>" type="image/x-icon">
        
        <title><?php echo htmlspecialchars($settings['name_website']); ?> - *</title>
        <meta name="description" content="Filantropia premiável.">
        <meta name="keywords" content="Campanha, Rifa, Ação entre amigos, Prêmio">
        <meta name="robots" content="index, follow">

        <?php if (isset($campaign)): ?>
            <!-- Open Graph Meta Tags -->
            <meta property="og:title" content="<?php echo strtoupper(htmlspecialchars($campaign['name'])); ?>" />
            <meta property="og:description" content="<?php echo htmlspecialchars($campaign['subname']); ?>" />
            <meta property="og:image" content="https://<?php echo $_SERVER['HTTP_HOST'] ?>/public/images/<?php echo htmlspecialchars($campaign['image_raffle']); ?>" />
            <meta property="og:url" content="https://<?php echo $_SERVER['HTTP_HOST'] ?>/campanha/<?php echo htmlspecialchars($campaign['slug']); ?>" />
            <meta property="og:type" content="website" />
            <meta property="og:site_name" content="<?php echo htmlspecialchars($settings['name_website']); ?>" />
        <?php endif; ?>
        
        <!-- Facebook Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '<?php echo htmlspecialchars($settings['id_pixel_facebook']); ?>');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=<?php echo htmlspecialchars($settings['id_pixel_facebook']); ?>&ev=PageView&noscript=1"
        /></noscript>
        
        <!-- Google Tag Manager -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo htmlspecialchars($settings['tag_google']); ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '<?php echo htmlspecialchars($settings['tag_google']); ?>');
        </script>
        
        <script src="../../public/js/partials/header.js"></script>
    </head>





