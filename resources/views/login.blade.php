<!DOCTYPE html>
<html lang="en">

@include('head')

<body>

    <!-- Top Bar -->

    <!-- Navbar -->
    @include('nav')


    {{-- Login Form Start --}}
    <section class=" bg-center my-16 flex justify-center items-center">
        <div class="login responsive-form ">

            <h1 class="text-2xl mb-5 pb-5 border-b-2 border-b-gray-300">Login</h1>
            <form action="/login" class="login_form" method="post">
                @csrf
                @method('post')
                <div class="block my-2">
                    <label class="block" for="">Email</label>
                    <input focus="" type="email" class="input-control" name="email" id="email"
                        value="{{ old('email') }}">
                    @error('email')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>
                <div class="block my-2">
                    <label class="block" for="">Password</label>
                    <input type="password" class="input-control password-field" name="password" id="password">
                    @error('password')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>
                <div class="block my-2">
                    <input type="checkbox" id="password-check-box"
                        onchange="(this.checked)?document.querySelector('.password-field').setAttribute('type','text'):document.querySelector('.password-field').setAttribute('type','password')">
                    <label style="user-select: none;" for="password-check-box">Show Password</label>
                </div>
                @session('error')
                    <small class="text-red-500"> {{ session('error') }}</small>
                @endsession
                <div class="flex justify-between items-center my-2">
                    <p>Don't have an account? <a class="my-5 text-sm underline text-redish " href="/register">Create Account</a></p>
                    <button class="primary-btn" type="submit">Login</button>
                </div>
            </form>
        </div>
    </section>
    {{-- Login Form End --}}
    <!-- Footer -->
    @include('footer')

</body>

</html>
