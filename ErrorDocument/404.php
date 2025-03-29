
<?php require_once '../includes/auth.php'; require_once '../includes/get_setting.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Animation</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }
        
        .container {
            text-align: center;
            max-width: 800px;
            padding: 20px;
        }
        
        .animation-container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto 20px;
        }
        
        h1 {
            color: #333;
            margin-bottom: 10px;
        }
        
        p {
            color: #666;
            margin-bottom: 20px;
        }
        
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4285f4;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        
        .back-button:hover {
            background-color: #3367d6;
        }
    </style>
</head>
<body class="<?php echo $settings['dark_mode'] ? 'dark-mode' : ''; ?>">
    <div class="container">
        <div class="animation-container" id="lottie-container"></div>
        <h1>Page Not Found</h1>
        <p>The page you're looking for doesn't exist or has been moved.</p>
        <a href="/" class="back-button">Back to Home</a>
    </div>

    <!-- Load Lottie library from CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.6/lottie.min.js"></script>
    
    <script>
        // Initialize Lottie animation
        document.addEventListener('DOMContentLoaded', function() {
            const animationContainer = document.getElementById('lottie-container');
            
            // Load your Lottie animation
            const animation = lottie.loadAnimation({
                container: animationContainer,
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: 'assets/lottie/404.json'
            });
        });
    </script>
</body>
</html>