<?php


use Library\Plugin;
use CoolQSDK\CQ;
/**
 * Created by PhpStorm.
 * User: Slight
 * Date: 2017/5/5
 * Time: 14:43
 */
class TulingPlugin extends Plugin
{

    public function Start()
    {
        global $_Request;
        global $Robot;
        $post_type = $_Request['post_type'];
        $message_type = $_Request['message_type'];
        $user_id = $_Request['user_id'];
        $message = $_Request['message'];
        switch ($post_type) {
            case "message":
                $url = "http://www.kilingzhang.com/Api/YiBao/api.php?role=" . Role . "&hash=" . Hash . "&user_id=$user_id&text=" . urlencode($message) . "&on=true";
                $json = file_get_contents($url);
                $data = json_decode($json, true);
                if (!empty($data) && $data['code'] != 0) {
                    $msg = addslashes($json);
                } else {
                    $msg = $data['data'];
                }
                switch ($message_type) {
                    case "private":
                        $sub_type = $_Request['sub_type'];
                        switch ($sub_type) {
                            case "friend":
                                $Robot->sendPrivateMsg($user_id, CQ::deCodeHtml(addslashes($msg)));
                                break;
                            case "group":

                                break;
                            case "discuss":

                                break;
                            case "other":

                                break;
                        }
                        break;
                    case "group":
                        $group_id = $_Request['group_id'];
                        $Robot->sendGroupMsg($group_id, CQ::deCodeHtml($msg), $user_id);
                        break;
                    case "discuss":
                        $discuss_id = $_Request['discuss_id'];
                        $Robot->sendDiscussMsg($discuss_id, CQ::deCodeHtml($msg));
                        break;
                }

                break;
        }
        $this->setIntercept(true);
    }

}