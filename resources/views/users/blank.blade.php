<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
</head>

<body>
    @include('users.nav')
    <div class="my-32 container">
        <h1 class="text-4xl">Welcom {{ $user['name'] }}</h1>
    </div>
    @include('footer')
</body>

</html>
