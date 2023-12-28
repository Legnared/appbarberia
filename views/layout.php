<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Salón</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Hedvig+Letters+Serif" > 
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="icon" href="/build/img/imagen">
    <link rel="stylesheet" href="/build/css/app.css">
</head>
<body>
    <div class="contenedor-app">

        <div class="imagen "></div>

        <div class="app animate__animated animate__fadeInDownBig">
            <?php echo $contenido; ?>
        </div>
        
    </div>
  
    <?php 
        echo $script ?? '';
    ?>
            
</body>
</html>