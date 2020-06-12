<div class="rspn-hdr">
    <div class="lg-mn">
        <div class="logo">
            <a href="{{ route('site') }}" title="{{ config('app.name') }}">
                <img src="{{ asset('assets/images/logo1.png') }}">
            </a>
        </div>
        <div class="rspn-cnt">
            <span>
                <i class="fa fa-envelope thm-clr"></i>
                <a href="mailto:info@equraninstitute.com" title="">
                    <span class="__cf_email__" data-cfemail="3851565e57785a514b555154545950165b5755">qarihabib847@gmail.com</span>
                </a>
            </span>
            <span><i class="fa fa-phone thm-clr"></i>+92-306-0475163</span>
        </div>
        <span class="rspn-mnu-btn"><i class="fa fa-list-ul"></i></span>
    </div>
    <div class="rsnp-mnu">
        <span class="rspn-mnu-cls"><i class="fa fa-times"></i></span>
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
            <li class="menu-item-has-children">
                <a href="#" title="">Islamic Media</a>
                <ul>
                    @foreach($media as $islamic)
                        <li><a href="{{ route('islamicmedia', $islamic->slug) }}" title="{{ $islamic->title }}">{{ $islamic->title }}</a></li>
                    @endforeach
                </ul>
            </li>
{{--            <li><a href="{{ route('charges') }}" title="">Charges</a></li>--}}
            <li><a href="{{ route('contactUs') }}" title="">Contact Us</a></li>
        </ul>
    </div>
</div>