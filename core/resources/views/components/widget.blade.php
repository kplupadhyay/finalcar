@props([
    'style' => 1,
    'link' => null,
    'title' => null,
    'value' => null,
    'icon' => null,
    'bg' => null,
    'color' => null,
    'icon_color' => null,
    'icon_style' => 'outline',
    'overlay_icon' => 1,
    'query_string' => null,
    'parameters' => null,
])

@php
    $iconColor = $icon_color ?? $color;
    $widget = 'x-widget-' . $style;

    if ($link) {
        if (!Route::is('superowner.*') && !Route::is('admin.*')) {
            if (can($link)) {
                $link = route($link, $parameters);
            } else {
                $link = null;
            }
        } else {
            $link = route($link, $parameters);
        }
        $link = $link ? ($query_string ? $link . '?' . $query_string : $link) : null;
    }
@endphp

@if ($style == 1)
    <x-widget-1 :bg=$bg :color=$color :icon=$icon :icon_color=$icon_color :link=$link :title=$title :value=$value />
@endif

@if ($style == 2)
    <x-widget-2 :bg=$bg :color=$color :icon=$icon :icon_color=$icon_color :icon_style=$icon_style :link=$link :overlay_icon=$overlay_icon :title=$title :value=$value />
@endif

@if ($style == 3)
    <x-widget-3 :bg=$bg :color=$color :icon=$icon :link=$link :title=$title :value=$value />
@endif

@if ($style == 4)
    <x-widget-4 :bg=$bg :color=$color :link=$link :title=$title :value=$value />
@endif

@if ($style == 5)
    <x-widget-5 :bg=$bg :icon=$icon :link=$link :title=$title :value=$value />
@endif
