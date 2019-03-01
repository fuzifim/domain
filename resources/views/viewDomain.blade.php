@extends('layout')
@section('title', $domain->domain.' - '.$domain->title)
@section('description', $domain->description)
@section('header')
    @include('header')
@endsection
@section('content')
    <?php
        $jsonDecode='';
        $basicInfo='';
        $websiteInfo='';
        $semrushMetrics='';
        $dnsReport='';
        $ipAddressInfo='';
        $whoisRecord='';
    ?>
    @if($domain->review_number==1)
        <?php
            $jsonDecode=json_decode($domain->report_outlook);
            $basicInfo=$jsonDecode->basicInfo;
            $websiteInfo=$jsonDecode->websiteInfo;
            $semrushMetrics=$jsonDecode->semrushMetrics;
            $dnsReport=$jsonDecode->dnsReport;
            $ipAddressInfo=$jsonDecode->ipAddressInfo;
            $whoisRecord=$jsonDecode->whoisRecord;
        ?>
    @endif
    @if($domain->ads=='active')
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({
                google_ad_client: "ca-pub-6739685874678212",
                enable_page_level_ads: true
            });
        </script>
    @endif
    <div class="container">
        <div class="row mt-2">
            <div class="col-md-8">
                <h1>{!! $domain->domain !!}</h1>
                <small>Updated at: {!! $domain->updated_at !!}</small>
                <div class="form-group mt-2">
                    <div class="alert alert-info p-2">
                        <strong>Cung Cấp đến mọi người ⭐ ⭐ ⭐ ⭐ ⭐</strong>
                        <p>Đăng tin lên Cung Cấp để cung cấp sản phẩm, dịch vụ kinh doanh đến mọi người hoàn toàn miễn phí! </p>
                    </div>
                    <div class="btn-group d-flex" role="group"><a class="btn btn-success w-100" href="https://cungcap.net" target="_blank"><h4>Đăng tin miễn phí</h4></a></div>
                </div>
                <div class="form-group mt-2">
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-6739685874678212"
                         data-ad-slot="7536384219"
                         data-ad-format="auto"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
                <div class="card mt-2">
                    <div class="card-header">
                        Basic Infomation
                    </div>
                    <div class="card-body">
                        {!! $basicInfo !!}
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-header">
                        Website Infomation
                    </div>
                    <div class="card-body">
                        {!! $websiteInfo !!}
                    </div>
                </div>
                <div class="form-group mt-2">
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-6739685874678212"
                         data-ad-slot="7536384219"
                         data-ad-format="auto"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
                <div class="card mt-2">
                    <div class="card-header">
                        SemRush Metrics
                    </div>
                    <div class="card-body">
                        {!! $semrushMetrics !!}
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-header">
                        DNS Report
                    </div>
                    <div class="card-body">
                        {!! $dnsReport !!}
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-header">
                        IP Address Infomation
                    </div>
                    <div class="card-body">
                        {!! $ipAddressInfo !!}
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-header">
                        Whois Record
                    </div>
                    <div class="card-body">
                        {!! $whoisRecord !!}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <h4>List new domains</h4>
                <div class="form-group mt-2">
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-6739685874678212"
                         data-ad-slot="7536384219"
                         data-ad-format="auto"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
                @if(count($listNew)>0)
                    <ul class="list-group">
                        @foreach($listNew as $domainNew)
                            <li class="list-group-item">
                                <h3><a href="{!! route('view.domain',$domainNew->domain) !!}">@if(!empty($domainNew->domain_rename)){!! $domainNew->domain_rename !!}@else{!! $domainNew->domain !!}@endif</a></h3>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('css')
@endsection
@section('script')
@endsection