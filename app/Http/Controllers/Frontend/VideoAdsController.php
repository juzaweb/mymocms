<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Video\VideoAds;

class VideoAdsController extends Controller
{
    public function ads() {
        $video_ads = VideoAds::where('status', '=', 1)
            ->inRandomOrder()
            ->first();
    
        if (empty($video_ads)) {
            $factory = new \Sokil\Vast\Factory();
            $document = $factory->create('2.0');
            $document->toDomDocument();
            return $document;
        }
        
        return $this->_getAds($video_ads);
    }
    
    private function _getAds(VideoAds $video_ads) {
        $factory = new \Sokil\Vast\Factory();
        $document = $factory->create('2.0');
    
        $ad1 = $document
            ->createInLineAdSection()
            ->setId('ad1')
            ->setAdSystem($video_ads->name)
            ->setAdTitle($video_ads->title)
            ->addImpression('http://ad.server.com/impression', 'imp1');
    
        $linearCreative = $ad1
            ->createLinearCreative()
            ->setDuration(1)
            ->setId('013d876d-14fc-49a2-aefd-744fce68365b')
            ->setAdId('pre')
            ->setVideoClicksClickThrough('http://entertainmentserver.com/landing')
            ->addVideoClicksClickTracking('http://ad.server.com/videoclicks/clicktracking')
            ->addVideoClicksCustomClick('http://ad.server.com/videoclicks/customclick')
            ->addTrackingEvent('start', 'http://ad.server.com/trackingevent/start')
            ->addTrackingEvent('pause', 'http://ad.server.com/trackingevent/stop');
    
        $linearCreative
            ->createClosedCaptionFile()
            ->setLanguage('en-US')
            ->setType('text/srt')
            ->setUrl('http://server.com/cc.srt');
    
        $linearCreative
            ->createMediaFile()
            ->setProgressiveDelivery()
            ->setType('video/mp4')
            ->setHeight(100)
            ->setWidth(100)
            ->setBitrate(2500)
            ->setUrl(image_url($video_ads->getVideoUrl()));
    
        $document->toDomDocument();
        return $document;
    }
}
