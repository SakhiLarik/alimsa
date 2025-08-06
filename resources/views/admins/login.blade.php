<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
</head>

<body class="text-primary ">
    <div class="my-16 container">
        <section class=" bg-center  flex justify-center items-center">
            <div class="login responsive-form ">
                <center>
                    <img src="{{ asset('images/Alimsa studio logo - Copy.PNG') }}" alt="ALIMSA Studio" width="150px">
                </center>
                <h1 class="text-2xl mb-5 pb-5 border-b-2 border-b-gray-300">Login</h1>
                <form action="/admin/login" class="login_form" method="post">
                    @csrf
                    @method('post')
                    <div class="block my-2">
                        <label class="block" for="">Email</label>
                        <input focus="" value="adminpanel@alimsa.com" type="email" class="input-control"
                            name="email" id="email" value="{{ old('email') }}">
                        @error('email')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="block my-2">
                        <label class="block" for="">Password</label>
                        <input value="Studio@123" type="password" class="input-control password-field" name="password"
                            id="password">
                        @error('password')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>
                    @session('error')
                        <small class="text-red-500"> {{ session('error') }}</small>
                    @endsession
                    <div class="flex justify-between items-center my-2 ">
                        <div>
                            <input type="checkbox" id="password-check-box"
                                onchange="(this.checked)?document.querySelector('.password-field').setAttribute('type','text'):document.querySelector('.password-field').setAttribute('type','password')">
                            <label style="user-select: none;" for="password-check-box">Show Password</label>
                        </div>
                        <button class="primary-btn" type="submit">Login</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</body>

</html>
