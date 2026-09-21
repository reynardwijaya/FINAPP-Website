import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';

import { theme } from './theme';
import * as charts from './charts';

Alpine.plugin(focus);

// Store tema untuk komponen (toggle di navbar, Settings, layout guest).
Alpine.store('theme', {
    mode: theme.mode,
    resolved: theme.resolved,
    set(mode) {
        theme.set(mode);
    },
});
document.addEventListener('finapp:theme', (event) => {
    Alpine.store('theme').mode = event.detail.mode;
    Alpine.store('theme').resolved = event.detail.resolved;
});

/** Tampilkan toast dari JS: Finapp.toast('Tersimpan', 'success') */
const toast = (message, type = 'success') =>
    window.dispatchEvent(new CustomEvent('toast', { detail: { message, type } }));

window.Finapp = { theme, charts, toast };
window.Alpine = Alpine;

Alpine.start();
