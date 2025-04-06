import './bootstrap';
import { initLandingPageBuilder } from './landingPreview';

document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('contract_file');
    const fileNameDisplay = document.getElementById('file-name');
    fileInput.addEventListener('change', function () {
        const file = fileInput.files[0];
        if (file) {
            fileNameDisplay.textContent = file.name;
            fileNameDisplay.classList.remove('hidden');
        } else {
            fileNameDisplay.classList.add('hidden');
            fileNameDisplay.textContent = '';
        }
    });
});

setTimeout(() => {
    const toast = document.getElementById('toast-success');
    if (toast) {
        toast.classList.add('opacity-0');
        setTimeout(() => toast.remove(), 500);
    }
}, 3000);



document.addEventListener('DOMContentLoaded', () => {
    const previewRoute = document.querySelector('[data-preview-route]')?.dataset.previewRoute;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    if (previewRoute && csrfToken) {
        initLandingPageBuilder(previewRoute, csrfToken);
    }
});
// toast removal
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[id^="toast-"]').forEach((toast) => {
        setTimeout(() => {
            toast.classList.add('opacity-0', 'transition-opacity', 'duration-500');
            setTimeout(() => {
                toast.remove();
            }, 500);
        }, 3000);
    });
});

// Delete modal toggle
document.querySelectorAll('[data-modal-toggle]').forEach(btn => {
    const targetId = btn.getAttribute('data-modal-toggle');
    const modal = document.getElementById(targetId);

    btn.addEventListener('click', () => {
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    });

    modal?.querySelectorAll('[data-modal-hide]').forEach(closeBtn => {
        closeBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });
    });
});

// mobile menu
document.getElementById('nav-toggle')?.addEventListener('click', () => {
    const mobileNav = document.getElementById('mobile-nav');
    mobileNav.classList.toggle('hidden');
});

document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('user-menu-button');
    const dropdown = document.getElementById('user-dropdown');

    if (btn && dropdown) {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', (e) => {
            if (!dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    }
});
// Settings page
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('settings-form');
    const previewText = document.getElementById('preview-text');
    const previewColor = document.getElementById('preview-color');

    form.addEventListener('change', () => {
        const selectedColor = form.querySelector('input[name="primary_color"]:checked')?.value;
        const selectedFont = form.querySelector('input[name="font_family"]:checked')?.value;

        if (selectedColor) {
            previewColor.style.backgroundColor = selectedColor;
        }
        if (selectedFont) {
            previewText.style.fontFamily = `'${selectedFont}', sans-serif`;
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const logoInput = document.getElementById('logo');
    const logoPreview = document.getElementById('logo-preview');
    const logoPlaceholder = document.getElementById('logo-placeholder');
    const logoFilenameWrapper = document.getElementById('logo-filename');
    const logoFilenameText = logoFilenameWrapper.querySelector('span');

    logoInput.addEventListener('change', function (e) {
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                logoPreview.src = e.target.result;
                logoPreview.classList.remove('hidden');
                logoPlaceholder.classList.add('hidden');
                logoFilenameText.textContent = file.name;
                logoFilenameWrapper.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            logoPreview.classList.add('hidden');
            logoPlaceholder.classList.remove('hidden');
            logoFilenameWrapper.classList.add('hidden');
            logoFilenameText.textContent = '';
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const scrollContainer = document.querySelector('.calendar-scroll-container');
    if (scrollContainer) {
        scrollContainer.scrollTop = 7 * 80;
    }
});