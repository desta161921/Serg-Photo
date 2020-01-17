<!DOCTYPE html>
<html>
<head>
    @include('includes.head');
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
@include('includes.header')
<div class="container__album">
    <div class="wrapper__album">
        <div class="album__list">
            <h2 class="error-h">Error</h2>
        </div>
        
        @if (session('error'))
            <center><h1 class="error-p">{{session('error')}}</h1></center>
        @endif 
        
    </div>
</div>

</body>
</html>