
<section class="space-y-6">

    {{-- HEADER --}}
    <header>
        <h2 class="text-lg font-bold text-slate-900">
            Informasi Profil
        </h2>
        <p class="mt-1 text-sm text-slate-500">
            Kelola foto profil dan informasi akun Anda.
        </p>
    </header>

    {{-- FORM VERIFIKASI EMAIL --}}
    <form id="send-verification" method="post"
        action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- FORM UTAMA --}}
    <form method="post"
        action="{{ route('profile.update') }}"
        enctype="multipart/form-data"
        class="space-y-6">

        @csrf
        @method('patch')

        {{-- FOTO PROFIL --}}
        <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-5 sm:p-6">

            <div class="flex flex-col gap-5 sm:flex-row sm:items-center">


                {{-- PREVIEW FOTO --}}
                <div class="flex shrink-0 justify-center sm:justify-start">
                    <div class="relative"
                        style="width: 112px; height: 112px; min-width: 112px;">

                        <div class="overflow-hidden rounded-full border-4 border-white bg-slate-200 shadow-md"
                            style="width: 112px; height: 112px;">

                            <img
                                id="profilePhotoPreview"
                                src="{{ $user->profile_photo
                                    ? asset('storage/' . $user->profile_photo)
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=4F7DF3&color=fff&size=200' }}"
                                alt="Foto Profil"
                                style="
                                    display: block;
                                    width: 100%;
                                    height: 100%;
                                    max-width: none;
                                    object-fit: cover;
                                    object-position: center;
                                ">
                        </div>

                        <div class="absolute bottom-0 right-0 flex h-8 w-8 items-center justify-center rounded-full border-2 border-white bg-[#4F7DF3] text-white shadow">
                            <i class="bi bi-camera-fill text-sm"></i>
                        </div>

                    </div>
                </div>

                {{-- INFORMASI UPLOAD --}}
                <div class="min-w-0 flex-1 text-center sm:text-left">

                    <h3 class="text-sm font-bold text-slate-800">
                        Foto Profil
                    </h3>

                    <p class="mt-1 text-xs leading-5 text-slate-500">
                        Gunakan foto yang jelas agar profil akun Anda lebih mudah dikenali.
                    </p>

                    <div class="mt-3 flex flex-wrap items-center justify-center gap-2 sm:justify-start">

                        <label for="profile_photo"
                            class="inline-flex cursor-pointer items-center gap-2 rounded-xl bg-[#4F7DF3] px-4 py-2.5 text-xs font-semibold text-white shadow-sm transition hover:bg-[#3E6DE8]">
                            <i class="bi bi-upload"></i>
                            Pilih Foto
                        </label>

                        <button type="button"
                            id="resetPhoto"
                            class="hidden items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-semibold text-slate-600 transition hover:bg-slate-100">
                            <i class="bi bi-arrow-counterclockwise"></i>
                            Batalkan Pilihan
                        </button>

                    </div>

                    <p class="mt-2 text-[11px] text-slate-400">
                        JPG, JPEG, PNG atau WEBP. Maksimal 2 MB.
                    </p>

                    <input
                        type="file"
                        id="profile_photo"
                        name="profile_photo"
                        accept="image/jpeg,image/png,image/webp"
                        class="hidden">

                    <x-input-error class="mt-2 text-left"
                        :messages="$errors->get('profile_photo')" />

                </div>
            </div>
        </div>

        {{-- NAMA LENGKAP --}}
        <div>
            <label for="name"
                class="mb-2 block text-xs font-semibold uppercase tracking-wider text-slate-700">
                Nama Lengkap
            </label>

            <input
                id="name"
                name="name"
                type="text"
                value="{{ old('name', $user->name) }}"
                required
                autofocus
                autocomplete="name"
                placeholder="Masukkan nama lengkap"
                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-[#4F7DF3] focus:ring-4 focus:ring-[#4F7DF3]/10">

            <x-input-error class="mt-2"
                :messages="$errors->get('name')" />
        </div>

        {{-- EMAIL --}}
        <div>
            <label for="email"
                class="mb-2 block text-xs font-semibold uppercase tracking-wider text-slate-700">
                Alamat Email
            </label>

            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email', $user->email) }}"
                required
                autocomplete="username"
                placeholder="Masukkan alamat email"
                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-[#4F7DF3] focus:ring-4 focus:ring-[#4F7DF3]/10">

            <x-input-error class="mt-2"
                :messages="$errors->get('email')" />
        </div>

        {{-- BUTTON SIMPAN --}}
        <div class="flex flex-wrap items-center gap-3 border-t border-slate-100 pt-5">

            <button type="submit"
                class="inline-flex items-center gap-2 rounded-xl bg-[#4F7DF3] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-[#3E6DE8] hover:shadow-md">
                <i class="bi bi-check2-circle"></i>
                Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated')
                <p class="text-xs font-semibold text-emerald-600"
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)">
                    <i class="bi bi-check-circle-fill mr-1"></i>
                    Profil berhasil diperbarui.
                </p>
            @endif

        </div>

    </form>
</section>


{{-- MODAL CROP FOTO --}}
<div id="cropModal"
    class="fixed inset-0 z-[9999] hidden items-center justify-center bg-slate-950/70 p-4">

    <div class="w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl">

        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
            <div>
                <h3 class="font-bold text-slate-900">
                    Sesuaikan Foto Profil
                </h3>
                <p class="mt-1 text-xs text-slate-500">
                    Geser dan atur posisi foto sesuai keinginan.
                </p>
            </div>

            <button type="button" id="closeCropModal"
                class="flex h-9 w-9 items-center justify-center rounded-full text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="bg-slate-100 p-4">
            <div class="mx-auto max-h-[350px] max-w-full overflow-hidden">
                <img id="cropImage"
                    src=""
                    alt="Foto yang akan dipotong"
                    class="block max-w-full">
            </div>
        </div>

        <div class="flex flex-wrap justify-end gap-2 p-5">
            <button type="button" id="cancelCrop"
                class="rounded-xl border border-slate-200 px-4 py-2.5 text-xs font-semibold text-slate-600 transition hover:bg-slate-50">
                Batal
            </button>

            <button type="button" id="applyCrop"
                class="rounded-xl bg-[#4F7DF3] px-5 py-2.5 text-xs font-semibold text-white transition hover:bg-[#3E6DE8]">
                <i class="bi bi-check2 mr-1"></i>
                Gunakan Foto
            </button>
        </div>

    </div>
</div>


{{-- CROPPER CSS --}}
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">

<style>
    #cropModal .cropper-container {
        max-width: 100%;
    }

    #cropModal .cropper-view-box,
    #cropModal .cropper-face {
        border-radius: 50%;
    }

    #cropModal .cropper-line,
    #cropModal .cropper-point {
        background-color: #4F7DF3;
    }


    /* Mencegah foto profil membesar */
    #profilePhotoPreview {
        width: 100% !important;
        height: 100% !important;
        max-width: none !important;
        display: block;
        object-fit: cover;
        object-position: center;
    }

    /* Membatasi ukuran area crop */
    #cropModal .cropper-container {
        max-width: 100%;
    }
