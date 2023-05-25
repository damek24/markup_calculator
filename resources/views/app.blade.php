<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    
    @vite(['resources/js/app.js', 'resources/scss/app.scss', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>
<body class="d-flex flex-column h-100">
<div id="app" class="d-flex flex-column h-100" data-page="{{ json_encode($page) }}"></div>
<link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</body>
</html>
