<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
</head>

<body>
    @include('users.nav')
    <div class="container">
        <div class="grid mt-5 grid-cols-2">
            <div class="col-span-1 m-5">
                <div class="my-5">
                    <h1 class="text-xl bolder">Account Settings</h1>
                </div>
                <form action="/user/update/account" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('post')
                    <div class="form-group m-2">
                        <label for="">Name: <span class="text-redish">*</span></label>
                        <input type="text" required class="input-control" name="name" value="{{ $user->name }}"
                            placeholder="Enter full name...">
                        @error('name')
                            <span class="text-redish">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group m-2">
                        <label for="">Email: <span class="text-redish">*</span></label>
                        <input type="email" name="email" required class="input-control" value="{{ $user->email }}"
                            placeholder="Enter your email...">
                        @error('email')
                            <span class="text-redish">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group m-2">
                        <label for="">Phone Number: <span class="text-redish">*</span></label>
                        <input type="text" name="phone" required class="input-control" value="{{ $user->phone }}"
                            placeholder="03xxxxxxxxx">
                        @error('phone')
                            <span class="text-redish">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group m-2">
                        <label for="">Old Password: <span class="text-redish">*</span></label>
                        <input type="password" name="old_password" required class="input-control" placeholder="Enter old password to update">
                        @error('old_pass')
                            <span class="text-redish">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group m-2">
                        <label for="">Set New Password:</label>
                        <input type="password" name="new_password" class="input-control" placeholder="Set new password">
                        @error('new_pass')
                            <span class="text-redish">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="m-2">
                        @session('error')
                            <span class="text-redish">{{session('error')}}</span>
                        @endsession
                    </div>
                    <div class="form-group my-5">
                        <button type="submit" class="btn primary-btn">Submit</button>
                    </div>
                </form>
            </div>
            <div class="col-span-1 m-5">
                <div class="my-5">
                    <h1 class="text-xl bolder">Order Settings</h1>
                </div>
                <form action="/user/update/settings" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('post')
                     <div class="form-group m-2">
                        <label for="">Address Line 1 (Permanant): <span class="text-redish">*</span></label>
                        <textarea required class="input-control" name="address_1" rows="3" placeholder="Enter residental address...">{{ count($userSettings)>0?$userSettings[0]->address_1:'' }}</textarea>
                        @error('address_1')
                            <span class="text-redish">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group m-2">
                        <label for="">Address Line 2 (Residency): <span class="text-redish">*</span></label>
                        <textarea required class="input-control" name="address_2" rows="3" placeholder="Enter permanant address...">{{ count($userSettings)>0?$userSettings[0]->address_2:'' }}</textarea>
                        @error('address_2')
                            <span class="text-redish">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group m-2">
                        <label for="">Account Bank: <span class="text-redish">*</span></label>
                        <input type="text" required class="input-control" name="bank" value="{{ count($userSettings)>0?$userSettings[0]->payment_method_bank:'' }}"
                            placeholder="Example: JazzCash, Allied Bank, Habib Bank etc...">
                        @error('name')
                            <span class="text-redish">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                     <div class="form-group m-2">
                        <label for="">Account Number: <span class="text-redish">*</span></label>
                        <input type="text" required class="input-control" name="bank_number" value="{{ count($userSettings)>0?$userSettings[0]->payment_method_number:'' }}"
                            placeholder="Enter Account Number or IBAN etc...">
                        @error('bank_number')
                            <span class="text-redish">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group m-2">
                        <label for="">Account Title: <span class="text-redish">*</span></label>
                        <input type="text" required class="input-control" name="bank_title" value="{{ count($userSettings)>0?$userSettings[0]->payment_method_title:'' }}"
                            placeholder="Your account title on given bank...">
                        @error('bank_title')
                            <span class="text-redish">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="m-2">
                        @session('error')
                            <span class="text-redish">{{session('error')}}</span>
                        @endsession
                    </div>
                    <div class="form-group my-5">
                        <button type="submit" class="btn primary-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('footer')
</body>

</html>
