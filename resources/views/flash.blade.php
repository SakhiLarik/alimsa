@session('success')
    <div
        class="absolute success-message px-5 py-3 w-[75%] md:w-[30%] bg-primary border border-slate-700 top-10 left-[25%] md:left-[70%] z-10 text-white flex items-center justify-around">
        <i class="fa fa-check text-2xl"></i>
        <p class=" "> {{ session('success') }}</p>
    </div>
@endsession
@session('error')
    <div
        class="absolute success-message px-5 py-3 w-[75%] md:w-[30%] bg-redish border border-red-300 top-10 left-[25%] md:left-[70%] z-10 text-white flex items-center justify-around">
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
        let modal = document.querySelector('.modal.delete-item-modal');
        if (modal.classList.contains("hidden")) {
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        } else {
            modal.classList.add("hidden");
            modal.classList.remove("flex");
        }
        document.querySelector('.deleteItemLink').setAttribute('href', url);
    }
</script>
