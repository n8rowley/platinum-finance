<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Genos:ital,wght@0,200;0,300;0,500;1,400;1,900&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="{{ mix('css/style.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body>
    <div id="app">
        <div class="title-bar">
            <a href="#" class="logo">PLATINUM</a>
            <div class="money">$32,000</div>
        </div>
        <div class="side-bar">
            <ul class="menu">
                <div class="menu-section">
                    <li class="list-category"><a href="#">Transactions</a></li>
                    <ul>
                        <li>2023</li>
                        <li>Older</li>
                    </ul>
                </div>
        
                <div class="menu-section">
                    <li class="list-category"><a href="#">Expenses</a></li>
                    <ul>
                        <li><a href="#">2023</a></li>
                        <li>Older</li>
                    </ul>
                </div>
        
                <div class="menu-section">
                    <li class="list-category"><a href="#">Uploads</a></li>
                </div>
                <div class="menu-section">
                    <li class="list-category"><a href="#">Assign Expenses</a></li>
                </div>
            </ul>
        </div>
        <div class="content">
            <view-router></view-router>
        </div>
    </div>
</body>
@yield('postJS')
</html>
