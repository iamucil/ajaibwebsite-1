@if ($breadcrumbs)
    @foreach ($breadcrumbs as $breadcrumb)
        @if (!$breadcrumb->last)
            <li>
                <a href="{{ $breadcrumb->url }}">
                    @if (strtolower($breadcrumb->title) == 'dashboard')
                        <i class="fontello-home"></i>
                    @else
                        {{ $breadcrumb->title }}
                    @endif
                </a>
            </li>
        @else
            <li class="active">
                @if (strtolower($breadcrumb->title) == 'dashboard')
                    <i class="fontello-home"></i>
                @else
                    {{ $breadcrumb->title }}
                @endif
            </li>
        @endif
    @endforeach
@endif