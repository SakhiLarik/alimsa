@session('success')
    <div
        class="absolute success-message px-5 py-3 w-[75%] md:w-[25%] bg-teal-400 border border-teal-200 top-10 left-[25%] md:left-[75%] z-10 text-white flex items-center justify-around">
        <i class="fa fa-check text-2xl"></i>
        <p class=" "> {{ session('success') }}</p>
    </div>
@endsession
@session('error')
    <div
        class="absolute success-message px-5 py-3 w-[75%] md:w-[25%] bg-redish border border-red-200 top-10 left-[25%] md:left-[75%] z-10 text-white flex items-center justify-around">
        <i class="fa fa-times text-2xl"></i>
        <p class=" "> {{ session('error') }}</p>
    </div>
@endsession
@php
    unset($_SESSION['success']);
@endphp


<div class="modal delete-item-modal hidden">
    <div class="modal-container p-5">
        <div class="modal-content p-5 h-52">
            <h1
                class="text-3xl font-bold flex justify-between items-center pb-4 border-b-2 border-b-slate-300 text-slate-800">
                <span>Cofirm to Delete</span>
                <span class="cursor-pointer" onclick="deleteItem('')"><i
                        class="fa fa-times text-3xl text-redish"></i></span>
            </h1>
            <p class="text-2xl p-3 my-2 bolder">Attention ⚠️</p>
            <p class="p-3 font-bold">Do you really want to delete this item. Once you deleted any item you can not
                restore them back.</p>
        </div>
        <div class="grouped-btns my-5 justify-center items-center">
            <a class="secondary-btn deleteItemLink"> <i class="fa fa-trash"></i> Yes, Delete it</a>
            <button onclick="deleteItem('')" class="primary-btn"> <i class="fa fa-thumbs-up"></i> No, Keep
                it</button>
        </div>
    </div>
</div>



<div class="modal add-sub_category-modal hidden">
    <div class="modal-container p-5">
        <form action="/admin/categories/add_sub" method="POST" enctype="multipart/form-data">
            @csrf
            @method('post')
            <div class="modal-content p-5 h-52">
                <h1
                    class="text-3xl font-bold flex justify-between items-center pb-4 border-b-2 border-b-slate-300 text-slate-800">
                    <span>Add Sub-Category</span>
                    <span class="cursor-pointer" onclick="addCategory('')"><i
                            class="fa fa-times text-3xl text-redish"></i></span>
                </h1>
                <input type="hidden" name="category_id" id="" value="" class="addCategoryItemLink">
                <div class="input-group mt-5">
                    <label for="name">Enter Name </label>
                <input type="text" name="name" placeholder="Evening Luxe, Sheesha Sitara, Rang-o-Resham etc." id="name" value="" class="input-control">
                </div>
            </div>
            <div class="grouped-btns my-2 justify-center items-center">
                <button type="reset" onclick="addCategory('')" class="secondary-btn"> Cancel</button>
                <button type="submit" class="primary-btn"> Submit </button>
            </div>
        </form>
    </div>
</div>

<script>
    let successMessages = document.querySelectorAll(".success-message");
    successMessages.forEach(message => {
        setTimeout(() => {
            message.classList.add("left-[150%]");
            message.classList.add("hidden");
            message.classList.remove("flex");
        }, 5000);
    });

    function deleteItem(url) {
        // alert(url);
        let modal = document.querySelector('.delete-item-modal');
        if (modal.classList.contains("hidden")) {
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        } else {
            modal.classList.add("hidden");
            modal.classList.remove("flex");
        }
        document.querySelector('.deleteItemLink').setAttribute('href', url);
    }


    function addCategory(category) {
        // alert(url);
        let modal = document.querySelector('.add-sub_category-modal');
        if (modal.classList.contains("hidden")) {
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        } else {
            modal.classList.add("hidden");
            modal.classList.remove("flex");
        }
        document.querySelector(".addCategoryItemLink").value = category;
    }
</script>
