[1;4B<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Streaming\FFMpeg;

require_once __DIR__.'/src/bootstrap.php';
$config = [
    'ffmpeg.binaries'  => '/usr/bin/ffmpeg',
    'ffprobe.binaries' => '/usr/bin/ffprobe',
    'timeout'          => 36000, // The timeout for the underlying process
    'ffmpeg.threads'   => 16,   // The number of threads that FFmpeg should use
];
$log = new Logger('FFmpeg_Streaming');
$log->pushHandler(new StreamHandler(__DIR__.'/ffmpeg-streaming.log')); // path to log file
$ffmpeg = FFMpeg::create($config, $log);
$formatx264 = new Streaming\Format\X264();
$start_time = 0;
$percentage_to_time_left = function ($percentage) use (&$start_time) {
    if($start_time === 0){
        $start_time = time();
        return "Calculating...";
    }
    $diff_time = time() - $start_time;
    $seconds_left = 100 * $diff_time / $percentage - $diff_time;
    return gmdate("H:i:s", $seconds_left);
};
$formatx264->on('progress', function ($video, $format, $percentage) use($percentage_to_time_left) {
    // You can update a field in your database or can log it to a file
    // You can also create a socket connection and show a progress bar to users
    echo sprintf("\rTranscoding...(%s%%) %s [%s%s]", $percentage, $percentage_to_time_left($percentage), str_repeat('#', $percentage), str_repeat('-', (100 - $percentage)));
});
$formatx265 = new Streaming\Format\X264();
$formatx265->on('progress', function ($video, $format, $percentage){
        echo sprintf("\r Transcoding... (%s%%)[%s%s]", $percentage, str_repeat('#', $percentage), str_repeat('-', (100 - $percentage)));
});
$video = $ffmpeg->open('/storage/movies1/9.2009.1080p.BluRay.x264.YIFY.mp4');
$video
	->hls()
//->dash()
    ->setFormat($formatx264) // extend FFMpeg\Format\ProgressableInterface to get realtime information about the transcoding. 
//    ->generateHlsPlaylist() // Generate HLS Playlist(DASH and HLS) Publish master playlist repeatedly every after specified number of segment intervals. 
//    ->setAdaption('id=0,streams=v id=1,streams=a') // Set the adaption.
//    ->x264() // Format of the video. Alternatives: x265() and vp9()
    ->autoGenerateRepresentations() // Auto generate representations
    ->save(__DIR__.'/9.2009.1080p.BluRay.x264.YIFY.m3u8'); // It can be passed a path to the method or it can be null
