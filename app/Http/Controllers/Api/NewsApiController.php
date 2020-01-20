<?php

namespace App\Http\Controllers\Api;

use App\Models\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class NewsApiController extends ApiBaseController
{
    public $successStatus = 200;

    public function index($limit = 100, $offset = 0)
    {
        $news = News::select('uuid', 'head', 'body', 'picture', 'created_at')->limit($limit)->offset($offset)->orderBy('created_at', 'desc')->get()->toArray();

        return $this->sendResponse($news, 'News returned');
    }

}
