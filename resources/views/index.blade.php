@extends('layout')
@section('title', 'Danh sách tên miền')
@section('header')
    @include('header')
@endsection
@section('content')
    <div class="container">
        <div class="row mt-2">
            <div class="col-md-8">
                <div class="form-group mt-2">
                    <div class="alert alert-info p-2">
                        <strong>Cung Cấp đến mọi người ⭐ ⭐ ⭐ ⭐ ⭐</strong>
                        <p>Đăng tin lên Cung Cấp để cung cấp sản phẩm, dịch vụ kinh doanh đến mọi người hoàn toàn miễn phí! </p>
                    </div>
                    <div class="btn-group d-flex" role="group"><a class="btn btn-success w-100" href="https://cungcap.net" target="_blank"><h4>Đăng tin miễn phí</h4></a></div>
                </div>
                @if(count($listDomains)>0)
                    <ul class="list-group">
                        <?php $i=0; ?>
                        @foreach($listDomains as $domain)
                            <?php $i++;?>
                            @if($i==3 || $i==9)

                            @endif
                            <li class="list-group-item">
                                <h3><a href="{!! route('view.domain',$domain->domain) !!}">@if(!empty($domain->domain_rename)){!! $domain->domain_rename !!}@else{!! $domain->domain !!}@endif</a></h3>
                            </li>
                        @endforeach
                    </ul>
                    <div class="form-group mt-2">
                        {{ $listDomains->links() }}
                    </div>
                @endif
            </div>
            <div class="col-md-4">
                {{--@if(count($getNewKeywordNew))--}}
                    {{--<div class="form-group mt-2">--}}
                        {{--<h4>Từ khóa mới cập nhật </h4>--}}
                        {{--<ul class="list-group">--}}
                            {{--@foreach($getNewKeywordNew as $keyword)--}}
                                {{--<li class="list-group-item"><a href="{!! route('view.keyword',array($keyword->id,$keyword->slug)) !!}">{!! $keyword->keyword !!}</a></li>--}}
                            {{--@endforeach--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--@endif--}}
                <div class="form-group mt-2">
                    <div class="form-group">
                        <ins class="adsbygoogle"
                             style="display:block"
                             data-ad-client="ca-pub-6739685874678212"
                             data-ad-slot="7536384219"
                             data-ad-format="auto"></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('css')
@endsection
@section('script')
@endsection