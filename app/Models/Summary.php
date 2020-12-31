<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Note;
use Mecab\Tagger;

class Summary extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'title', 'image', 'description'];

    protected $hidden = ['created_at', 'updated_at', 'id'];


    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    

        if(isset($attributes['url'])){
            $this->{'url'} = $attributes['url'];
        }
    }
     

    public function notes()
    {
        return $this->hasMany(Summary::class, 'summary_id');
    }

    public function getWord(): array
    {
        $words = [];
        $tagger = new Tagger();
        foreach($tagger->parseToNode() as $node){
            $surface = $node->getSurface();
            if(!isset($surface) || empty($surface)){
                continue;
            }
            if(isset($words[$surface]) && !empty($words[$surface])){
                $words[$surface] ++;
                continue;
            }

            $future = explode(',', $node->getSurface());
            if(isset($future[0]) && $future[0] === '名詞'){
                $words[$surface] = 1;
            }
        }
        
        return $words;
    }

    public function loadSummary(){
        if(isset($this->url)){
            $this->getSummary($this->url);
        }
    }

    public function getSummary($url){

        $normalizedUrl = $url;

        $content = null;
        if(mb_ereg_match('/\Ahttps://twitter.com\/.*/', $normalizedUrl)){
            $content = $this->getTwitterContent($normalizedUrl);
        }else{
            $content = $this->getNormalContent($normalizedUrl);
        }
        if(isset($content)){
            $attrs = $this->getSummaryAttrs($url,$content);
            foreach($attrs as $key => $value){
                $this->{$key} = $value;
                
            }
        }
    }

    private function getTwitterContent($url)
    {
        return file_get_contents($url, false, stream_context_create(array(
            'http'=>array(
                'method'=>'GET',
                'header'=>'User-Agent: bot',
                'ignore_errors'=>true
            ))));
    }

    private function getNormalContent($url)
    {
        return file_get_contents($url);

    }

    private function getSummaryAttrs($url, $body)
    {
        $content = mb_convert_encoding($body, 'UTF-8');
        $dom = new \DOMDocument();
        @$dom->loadHTML($content);

        $xml = simplexml_import_dom($dom);

        $ogTitle = $xml->xpath('//meta[@property="og:title"]/@content');
        $ogDescription = $xml->xpath('//meta[@property="og:description"]/@content');
        $ogImage = $xml->xpath('//meta[@property="og:image"]/@content');

        $attrs = [
            'url' => $url,
            'title' => null,
            'description' => null,
            'image' => null
        ];

        if(!empty($ogTitle)){
            $attrs['title'] = $ogTitle[0];
        }

        if(!isset($attrs['title'])){
            $attrs['title'] = $dom->getElementsByTagName('title')->item(0)->textContent;
        }

        if(!empty($ogDescription)){
            $attrs['description'] = (string)$ogDescription[0];
        }

        if(!empty($ogImage) && !empty($ogImage[0]['content']) && !empty($ogImage[0]['content'][0])){
            $attrs['image'] = (string)$ogImage[0]['content'];
        }

        return $attrs;
    }
}
