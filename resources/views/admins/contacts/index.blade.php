<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
</head>

<body class="text-primary">
    @include('admins.nav')
    <div class="admin-container">
        <div class="container search-container -mt-5">
            <form action="/admin/contacts/search" method="post" class="grouped-btns items-center justify-center">
                @csrf
                @method('post')
                <input type="text" class="input-search" value="{{ $search }}"
                    placeholder="Search by name, email or message..." name="search">
                <input type="submit" name="submit" id="" value="Search"
                    class="secondary-btn hidden lg:block lg:text-lg">
                <button type="submit" name="submit" id="" class="secondary-btn block lg:hidden"><i
                        class="fa fa-search"></i></button>
                <a href="/admin/contacts/" class="primary-btn text-lg hidden lg:block">Reset</a>
            </form>
        </div>
        <h1 class="text-3xl my-4">
            New Messages
        </h1>
        <div class="grid sm:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3">
            @if (!count($contacts)>0)
                <p class="text-xl text-gray-500 p-5 col-span-3">No Message ...</p>
            @endif
            @foreach ($contacts as $contact)
                <div class="col-span-1">
                    <div class="shadow-xl shadow-gray-300 border border-gray-300 m-5">
                        <div class="p-5 ">
                            <h1 class="text-xl bolder">{{ $contact->name }}</h1>
                            <p class="text-redish">email: <a
                                    href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
                            <div class="p-2">
                                <p class="bolder text-redish">Message:</p>
                                <p class="p-3">{{ $contact->message }}</p>
                            </div>
                        </div>
                        <div class="grouped-btns w-full">
                            <a target="_blank" onclick="replied('{{$contact->id}}')" href="mailto:{{$contact->email}}" class="primary-btn w-[50%]"> Reply By Email </a>
                            <a href="/admin/contacts/respond/{{ $contact->id }}" class="secondary-btn w-[50%]"> Mark as Read </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @include('admins.flash')
    <script>
        function replied(message_id){
            let xhr = new XMLHttpRequest();
            xhr.open("get",`/admin/contacts/replied/${message_id}`,false);
            xhr.onload = function (){
                if(this.status == 200){
                    window.location.reload();
                }
            }
            xhr.send();
        }
    </script>
</body>

</html>
