/**
 * Modul tema tunggal untuk semua layout (app, guest, welcome).
 *
 * - Mode: 'light' | 'dark' | 'system'.
 * - Penyimpanan: localStorage.theme = 'light' | 'dark'. Tanpa key = ikut sistem.
 * - Penerapan: class `dark` di <html> (+ color-scheme lewat CSS).
 * - Script inline di <head> (partials/theme-init) menerapkan tema lebih awal
 *   supaya tidak ada flash; modul ini mengambil alih setelah halaman dimuat.
 * - Setiap perubahan memancarkan satu event: `finapp:theme` di `document`
 *   dengan detail { mode, resolved }.
 */
const KEY = 'theme';
const root = document.documentElement;
const media = window.matchMedia('(prefers-color-scheme: dark)');

function read() {
    try {
        const value = localStorage.getItem(KEY);
        return value === 'light' || value === 'dark' ? value : 'system';
    } catch {
        return 'system';
    }
}

function resolve(mode) {
    return mode === 'system' ? (media.matches ? 'dark' : 'light') : mode;
}

function apply(mode) {
    const resolved = resolve(mode);
    root.classList.toggle('dark', resolved === 'dark');
    document.querySelector('meta[name="theme-color"]')?.setAttribute('content', resolved === 'dark' ? '#0e0c16' : '#fafafc');
    return resolved;
}

function emit(mode, resolved) {
    document.dispatchEvent(new CustomEvent('finapp:theme', { detail: { mode, resolved } }));
}

let mode = read();
apply(mode);

export const theme = {
    get mode() {
        return mode;
    },
    get resolved() {
        return resolve(mode);
    },
    set(next) {
        if (!['light', 'dark', 'system'].includes(next)) return;
        mode = next;
        try {
            if (next === 'system') localStorage.removeItem(KEY);
            else localStorage.setItem(KEY, next);
        } catch {
            /* penyimpanan diblokir: tema tetap berlaku untuk sesi ini */
        }
        emit(mode, apply(mode));
    },
};

// Mode "Sistem": ikuti perubahan preferensi OS secara langsung.
media.addEventListener('change', () => {
    if (mode === 'system') emit(mode, apply(mode));
});

// Sinkron antar tab.
window.addEventListener('storage', (event) => {
    if (event.key !== KEY) return;
    mode = read();
    emit(mode, apply(mode));
});
