{{--
    Konfirmasi sebelum aksi berisiko (pengganti confirm() bawaan browser).
    Form yang dikirim sama persis seperti sebelumnya (action + _method + CSRF).
    Slot default = isi tombol pemicu; trigger diberi class lewat atribut `trigger-class`.

    <x-confirm-form :action="route('transactions.destroy', $t)" title="Hapus transaksi ini?"
                    message="Transaksi akan dihapus permanen." trigger-label="Hapus transaksi" icon-only>
        <x-icon name="trash" />
    </x-confirm-form>
--}}
@props(['action', 'method' => 'DELETE', 'title', 'message' => null, 'confirm' => 'Hapus', 'cancel' => 'Batal',
        'triggerLabel' => null, 'triggerClass' => 'inline-flex min-h-11 items-center gap-2 rounded-control px-3 text-callout font-medium text-danger-fg hover:bg-danger-soft'])
@php $name = 'confirm-'.substr(md5($action.$method), 0, 10); @endphp
<span class="inline-block">
    <button type="button" class="{{ $triggerClass }}" @if ($triggerLabel) aria-label="{{ $triggerLabel }}" @endif
            x-data @click="$dispatch('open-modal', '{{ $name }}')">{{ $slot }}</button>
    <x-modal :name="$name" :title="$title" :description="$message">
        <x-slot:footer>
            <x-button variant="secondary" x-data @click="$dispatch('close-modal', '{{ $name }}')">{{ $cancel }}</x-button>
            <form method="POST" action="{{ $action }}" class="contents">
                @csrf
                @method($method)
                <x-button type="submit" variant="danger" class="w-full sm:w-auto">{{ $confirm }}</x-button>
            </form>
        </x-slot:footer>
    </x-modal>
</span>
