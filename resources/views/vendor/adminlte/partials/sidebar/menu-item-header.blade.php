@if ($item['header'] !== 'PRINCIPAL')
    <li>
        <hr class="dropdown-divider">
    </li>
@endif

<li @isset($item['id']) id="{{ $item['id'] }}" @endisset class="nav-header {{ $item['class'] ?? '' }}">

    {{ is_string($item) ? $item : $item['header'] }}

</li>
