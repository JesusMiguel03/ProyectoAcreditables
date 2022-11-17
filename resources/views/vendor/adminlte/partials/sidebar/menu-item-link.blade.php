<li @isset($item['id']) id="{{ $item['id'] }}" @endisset class="nav-item">

    @if ($item['url'] === 'logout')
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout').submit()" class="nav-link">
            <i
                class="nav-icon {{ $item['icon'] ?? 'far fa-fw fa-circle' }} {{ isset($item['icon_color']) ? 'text-' . $item['icon_color'] : '' }}"></i>
            <p>
                {{ $item['text'] }}
            </p>
            <form id="logout" method="POST" action="{{ route('logout') }}" style="display: none">
                @csrf
            </form>
        </a>
    @else
        <a class="nav-link {{ $item['class'] }} @isset($item['shift']) {{ $item['shift'] }} @endisset"
            href="{{ $item['href'] }}" @isset($item['target']) target="{{ $item['target'] }}" @endisset
            {!! $item['data-compiled'] ?? '' !!}>

            <i
                class="nav-icon {{ $item['icon'] ?? 'far fa-fw fa-circle' }} {{ isset($item['icon_color']) ? 'text-' . $item['icon_color'] : '' }}"></i>

            <p>
                {{ $item['text'] }}
            </p>
        </a>
    @endif

</li>
