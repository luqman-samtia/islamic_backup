<header class="style1">
    <div class="container">
        <div class="logo">
            <a href="{{ route('site') }}" title="{{ config('app.name') }}"><img src="{{ asset('assets/images/logo1.png') }}" alt=""></a>
        </div>
        <nav>
            <div>
                <a class="thm-btn brd-rd40" href="{{ route('contactUs') }}" title="">Contact Us</a>
                <ul>
                    <li><a href="{{ route('site') }}" title="">Home</a></li>
                    <li class="menu-item-has-children">
                        <a href="#" title="">Islamic Resources</a>
                        <ul>
                            @foreach($resources as $resource)
                            <li><a href="{{ route('page', $resource->slug) }}" title="{{ $resource->title }}">{{ $resource->title }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="menu-item-has-children">
                        <a href="#" title="">Articles</a>
                        <ul>
                            @foreach($articles as $resource)
                                <li><a href="{{ route('artical', $resource->slug) }}" title="{{ $resource->title }}">{{ $resource->title }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li><a href="{{ route('quranPage') }}" title="">Read Quran</a></li>
                    <li><a href="{{ route('tajweedQuran') }}" title="">Tajweed Quran</a></li>
                    <li class="menu-item-has-children">
                        <a href="#" title="">Islamic Media</a>
                        <ul>
                            @foreach($media as $islamic)
                                <li><a href="{{ route('islamicmedia', $islamic->slug) }}" title="{{ $islamic->title }}">{{ $islamic->title }}</a></li>
                            @endforeach
                        </ul>
                    </li>
{{--                    <li><a href="{{ route('charges') }}" title="">Charges</a></li>--}}

                </ul>
            </div>
        </nav>
    </div>
</header>

