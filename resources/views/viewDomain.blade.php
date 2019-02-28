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
    <div class="container">
        <div class="row mt-2">
            <div class="col-md-8">
                <h1>{!! $domain->domain !!}</h1>
                <div class="form-group mt-2">
                    <div class="alert alert-info p-2">
                        <strong>Cung Cấp đến mọi người ⭐ ⭐ ⭐ ⭐ ⭐</strong>
                        <p>Đăng tin lên Cung Cấp để cung cấp sản phẩm, dịch vụ kinh doanh đến mọi người hoàn toàn miễn phí! </p>
                    </div>
                    <div class="btn-group d-flex" role="group"><a class="btn btn-success w-100" href="https://cungcap.net" target="_blank"><h4>Đăng tin miễn phí</h4></a></div>
                </div>
                <div class="form-group mt-2">
                    {!! $basicInfo !!}
                </div>
                <div class="form-group mt-2">
                    {!! $websiteInfo !!}
                </div>
                <div class="form-group mt-2">
                    {!! $semrushMetrics !!}
                </div>
                <div class="form-group mt-2">
                    {!! $dnsReport !!}
                </div>
                <div class="form-group mt-2">
                    {!! $ipAddressInfo !!}
                </div>
                <div class="form-group mt-2">
                    {!! $whoisRecord !!}
                </div>
            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>
@endsection
@section('css')
@endsection
@section('script')
@endsection