@forelse ($paras as $para)
    <div class="col-md-3 col-sm-6 col-lg-3">
        <div class="srv-box2">
            <i class="flaticon-quran-rehal"></i>
            <div class="srv-info2">
                <h4> {{ $para->para_name }}</h4>
                <a href="{{ route('tajweedQuran.para', $para->para_no) }}" title="">Read More<i class="flaticon-right-arrow"></i></a>
            </div>
        </div>
    </div>
@empty
    <p class="text-center col-12">No Paras available yet.</p>
@endforelse