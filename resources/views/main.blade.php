<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Genos:ital,wght@0,200;0,300;0,500;1,400;1,900&display=swap" rel="stylesheet"> 
    <script src="{{ mix('js/app.js') }}" defer></script>
    <link rel="stylesheet" href="{{ mix('css/style.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
          prefix: 'tw-',
        }
      </script>
</head>
<body>
    <div id="app">
        <div class="title-bar">
            <a href="#" class="logo">PLATINUM</a>
            <div class="money">$32,000</div>
        </div>
        <side-bar></side-bar>
        <div class="content">
            <router-view></router-view>
        </div>
    </div>
</body>
@yield('postJS')
</html>
