<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Exception\InvalidEventRequestException;
use LINE\LINEBot\Exception\InvalidSignatureException;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use App\Models\Order;


class WebhookController extends Controller
{
    public function webhook(Request $request)
    {
        Log::info($request);

        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(env('CHANNEL_ACCESS_TOKEN'));
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => env('CHANNEL_SECRET')]);

        foreach ($request['events'] as $event) {
            if ($event['message']['type'] == 'text' && $event['message']['text'] == 'give me 10 scores') {
                $order = Order::inRandomOrder()->first();
                $response = $bot->replyText($event['replyToken'], $order->name);
            }

            if ($event['message']['type'] == 'sticker') {
                $response = $bot->replyText($event['replyToken'], 'package_Id = '
                    . $event['message']['packageId']
                    . 'and'
                    . 'stickerId = '
                    .$event['message']['stickerId']);
            }
        }
        return response()->json([]);
    }
}
