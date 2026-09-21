{{--
    Tabel lega tanpa border berat. Isi <thead>/<tbody> lewat slot.
    Beri `text-right` pada <th>/<td> angka. Di layar kecil, sembunyikan tabel (`hidden md:block`)
    dan tampilkan daftar kartu sebagai gantinya.
--}}
<div {{ $attributes->class('overflow-x-auto') }}>
    <table class="w-full text-callout
        [&_th]:whitespace-nowrap [&_th]:px-5 [&_th]:py-3 [&_th:not(.text-right):not(.text-center)]:text-left [&_th]:text-footnote [&_th]:font-medium [&_th]:text-fg-subtle
        [&_td]:px-5 [&_td]:py-4 [&_td]:align-middle
        [&_tbody_tr]:border-t [&_tbody_tr]:border-line [&_tbody_tr]:transition-colors [&_tbody_tr:hover]:bg-accent-soft/50">
        {{ $slot }}
    </table>
</div>
