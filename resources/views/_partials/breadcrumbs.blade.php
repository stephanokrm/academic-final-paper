@if($breadcrumbs)
<nav class="light-blue lighten-2">
    <div class="container-fluid">
        <div class="nav-wrapper">
            <div class="row">
                <div class="col s12 m12 l12">
                    @foreach ($breadcrumbs as $breadcrumb)
                    @if(!$breadcrumb->last)
                    <a href="{{ $breadcrumb->url }}" class="breadcrumb">{{ $breadcrumb->title }}</a>
                    @else
                    <a class="active breadcrumb" href="#">{{ $breadcrumb->title }}</a>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</nav>
@endif