</style>

{{-- CROPPER JS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const photoInput = document.getElementById('profile_photo');
    const preview = document.getElementById('profilePhotoPreview');
    const cropModal = document.getElementById('cropModal');
    const cropImage = document.getElementById('cropImage');

    const resetButton = document.getElementById('resetPhoto');
    const closeButton = document.getElementById('closeCropModal');
    const cancelButton = document.getElementById('cancelCrop');
    const applyButton = document.getElementById('applyCrop');

    const originalPreview = preview.src;

    let cropper = null;
    let imageUrl = null;

    function closeModal() {
        cropModal.classList.add('hidden');
        cropModal.classList.remove('flex');

        if (cropper) {
            cropper.destroy();
            cropper = null;
        }

        if (imageUrl) {
            URL.revokeObjectURL(imageUrl);
            imageUrl = null;
        }
    }

    function cancelSelection() {
        photoInput.value = '';
        preview.src = originalPreview;
        resetButton.classList.add('hidden');
        resetButton.classList.remove('inline-flex');
        closeModal();
    }

    photoInput.addEventListener('change', function (event) {

        const file = event.target.files[0];

        if (!file) return;

        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        if (!allowedTypes.includes(file.type)) {
            alert('Format foto harus JPG, PNG, atau WEBP.');
            cancelSelection();
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran foto maksimal 2 MB.');
            cancelSelection();
            return;
        }

        imageUrl = URL.createObjectURL(file);
        cropImage.src = imageUrl;

        cropModal.classList.remove('hidden');
        cropModal.classList.add('flex');

        cropImage.onload = function () {

            if (cropper) {
                cropper.destroy();
            }

            cropper = new Cropper(cropImage, {
                aspectRatio: 1,
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 0.9,
                responsive: true,
                background: false,
                guides: false,
                center: true,
                highlight: false,
                movable: true,
                zoomable: true,
                rotatable: false,
                scalable: false
            });
        };
    });

    applyButton.addEventListener('click', function () {

        if (!cropper) return;

        const canvas = cropper.getCroppedCanvas({
            width: 600,
            height: 600,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high'
        });

        canvas.toBlob(function (blob) {

            if (!blob) {
                alert('Gagal memproses foto. Silakan coba lagi.');
                return;
            }

            const croppedFile = new File(
                [blob],
                'profile-photo.jpg',
                {
                    type: 'image/jpeg',
                    lastModified: Date.now()
                }
            );

            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(croppedFile);

            photoInput.files = dataTransfer.files;

            preview.src = URL.createObjectURL(croppedFile);

            resetButton.classList.remove('hidden');
            resetButton.classList.add('inline-flex');

            closeModal();

        }, 'image/jpeg', 0.88);
    });

    closeButton.addEventListener('click', cancelSelection);
    cancelButton.addEventListener('click', cancelSelection);
    resetButton.addEventListener('click', cancelSelection);

});
</script>
