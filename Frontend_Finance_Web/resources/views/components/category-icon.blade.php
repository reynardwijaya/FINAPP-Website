{{--
    Ikon kategori. Kolom categories.icon menyimpan class Font Awesome yang diketik pengguna
    (mis. "fas fa-shopping-cart" atau "fa-money-bill-wave"). Data tidak diubah: class itu
    dipetakan ke ikon SVG; class yang tidak dikenal memakai ikon tag.
--}}
@props(['icon' => null])
@php
    $map = [
        'shopping-cart' => 'shopping-cart', 'cart-shopping' => 'shopping-cart', 'shopping-bag' => 'shopping-bag',
        'money-bill-wave' => 'banknote', 'money-bill' => 'banknote', 'money-bills' => 'banknote', 'coins' => 'banknote',
        'chart-line' => 'trending-up', 'arrow-trend-up' => 'trending-up', 'chart-bar' => 'bar-chart',
        'utensils' => 'utensils', 'coffee' => 'coffee', 'mug-hot' => 'coffee',
        'car' => 'car', 'truck' => 'car', 'home' => 'home', 'house' => 'home',
        'bolt' => 'zap', 'lightbulb' => 'lightbulb', 'heart' => 'heart', 'gift' => 'gift',
        'briefcase' => 'briefcase', 'book' => 'book-open', 'book-open' => 'book-open',
        'credit-card' => 'credit-card', 'wallet' => 'wallet', 'piggy-bank' => 'wallet',
        'mobile' => 'smartphone', 'mobile-alt' => 'smartphone', 'phone' => 'smartphone',
    ];
    $name = 'tag';
    if ($icon && preg_match_all('/fa-([a-z0-9-]+)/i', $icon, $found)) {
        foreach (array_reverse($found[1]) as $token) {
            if (isset($map[strtolower($token)])) { $name = $map[strtolower($token)]; break; }
        }
    }
@endphp
<x-icon :name="$name" {{ $attributes }} />
