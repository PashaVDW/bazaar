import Sortable from 'sortablejs';

export function initLandingPageBuilder(previewRoute, csrfToken) {
    const toggles = document.querySelectorAll('.component-toggle');
    const previewIframe = document.getElementById('preview-iframe');
    const sortableContainer = document.getElementById('sortable-components');
    const orderInput = document.getElementById('ordered-components');

    if (!sortableContainer || !previewIframe) return;

    new Sortable(sortableContainer, {
        animation: 150,
        onSort: updatePreview
    });

    function updatePreview() {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = previewRoute;
        form.target = 'preview-iframe';
        form.style.display = 'none';

        const csrf = document.createElement('input');
        csrf.name = '_token';
        csrf.value = csrfToken;
        form.appendChild(csrf);

        const selected = [];

        document.querySelectorAll('#sortable-components .component-item').forEach((item, index) => {
            const checkbox = item.querySelector('input[type="checkbox"]');
            const componentId = item.dataset.id;

            if (checkbox?.checked) {
                selected.push(componentId);

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'components[]';
                input.value = componentId;
                form.appendChild(input);

                const inputs = item.querySelectorAll('textarea, input[type="text"], input[type="color"]');
                inputs.forEach(el => {
                    const match = el.name.match(/components\[(\d+)]\[settings]\[(.+)]/);
                    if (match) {
                        const [, , key] = match;
                        const hidden = document.createElement('input');
                        hidden.type = 'hidden';
                        hidden.name = `component_settings[${componentId}][${key}]`;
                        hidden.value = el.value;
                        form.appendChild(hidden);
                    }
                });
            }
        });

        if (orderInput) {
            orderInput.value = selected.join(',');
        }

        const logoFile = document.getElementById('logo')?.files?.[0];
        if (logoFile) {
            const reader = new FileReader();
            reader.onload = function (event) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'component_settings[global][logo_base64]';
                input.value = event.target.result;
                form.appendChild(input);

                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);
            };
            reader.readAsDataURL(logoFile);
            return;
        }

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }

    toggles.forEach(t => t.addEventListener('change', updatePreview));
    document.querySelectorAll('[name^="components"]').forEach(input => {
        input.addEventListener('input', updatePreview);
    });

    document.querySelectorAll('.component-toggle').forEach(toggle => {
        toggle.addEventListener('change', () => {
            const componentId = toggle.dataset.componentId;
            const inputSection = document.getElementById('inputs-' + componentId);
            if (toggle.checked) {
                inputSection?.classList.remove('hidden');
            } else {
                inputSection?.classList.add('hidden');
            }

            updatePreview();
        });
    });

    updatePreview();
}
