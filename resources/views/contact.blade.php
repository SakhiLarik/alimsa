<!DOCTYPE html>
<html lang="en">

@include('head')

<body>

    <!-- Top Bar -->

    <!-- Navbar -->
    @include('nav')

    {{-- Contact US --}}
    <div class="container p-5">
        <div class="grid sm:grid-cols-1 lg:grid-cols-2">
            <div class="col-span-1">
                <img class="m-0 -mt-16 w-full h-fit" src="{{asset('images/Alimsa studio logo.PNG')}}">
            </div>
            <div class="col-span-1">
                <form action="/contact/submit" method="POST" enctype="multipart/form-data" class="m-5 p-10 border border-gray-300 shadow-xl rounded-lg shadow-gray-300">
                    <h1 class="text-2xl mb-5 bolder"> Contact Us </h1>
                    @csrf
                    @method('post')
                    <div class="form-group">
                        <label for="">Full Name</label>
                        <input type="text" class="input-control" value="{{ old('name') }}" name="name"
                            placeholder="Enter your name">
                            @error('name')
                                <p class="my-2 text-red-600">{{$message}}</p>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" class="input-control" value="{{ old('email') }}" name="email"
                            placeholder="Enter your email">
                            @error('email')
                                <p class="my-2 text-red-600">{{$message}}</p>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Message</label>
                        <textarea rows="5" class="input-control" placeholder="Write your message here..." name="message">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="my-2 text-red-600">{{$message}}</p>
                            @enderror
                    </div>

                    @session('success')
                        <p class="text-green-700 bg-green-200 p-3 px-5 shadow-xl my-3 w-full">{{ session('success') }}
                        </p>
                    @endsession
                    @session('error')
                        <p class="text-red-700 bg-red-200 p-3 px-5 shadow-xl my-3 w-full">{{ session('error') }}</p>
                    @endsession

                    <div class="form-group my-4">
                        <button type="submit" class="primary-btn">Send Message</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    {{-- Newsletter --}}
    @include('newsletter')

    <!-- Footer -->
    @include('footer')
</body>

</html>


{{--
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
 --}}
