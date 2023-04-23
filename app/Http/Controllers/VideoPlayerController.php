<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class VideoPlayerController extends Controller
{
  public function index()
  {
    $video = isset(request()->q) ? request()->q : 'https://static.smartisanos.cn/common/video/production/delta/r2.mp4';

    return Inertia::render('VideoPlayer', array(
      'source' => $video
    ));
  }
}
