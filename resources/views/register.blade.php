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
            <h1 class="text-2xl mb-5 pb-5 border-b-2 border-b-gray-300">Create Account</h1>
            <form action="/register" class="register_form" method="post">
                @csrf
                @method('post')
                <div class="block my-2">
                    <label class="block" for="">Name</label>
                    <input  type="text" class="input-control" name="name" id="name" value="{{ old('name') }}">
                    @error('name')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>
                <div class="block my-2">
                    <label class="block" for="">Email</label>
                    <input  type="email" class="input-control" name="email" id="email" value="{{ old('email') }}">
                    @error('email')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>
                 <div class="block my-2">
                    <label class="block" for="">Phone Number</label>
                    <input  type="phone" class="input-control" name="phone" id="phone" value="{{ old('pone') }}">
                    @error('phone')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>
                <div class="block my-2">
                    <label class="block" for="">Password</label>
                    <input type="password" class="input-control" name="password" id="password">
                    @error('password')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>
                @session('error')
                    <small class="text-red-500">{{ session('error') }}</small>
                @endsession
                <div class="flex justify-between items-center my-2">
                    <p>Already have an account? <a class="my-5 text-sm underline text-redish " href="/login">Login</a></p>
                    <button class="primary-btn" type="submit">Create Account</button>
                </div>
            </form>
        </div>
    </section>
    {{-- Login Form End --}}
    <!-- Footer -->
    @include('footer')
</body>

</html>
