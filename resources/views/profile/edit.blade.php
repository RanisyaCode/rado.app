<x-app-layout>
    @section('header_title')
        Pengaturan Akun & Profil
    @endsection

    <div class="max-w-4xl space-y-6">
        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-100 shadow-xs">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-100 shadow-xs">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="bg-rose-50/50 rounded-3xl p-6 sm:p-7 border border-rose-200/80">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
