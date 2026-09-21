/**
 * Helper Chart.js terpusat.
 *
 * Halaman tidak mengatur warna/font sendiri. Cukup:
 *
 *   Finapp.charts.create(canvas, (t) => ({ type: 'line', data: {...}, options: {...} }));
 *
 * `t` berisi token tema aktif (dibaca dari CSS variable). Saat tema berganti,
 * event `finapp:theme` membangun ulang semua grafik yang terdaftar.
 */
import {
    ArcElement,
    BarController,
    BarElement,
    CategoryScale,
    Chart,
    DoughnutController,
    Filler,
    Legend,
    LineController,
    LineElement,
    LinearScale,
    PointElement,
    RadarController,
    RadialLinearScale,
    Tooltip,
} from 'chart.js';

Chart.register(
    ArcElement,
    BarController,
    BarElement,
    CategoryScale,
    DoughnutController,
    Filler,
    Legend,
    LineController,
    LineElement,
    LinearScale,
    PointElement,
    RadarController,
    RadialLinearScale,
    Tooltip,
);

const rupiahFormat = new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 });
const compactFormat = new Intl.NumberFormat('id-ID', { notation: 'compact', maximumFractionDigits: 1 });

/** 1250000 -> "Rp 1.250.000" */
export const rupiah = (value) => `Rp ${rupiahFormat.format(Number(value) || 0)}`;
/** 1250000 -> "Rp 1,3 jt" (untuk sumbu grafik) */
export const rupiahCompact = (value) => `Rp ${compactFormat.format(Number(value) || 0)}`;

/** Baca token tema aktif dari CSS variable. */
export function tokens() {
    const css = getComputedStyle(document.documentElement);
    const get = (name) => css.getPropertyValue(name).trim();
    return {
        series: [1, 2, 3, 4, 5, 6].map((i) => get(`--chart-${i}`)),
        primary: get('--chart-1'),
        income: get('--chart-2'),
        expense: get('--chart-3'),
        net: get('--chart-1'),
        grid: get('--chart-grid'),
        tick: get('--chart-tick'),
        text: get('--color-fg'),
        surface: get('--color-surface'),
        tooltipBg: get('--chart-tooltip-bg'),
        tooltipFg: get('--chart-tooltip-fg'),
        tooltipLine: get('--chart-tooltip-line'),
        font: get('--font-sans'),
    };
}

/** Tambahkan transparansi ke warna hex: withAlpha('#7546e0', 0.15) */
export function withAlpha(hex, alpha) {
    const value = hex.replace('#', '');
    const full = value.length === 3 ? [...value].map((c) => c + c).join('') : value;
    const n = parseInt(full, 16);
    return `rgb(${(n >> 16) & 255} ${(n >> 8) & 255} ${n & 255} / ${alpha})`;
}

function isPlainObject(value) {
    return value && typeof value === 'object' && !Array.isArray(value);
}

function merge(base, extra) {
    const out = { ...base };
    for (const [key, value] of Object.entries(extra ?? {})) {
        out[key] = isPlainObject(value) && isPlainObject(base[key]) ? merge(base[key], value) : value;
    }
    return out;
}

/** Opsi dasar (font, legend, tooltip) dari token. Skala diatur lewat `axes(t)`. */
function baseOptions(t) {
    return {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { intersect: false, mode: 'index' },
        font: { family: t.font },
        plugins: {
            legend: {
                labels: {
                    color: t.tick,
                    usePointStyle: true,
                    pointStyle: 'circle',
                    boxWidth: 8,
                    boxHeight: 8,
                    padding: 16,
                    font: { family: t.font, size: 12 },
                },
            },
            tooltip: {
                backgroundColor: t.tooltipBg,
                titleColor: t.tooltipFg,
                bodyColor: t.tooltipFg,
                borderColor: t.tooltipLine,
                borderWidth: 1,
                padding: 12,
                cornerRadius: 12,
                boxPadding: 4,
                usePointStyle: true,
                titleFont: { family: t.font, weight: '600' },
                bodyFont: { family: t.font },
                callbacks: {
                    label: (ctx) => {
                        const label = ctx.dataset.label ? `${ctx.dataset.label}: ` : `${ctx.label}: `;
                        return `${label}${rupiah(ctx.parsed.y ?? ctx.parsed.r ?? ctx.parsed)}`;
                    },
                },
            },
        },
    };
}

/** Sumbu x/y minimalis: tanpa garis vertikal dan tanpa border. */
export function axes(t, { currency = true } = {}) {
    return {
        x: {
            grid: { display: false },
            border: { display: false },
            ticks: { color: t.tick, font: { family: t.font, size: 12 }, padding: 8 },
        },
        y: {
            beginAtZero: true,
            grid: { color: t.grid, drawTicks: false },
            border: { display: false },
            ticks: {
                color: t.tick,
                font: { family: t.font, size: 12 },
                padding: 12,
                maxTicksLimit: 5,
                callback: currency ? (value) => rupiahCompact(value) : undefined,
            },
        },
    };
}

const registry = new Set();

function build(entry, { animate = true } = {}) {
    const t = tokens();
    const config = entry.build(t);
    config.options = merge(baseOptions(t), config.options);
    // Tanpa animasi saat ganti tema agar tidak berkedip.
    if (!animate) config.options.animation = false;
    entry.chart?.destroy();
    entry.chart = new Chart(entry.canvas, config);
}

/**
 * Buat grafik yang otomatis mengikuti tema.
 * @param {HTMLCanvasElement|string} canvas elemen atau id
 * @param {(t: ReturnType<typeof tokens>) => import('chart.js').ChartConfiguration} builder
 */
export function create(canvas, builder) {
    const el = typeof canvas === 'string' ? document.getElementById(canvas) : canvas;
    if (!el) return null;
    const entry = { canvas: el, build: builder, chart: null };
    // Panggil entry.rebuild() bila data yang dipakai builder berubah (mis. filter).
    entry.rebuild = (animate = true) => build(entry, { animate });
    registry.add(entry);
    build(entry);
    return entry;
}

document.addEventListener('finapp:theme', () => {
    for (const entry of registry) {
        if (!entry.canvas.isConnected) {
            entry.chart?.destroy();
            registry.delete(entry);
            continue;
        }
        build(entry, { animate: false });
    }
});

export { Chart };
