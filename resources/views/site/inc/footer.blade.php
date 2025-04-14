@php
    // Retrieve the first Information record
    $information = \App\Information::query()->first();
    
@endphp
<footer>
    <div class="gap top-spac70 drk-bg2 remove-bottom">
        <div class="container">
            <div class="footer-data">
                <div class="row">
                    <div class="col-md-4 col-sm-12 col-lg-4">
                        <div class="wdgt-box">
                            <div class="logo"><a href="{{ route('site') }}" title="Logo"><img src="{{ asset('assets/images/logo1.png') }}" alt="logo1.png"></a></div>
                            <p>Online Quran learning started while considering the problem of the parents in finding qualified Quran teachers near to their home.
                                The online way of learning holy Quran has a lot of advantages as compared to the conventional Quran classes.</p>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12 col-lg-8">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-lg-4">
                                <div class="wdgt-box">
                                    <h4>Mobile Apps</h4>
                                    <ul>        
                                        @if(!empty($information->dynamic_footer_items))
                                        @foreach($information->dynamic_footer_items as $item)
                                            <li>
                                                <a href="{{ $item['link'] }}" target="_blank">{{ $item['title'] }}</a>
                                            </li>
                                        @endforeach
                                    @else
                                        <li>No footer links available.</li>
                                    @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-lg-4">
                                <div class="wdgt-box">
                                    <h4>Useful Links</h4>
                                    <ul>
                                        <li><a href="{{ route('site') }}" title="">Home</a></li>
                                        <li><a href="{{ route('quranPage') }}" title="">Quran</a></li>
                                        <li><a href="{{ route('charges') }}" title="">Charges & Payment Methods</a></li>
                                        <li><a href="{{ route('contactUs') }}" title="">Contact Us</a></li>
                                        <li><a href="{{ route('faq') }}" title="">FAQ</a></li>
                                        <li><a href="{{ route('terms') }}" title="">Terms Of Service</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-lg-4">
                                @php($info = \App\Information::query()->first())
                                <div class="wdgt-box">
                                    <h4>Information</h4>
                                    <ul class="cont-lst">
                                        @if(@$info['skype1']['label'] && @$info['skype1']['value'])
                                        <li><i class="fa fa-skype" style="padding: 5px 0px;"></i><a href="skype:live:{{$info['skype1']['value']}}?call">{{ $info['skype1']['label']  }}</a></li>
                                        @endif
                                        @if(@$info['skype2']['label'] && @$info['skype2']['value'])
                                        <li><i class="fa fa-skype" style="padding: 5px 0px;"></i><a href="skype:live:{{$info['skype2']['value']}}?call">{{ $info['skype2']['label']  }}</a></li>
                                        @endif
                                        @if(@$info['phone1']['label'] && @$info['phone1']['value'])
                                        <li><i class="flaticon-call"></i><a href="tel:{{$info['phone1']['value']}}">{{ $info['phone1']['label']  }}</a></li>
                                        @endif
                                        @if(@$info['phone2']['label'] && @$info['phone2']['value'])
                                        <li><i class="flaticon-call"></i><a href="tel:{{$info['phone2']['value']}}">{{ $info['phone2']['label']  }}</a></li>
                                        @endif
                                        @if(@$info['whatsapp1']['label'] && @$info['whatsapp1']['value'])
                                        <li><i class="fa fa-whatsapp" style="padding: 5px 0px;"></i><a href="https://wa.me/{{$info['whatsapp1']['value']}}"><span class="__cf_email__" data-cfemail="ea83868b878389aa8e9f878793c4898587">{{ $info['whatsapp1']['label']  }}</span></a></li>
                                        @endif
                                        @if(@$info['whatsapp2']['label'] && @$info['whatsapp2']['value'])
                                        <li><i class="fa fa-whatsapp" style="padding: 5px 0px;"></i><a href="https://wa.me/{{$info['whatsapp2']['value']}}"><span class="__cf_email__" data-cfemail="ea83868b878389aa8e9f878793c4898587">{{ $info['whatsapp2']['label']  }}</span></a></li>
                                        @endif
                                        @if(@$info['email']['label'] && @$info['email']['value'])
                                        <li><i class="flaticon-email"></i><a href="mailto:{{$info['email']['value']}}"><span class="__cf_email__" data-cfemail="ea83868b878389aa8e9f878793c4898587">{{ $info['email']['label']  }}</span></a></li>
                                        @endif
                                        @if(@$info['youtube']['label'] && @$info['youtube']['value'])
                                        <li><i class="fa fa-youtube-play" style="padding: 5px 0px;color:red;"></i><a href="{{$info['youtube']['value']}}"><span class="__cf_email__" >{{ $info['youtube']['label']  }}</span></a></li>
                                        @endif
{{--                                        <li><i class="fa fa-whatsapp" style="padding: 5px 0px;"></i><a href="https://wa.me/923484736397" title=""><span class="__cf_email__" data-cfemail="ea83868b878389aa8e9f878793c4898587">+92-348-4736397</span></a></li>--}}
{{--                                        <li><i class="flaticon-email"></i><a href="mailto:qarihabib847@gmail.com" title=""><span class="__cf_email__" data-cfemail="ea83868b878389aa8e9f878793c4898587">qarihabib847@gmail.com</span></a></li>--}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom-bar">
                <p>&copy; Copyright {{ date('Y') }}. All Rights Reserved. - Made with <span style="color:red">❤</span> by <a href="https://ioitechnologies.com/" target="_blank">IOI Technologies</a></p>
            </div>
        </div>
    </div>
</footer>
