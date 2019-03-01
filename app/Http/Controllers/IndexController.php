<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use Cache;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Redirect;
use DB;
class IndexController extends Controller
{
    public $_domain;
    public $_title;
    public $_description;
    public $_keyword;
    public $_basicInfo;
    public $_websiteInfo;
    public $_semrushMetrics;
    public $_dnsReport;
    public $_ipAddressInfo;
    public $_whoisRecord;
    public $_ads_status;
    public function __construct(){
    }
    public function index(Request $request){
        $page = $request->has('page') ? $request->query('page') : 1;
        $listDomains = Cache::store('memcached')->remember('listDomains_page_'.$page,1, function()
        {
            return DB::table('domains')->where('status','active')->orderBy('updated_at','desc')->simplePaginate(15);
        });
        return view('index',array(
            'listDomains'=>$listDomains
        ));
    }
    public function viewDomain(Request $request){
        $domain = $request->route('domain');
        if(!empty($domain)){
            $getDomain=DB::table('domains')->where('base_64',base64_encode($domain))
                ->where('status','active')
                ->first();
            $listNew = Cache::store('memcached')->remember('listNew',1, function()
            {
                return DB::table('domains')->where('status','active')->orderBy('updated_at','desc')->take(20)->get();
            });
            if(!empty($getDomain->domain)){
                return view('viewDomain',array(
                    'domain'=>$getDomain,
                    'listNew'=>$listNew
                ));
            }
        }
    }
    public function infoSiteOutlook(){
        $getDomain = DB::table('domains')
            ->where('status', 'pending')
            ->where('craw_replay', '<=', 3)
            ->orderBy('created_at', 'asc')->take(3)->get();
        if (count($getDomain)) {
            $client = new Client([
                'headers' => [
                    'Content-Type' => 'text/html',
                    'User-Agent' => 'Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n'
                ],
                ['allow_redirects' => true],
                'connect_timeout' => '2',
                'timeout' => '2'
            ]);
            foreach ($getDomain as $domain) {
                DB::table('domains')->where('id',$domain->id)
                    ->update(['craw_replay'=>$domain->craw_replay+1]);
                $url='http://'.$domain->domain.'.websiteoutlook.com/';
                $response = $client->request('GET', $url);
                $getResponse=$response->getBody()->getContents();
                $dataConvertUtf8 = '<?xml version="1.0" encoding="UTF-8"?>'.$getResponse;
                $doc = new \DOMDocument;
                @$doc->loadHTML($dataConvertUtf8);
                $xpath = new \DOMXpath($doc);
                $nodes = $doc->getElementsByTagName('title');
                if($nodes->length >0){
                    $this->_title = $nodes->item(0)->nodeValue;
                }
                $metas = $doc->getElementsByTagName('meta');
                for ($i = 0; $i < $metas->length; $i++)
                {
                    $meta = $metas->item($i);
                    if($meta->getAttribute('name') == 'description')
                        $this->_description = $meta->getAttribute('content');
                    if($meta->getAttribute('name') == 'keywords')
                        $this->_keyword = $meta->getAttribute('content');
                }
                foreach ($xpath->evaluate('//div[@id="basic"]/div[2][contains(concat (" ", normalize-space(@class), " "), " panel-body ")]/div[2]/table[contains(concat (" ", normalize-space(@class), " "), " table table-condensed ")] | //html/body/div[2]/div[2]/div[1]/div[2]/div/div[2]/div[2]/table') as $node) {
                    $this->_basicInfo=$doc->saveHtml($node);
                    $this->_basicInfo = preg_replace('/<form.*>[^>]*.*[^>]*>/i','',$this->_basicInfo);
                }
                foreach ($xpath->evaluate('//div[@id="website"]/div[2][contains(concat (" ", normalize-space(@class), " "), " panel-body ")]/dl[contains(concat (" ", normalize-space(@class), " "), " dl-horizontal ")] | //html/body/div[2]/div[2]/div[1]/div[3]/div/div[2]/dl') as $node) {
                    $this->_websiteInfo=$doc->saveHtml($node);
                }
                foreach ($xpath->evaluate('//div[@id="sem"]/div[2][contains(concat (" ", normalize-space(@class), " "), " panel-body ")] | //html/body/div[2]/div[2]/div[1]/div[4]/div/div[2]') as $node) {
                    $this->_semrushMetrics=$doc->saveHtml($node);
                }
                foreach ($xpath->evaluate('//div[@id="dns"]/div[2][contains(concat (" ", normalize-space(@class), " "), " panel-body ")] | //html/body/div[2]/div[2]/div[1]/div[5]/div/div[2]') as $node) {
                    $this->_dnsReport=$doc->saveHtml($node);
                }
                foreach ($xpath->evaluate('//div[@id="geo"]/div[2][contains(concat (" ", normalize-space(@class), " "), " panel-body ")] | //html/body/div[2]/div[2]/div[1]/div[6]/div/div[2]') as $node) {
                    $this->_ipAddressInfo=$doc->saveHtml($node);
                }
                foreach ($xpath->evaluate('//div[@id="whois"]/div[2][contains(concat (" ", normalize-space(@class), " "), " panel-body ")] | //html/body/div[2]/div[2]/div[1]/div[7]/div/div[2]') as $node) {
                    $this->_whoisRecord=$doc->saveHtml($node);
                }
                $pos = strpos($dataConvertUtf8, 'adsbygoogle');
                if ($pos === false) {
                    $this->_ads_status='disable';
                }else{
                    $this->_ads_status='active';
                }
                $reportOutlook=array(
                    'basicInfo'=>$this->_basicInfo,
                    'websiteInfo'=>$this->_websiteInfo,
                    'semrushMetrics'=>$this->_semrushMetrics,
                    'dnsReport'=>$this->_dnsReport,
                    'ipAddressInfo'=>$this->_ipAddressInfo,
                    'whoisRecord'=>$this->_whoisRecord
                );
                $data=array(
                    'title'=>$this->_title,
                    'description'=>$this->_description,
                    'review_number'=>1,
                    'ads'=>$this->_ads_status,
                    'status'=>'active',
                    'report_outlook'=>json_encode($reportOutlook)
                );
                DB::table('domains')->where('id',$domain->id)
                    ->update($data);
                echo 'Craw '.$domain->domain.' success <p>';
            }
        } else {
            $this->getDomainFromUrl();
        }
    }
    public function getDomainFromUrl(){
        try {
            $client = new Client([
                'headers' => [
                    'Content-Type' => 'text/html',
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36'
                ],
                'connect_timeout' => '5',
                'timeout' => '5'
            ]);
            $getSiteUrl=DB::table('site_url')->where('site','websiteoutlook')->where('type','add')->first();
            if(empty($getSiteUrl->site)){
                DB::table('site_url')->insert(
                    [
                        'site' => 'websiteoutlook',
                        'url_list' => 'http://www.websiteoutlook.com/list/',
                        'page'=>1,
                        'type'=>'add',
                        'created_at'=>Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')
                    ]
                );
                $siteUrl='http://www.websiteoutlook.com/list/';
                $pageUrl=1;
            }else{
                $siteUrl=$getSiteUrl->url_list;
                $pageUrl=$getSiteUrl->page;
            }
            DB::table('site_url')->where('site','websiteoutlook')
                ->update(['page' => $pageUrl+1,'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')]);
            $response = $client->request('GET', $siteUrl.$pageUrl);
            $getResponse=$response->getBody()->getContents();
            $dom = new \DOMDocument;
            @$dom->loadHTML($getResponse);
            $xpath = new \DOMXPath($dom);
            $results = $xpath->query("//ol");

            if ($results->length > 0) {
                $review = $results->item(0);
                $link=$review->getElementsByTagName('a');
                foreach ($link as $item){
                    $domain=$item->getAttribute('href');
                    $domain=str_replace("http://","",$domain);
                    $domain=str_replace(".websiteoutlook.com","",$domain);
                    $checkExits=DB::table('domains')->where('base_64',base64_encode($domain))->first();
                    if(empty($checkExits->domain)){
                        DB::table('domains')->insert(
                            [
                                'domain' => $domain,
                                'base_64' => base64_encode($domain),
                                'created_at'=>Carbon::now()->format('Y-m-d H:i:s'),
                                'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')
                            ]
                        );
                        echo $domain.'<p>';
                    }
                }
            }
        }catch (\GuzzleHttp\Exception\ServerException $e){
            return 'false';
        }catch (\GuzzleHttp\Exception\BadResponseException $e){
            return 'false';
        }catch (\GuzzleHttp\Exception\ClientException $e){
            return 'false';
        }catch (\GuzzleHttp\Exception\ConnectException $e){
            return 'false';
        }catch (\GuzzleHttp\Exception\RequestException $e){
            return 'false';
        }
    }
}