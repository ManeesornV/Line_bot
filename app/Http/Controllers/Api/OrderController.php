<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Exception\InvalidEventRequestException;
use LINE\LINEBot\Exception\InvalidSignatureException;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use App\Http\Controllers\WebHookController;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class OrderController extends Controller
{

    public function index()
    {
        return Order::all();
    }

    public function store(Request $request)
    {
        Order::create($request->all());

        $userId = 'U8baa31a6cf6503322d02c1174f3a5002';

        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(env('CHANNEL_ACCESS_TOKEN'));
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => env('CHANNEL_SECRET')]);

        $multiMessageBuilder = new MultiMessageBuilder();
        $multiMessageBuilder->add(new TextMessageBuilder(json_encode(Order::latest()->first())));
        $response = $bot->pushMessage($userId, $multiMessageBuilder);
    }

    public function show(Order $order)
    {
        return $order;
    }
}
