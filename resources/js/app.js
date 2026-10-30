const identityStorageKey = 'senja-suara-registration-identity';

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form[action*="/registrations"]');
    const savedIdentity = document.querySelector('#saved-identity');
    const useSavedIdentityButton = document.querySelector('#use-saved-identity');
    const clearSavedIdentityButton = document.querySelector('#clear-saved-identity');
    const rememberIdentity = document.querySelector('#remember-identity');

    if (!form || !savedIdentity || !useSavedIdentityButton || !clearSavedIdentityButton || !rememberIdentity) {
        return;
    }

    const getSavedIdentity = () => {
        try {
            const saved = window.localStorage.getItem(identityStorageKey);

            return saved ? JSON.parse(saved) : null;
        } catch {
            return null;
        }
    };

    const saved = getSavedIdentity();

    if (saved?.name && saved?.email && saved?.phone) {
        savedIdentity.hidden = false;
    }

    useSavedIdentityButton.addEventListener('click', () => {
        const identity = getSavedIdentity();

        if (!identity) {
            savedIdentity.hidden = true;
            return;
        }

        form.elements.name.value = identity.name;
        form.elements.email.value = identity.email;
        form.elements.phone.value = identity.phone;
        rememberIdentity.checked = true;
    });

    clearSavedIdentityButton.addEventListener('click', () => {
        window.localStorage.removeItem(identityStorageKey);
        savedIdentity.hidden = true;
        rememberIdentity.checked = false;
    });

    form.addEventListener('submit', () => {
        if (!rememberIdentity.checked) {
            return;
        }

        window.localStorage.setItem(identityStorageKey, JSON.stringify({
            name: form.elements.name.value,
            email: form.elements.email.value,
            phone: form.elements.phone.value,
        }));
    });
});
