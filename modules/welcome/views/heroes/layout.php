<!-- 
    Layouting example

    * You can create main file to be your layout
    * after that you can include all file you need using loadView();
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Heroes Module' ?></title>
    <link rel="stylesheet" href="/systems/web/empu.css">
</head>
<body>

    <div class="empu-container">
        <p class="empu-title">Empu Foundations</p>
        <small>- List of heroes who ready to protect the world!</small>
        <hr />

        <?php self::loadView($content); ?>
    </div>
    
</body>
</html>