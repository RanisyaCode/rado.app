document.addEventListener('DOMContentLoaded', function () {

    // =====================================
    // MOBILE MENU
    // =====================================

    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const mobileMenu = document.getElementById('mobileMenu');

    if (mobileMenuToggle && mobileMenu) {

        mobileMenuToggle.addEventListener('click', function () {

            mobileMenu.classList.toggle('active');

            const icon = mobileMenuToggle.querySelector('i');

            if (mobileMenu.classList.contains('active')) {
                icon.classList.replace('bi-list', 'bi-x-lg');
            } else {
                icon.classList.replace('bi-x-lg', 'bi-list');
            }

        });

        // Tutup menu ketika klik link
        mobileMenu.querySelectorAll('a').forEach(function (link) {

            link.addEventListener('click', function () {
                mobileMenu.classList.remove('active');

                const icon = mobileMenuToggle.querySelector('i');

                icon.classList.replace('bi-x-lg', 'bi-list');
            });

        });

    }


    // =====================================
    // CODE GUIDE MODAL
    // =====================================

    const codeGuideModal = document.getElementById('codeGuideModal');

    const openCodeGuide = document.getElementById('openCodeGuide');
    const mobileCodeGuide = document.getElementById('mobileCodeGuide');

    const closeCodeGuide = document.getElementById('closeCodeGuide');
    const closeCodeGuideBottom = document.getElementById('closeCodeGuideBottom');


    function openModal() {

        if (codeGuideModal) {
            codeGuideModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        if (mobileMenu) {
            mobileMenu.classList.remove('active');
        }

        if (mobileMenuToggle) {
            const icon = mobileMenuToggle.querySelector('i');

            icon.classList.replace('bi-x-lg', 'bi-list');
        }

    }


    function closeModal() {

        if (codeGuideModal) {
            codeGuideModal.classList.remove('active');
            document.body.style.overflow = '';
        }

    }


    if (openCodeGuide) {
        openCodeGuide.addEventListener('click', openModal);
    }

    if (mobileCodeGuide) {
        mobileCodeGuide.addEventListener('click', openModal);
    }

    if (closeCodeGuide) {
        closeCodeGuide.addEventListener('click', closeModal);
    }

    if (closeCodeGuideBottom) {
        closeCodeGuideBottom.addEventListener('click', closeModal);
    }


    // Klik area luar modal untuk menutup
    if (codeGuideModal) {

        codeGuideModal.addEventListener('click', function (event) {

            if (event.target === codeGuideModal) {
                closeModal();
            }

        });

    }


    // Tutup modal dengan tombol ESC
    document.addEventListener('keydown', function (event) {

        if (event.key === 'Escape') {
            closeModal();
        }

    });

});