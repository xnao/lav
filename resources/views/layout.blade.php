<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset = "UTF-8">
    <title>My Laravel Study - @yield('title')</title>
    <style>
        .header{
            width:1000px;
            height:150px;
            margin:0 auto;
            background: #f5f5f5;
            border: 1px solid #ddd;
        }

        .main{
            width: 1000px;
            height:300px;
            margin: 0 auto;
            margin-top:15px;
            clear:both;
        }
        .main .sidebar{
            float:left;
            width: 20%;
            height: inherit;
            background: #f5f5f5;
            border: 1px solid #dddddd;
        }
        .main .content{
            float:right;
            width: 75%;
            height: inherit;
            background: #f5f5f5;
            border:1px solid #dddddd;
        }
        .footer{
            width:1000px;
            height:50px;
            margin:0 auto;
            background: #f5f5f5;
            border: 1px solid #ddd;
        }

    </style>


</head>
<body>
<div class= "header">
    @section('header')
    header
    @show
</div>

<div class ="main">
    <div class="sidebar">
        @section('sidebar')
        SideBar
        @show
    </div>
    <div class= "content">
        @yield('content','default Content');
    </div>
</div>
<div class="footer">
    @section('footer')
    Footer
    @show
</div>
</body>
</html>