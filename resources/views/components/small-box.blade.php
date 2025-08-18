@props(['label','jumlah'=>0,'route','icon','color'])
<div class="col-lg-3 col-6">
    <div class="small-box bg-{{ $color }}">
        <div class="inner">
            <h3>{{ $jumlah }}</h3>

            <p>{{ $label }}</p>
        </div>
        <div class="icon">
            <i class="ion {{ $icon }}"></i>
        </div>
        <a href="{{ route($route) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
