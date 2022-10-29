<li @isset($item['id']) id="{{ $item['id'] }}" @endisset class="nav-item">

    @if ($item['url'] === 'logout')
        <a class="nav-link" href=""
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i
                class="nav-icon {{ $item['icon'] ?? 'far fa-fw fa-circle' }} {{ isset($item['icon_color']) ? 'text-' . $item['icon_color'] : '' }}"></i>
            <p>
                {{ $item['text'] }}
            </p>
        </a>

        <form id="logout-form" action="logout" method="POST" style="display: none;">
            @if (config('adminlte.logout_method'))
                {{ method_field(config('adminlte.logout_method')) }}
            @endif
            {{ csrf_field() }}
        </form>
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
