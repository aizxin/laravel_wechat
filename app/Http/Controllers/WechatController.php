<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Log;

class WechatController extends Controller
{
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        $app = app('wechat');
        $controllerInstance = $this;
        $app->server->setMessageHandler(function($message) use ($controllerInstance,$app){
            return $controllerInstance->messageHandler($message,$app);
        });
        return $app->server->serve();
    }
    /**
     * 根据消息的类型进行再分配的方法
     *
     * @param $message
     * @param $app
     * @return string
     */
    protected function messageHandler($message,$app){
    	$userApi = $app->user;
        switch ($message->MsgType) {
            case 'event':
                # 事件消息...
                return "欢迎关注".$userApi->get($message->FromUserName)->headimgurl;
                break;
            case 'text':
            	// return $message->FromUserName;
            	return $message->Content;
            	// return $userApi->get($message->FromUserName)->headimgurl;
                break;
            case 'image':
                # 图片消息...
                break;
            case 'voice':
                # 语音消息...
                break;
            case 'video':
                # 视频消息...
                break;
            case 'location':
                # 坐标消息...
                break;
            case 'link':
                # 链接消息...
                break;
            // ... 其它消息
            default:
                # code...
                break;
        }
        //如果选择不作任何回复，你也得回复一个空字符串或者字符串 SUCCESS（不然用户就会看到 该公众号暂时无法提供服务）。
        return "success";
    }
}
