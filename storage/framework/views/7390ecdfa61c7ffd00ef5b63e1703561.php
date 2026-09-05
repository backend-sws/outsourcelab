    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            primary: '#0d9488',   /* Classic Teal */
                            secondary: '#eab308', /* Smooth Gold/Yellow */
                            dark: '#115e59',      /* Deep Dark Teal */
                            light: '#f0fdfa',     /* Soft Mint Fade */
                            text: '#334155'       /* Smooth Slate Gray */
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .swiper-button-next, .swiper-button-prev {
            color: #115e59;
            background: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .swiper-button-next:after, .swiper-button-prev:after {
            font-size: 14px;
        }
        .section-title {
            color: #115e59;
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        /* Electricity Animation */
        @keyframes zipLine {
            0% { top: -50%; }
            100% { top: 150%; }
        }
        @keyframes flashElectric {
            0%, 100% { opacity: 0.2; }
            50% { opacity: 1; filter: brightness(1.5); }
        }
        .electricity-line {
            position: absolute;
            width: 2px;
            height: 250px;
            background: linear-gradient(to bottom, transparent, #00f2fe, #4facfe, #00f2fe, transparent);
            box-shadow: 0 0 10px #00f2fe, 0 0 20px #4facfe, 0 0 30px #4facfe;
            animation: zipLine linear infinite, flashElectric 0.1s infinite alternate;
            z-index: 15;
            border-radius: 50%;
        }
    </style>

<?php /**PATH D:\lab\lab\resources\views/partials/style.blade.php ENDPATH**/ ?>