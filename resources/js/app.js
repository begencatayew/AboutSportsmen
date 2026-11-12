document.querySelectorAll('[data-password-toggle]').forEach((toggle) => {
    toggle.addEventListener('click', () => {
        const input = document.getElementById(toggle.getAttribute('aria-controls'));

        if (!(input instanceof HTMLInputElement)) {
            return;
        }

        const isVisible = input.type === 'text';

        input.type = isVisible ? 'password' : 'text';
        toggle.textContent = isVisible ? 'Show' : 'Hide';
        toggle.setAttribute('aria-label', isVisible ? 'Show password' : 'Hide password');
        toggle.setAttribute('aria-pressed', String(!isVisible));
    });
});

document.querySelectorAll('[data-auth-form]').forEach((form) => {
    form.addEventListener('submit', () => {
        const submitButton = form.querySelector('button[type="submit"]');

        if (!(submitButton instanceof HTMLButtonElement)) {
            return;
        }

        submitButton.disabled = true;
        submitButton.setAttribute('aria-busy', 'true');
        submitButton.textContent = submitButton.dataset.loadingText ?? 'Submitting...';
    });
});
