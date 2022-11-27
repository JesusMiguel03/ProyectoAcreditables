<li @isset($item['id']) id="{{ $item['id'] }}" @endisset class="nav-item">

    <a class="nav-link {{ $item['class'] }} @isset($item['shift']) {{ $item['shift'] }} @endisset"
        href="{{ $item['href'] }}" @isset($item['target']) target="{{ $item['target'] }}" @endisset
        {!! $item['data-compiled'] ?? '' !!}>

        <i
            class="nav-icon {{ $item['icon'] ?? 'far fa-fw fa-circle' }} {{ isset($item['icon_color']) ? 'text-' . $item['icon_color'] : '' }} mr-2"></i>

        <p>
            {{ $item['text'] }}
        </p>
    </a>

</li>
