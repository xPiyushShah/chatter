<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Services;


class UserController extends BaseController
{
    protected $messageModel;
    public function __construct()
    {
        // $this->messageModel = new MessageModel();
        // Services::webSocketServer()->start();
        $this->db = \Config\Database::connect();
        $this->user2 = $this->db->table('user_friend');
        $this->user = $this->db->table('user');
        $this->user3 = $this->db->table('user_info');
        $this->chat = $this->db->table('chat_messages');
        $this->request = $this->db->table('request');
        if (session('login') == "") {
            header("Location:" . base_url());
            exit;
        }else{
            $this->id = session('login')['id'];
            $this->name = session('login')['name'];
        }
    }
    public function index()
    {
        // session()->destroy('login');
        // $server_path = 'server2.php';
        // exec("php $server_path > /dev/null 2>&1 &");
        // echo "Server started in the background!";
        $data['title'] = session('login')['name'];
        echo view('dashboard', $data);
    }
    private function checkExist($table_name = "", $where = [])
    {
        $result = $this->db->table($table_name)->getWhere($where)->getRow();
        return (!empty($result)) ? true : false;
    }
    public function frndData()
    {
        $data = $this->user2->getWhere(['user_id' => $this->id])->getResult();
        $frnd = '';
        foreach ($data as $row) {
            // print_r($row);
            $view = $this->user->getWhere(['id' => $row->friend])->getRow();
            $active = $this->user->getWhere(['id' => $view->id, 'stat' => 1])->getRow();
            $frnd .= '
                    <span class="user-box" onclick="sid_bar(' . $view->id . ')">
                            <span><img src="' . (!empty($view->file_loc) ? $view->file_loc : base_url('/assets/image/images.jpg')) . '" alt="">
                            <span class="active-user" style="display:' . (($active) ? 'block' : 'none') . '; margin-top:' . (($active) ? '-14px' : '') . ';"></span></span>
                            <span class="user-text">
                                ' . $view->name . '
                            </span>
                    </span>
           ';
        }
        echo json_encode($frnd);
    }
    public function getfrnd()
    {
        $data = $this->user->where('id !=', $this->id)->get()->getResult();
        $frnd = '
                         <span class="user-box" >
                                <span></span>
                                <span class="user-text">
                                    Please Add
                                </span>
                        </span>
        ';
        foreach ($data as $row) {
            // $fo = $this->db->table('request')->where('request',$row->id)->where('main',$this->id)->getRow();
            $fo = $this->db->table('request')->getWhere(['request' => $row->id, 'main' => $this->id])->getRow();
            if ($fo) {
                if ($fo->accept == 0) {
                    $bt = '<button onclick="frns(' . $row->id . ')">Accept</button>';
                } else if ($fo->accept == 1) {
                    $bt = '<button onclick="frn()">ADD</button>';
                }
            } else {
                $bt = '<button onclick="frn(' . $row->id . ')">ADD</button>';
            }
            // if($fo->)
            $al = $this->user2->getWhere(['user_id' => $this->id, 'friend' => $row->id])->getRow();
            if (!$al) {
                $frnd .= '
                        <span class="user-box" >
                                <span><img src="' . $row->file_loc . '" alt=""></span>
                                <span class="user-text">
                                    ' . $row->name . '
                                </span>
                               ' . $bt . '
                        </span>
               ';

            }
        }
        echo json_encode($frnd);
    }
    public function accept($id)
    {
        $this->db->table('request')->where('id ', $this->id)->where('request', $id)->set('accept', 1)->update();
        $main_id = 10;
        if ($main_id) {
            $r = [
                'user_id' => $this->id,
                'user_name' => $this->name,
                'friend' => $id,
                'block' => 0
            ];
            $this->user2->insert($r);
        }
        echo json_encode($main_id);
    }
    public function sent($id)
    {
        $arr = [
            'main' => $this->id,
            'request' => $id,
            'accept' => 0
        ];
        $this->db->table('request')->insert($arr);
        $main_id = $this->db->insertID();
        echo json_encode($main_id);
    }
    public function sideData($id)
    {
        $shoe = '';
        $data = $this->user->getWhere(['id' => $id])->getRow();
        if ($data) {
            if ($id === $this->id) {
                $name = 'Me';
                $button = '<button class="block-btn log-btn" id="logout">LOG OUT</button>';
            } else {
                $name = $data->name;
                $statu = $this->user2->getWhere(['user_id' => $this->id, 'friend' => $data->id, 'block' => 0])->getRow();
                if ($statu) {
                    $button = '<button class="block-btn" onclick="block(' . $data->id . ')">BLOCK</button>';
                } else {
                    $button = '<button class="block-btn" onclick="unblock(' . $data->id . ')">UNBLOCK</button>';
                }
            }
            $active = $this->user->getWhere(['id' => $data->id, 'stat' => 1])->getRow();
            $shoe .= '
                <div class="image-box">
                    <img src="' . ((!empty($data->file_loc)) ? $data->file_loc : base_url('/assets/image/images.jpg')) . '" alt="" srcset="">

                    <span style="font-size:26px;">' . $name . '</span>
                </div>
                <div class="show-box">
                    <span>' . (($active) ? 'Active' : 'In Active') . '</span>
                    <span>Birth Date: ' . date('d-M-Y', strtotime($data->dob)) . '</span>
                    <span>Joined At: ' . date('d-m-y', strtotime($data->created_at)) . ' </span>
                </div>
                <div class="action-box">
                ' . $button . '
                </div>
            ';
        }
        echo json_encode($shoe);
    }
    public function block($id)
    {
        $this->user2->where('user_id', $this->id)->where('friend', $id)->set('block', 1)->update();
        // echo (!empty($data)) ? true : false;
        echo json_encode(10);
    }
    public function unblock($id)
    {
        $this->user2->where('user_id', $this->id)->where('friend', $id)->set('block', 0)->update();
        // return (!empty($data)) ? true : false;
        echo json_encode(10);
    }
    private function timeAgo($datetime)
    {

        $currentTime = new DateTime();
        $messageTime = new DateTime($datetime);
        $interval = $currentTime->diff($messageTime);

        // Calculate time difference
        if ($interval->y > 0) {
            return $interval->y . ' year' . ($interval->y > 1 ? 's' : '') . '';
        } elseif ($interval->m > 0) {
            return $interval->m . ' month' . ($interval->m > 1 ? 's' : '') . '';
        } elseif ($interval->d > 0) {
            if ($interval->d == 1) {
                return 'Yesterday';
            }
            return $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . '';
        } elseif ($interval->h > 0) {
            return $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . '';
        } elseif ($interval->i > 0) {
            return $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . '';
        } else {
            return $interval->s . ' second' . ($interval->s > 1 ? 's' : '') . '';
        }
    }
    private function timeAgos($timestamp)
    {
        $timeElapsed = time() - $timestamp;
        $seconds = $timeElapsed;

        $years = floor($seconds / 31536000);
        if ($years > 1)
            return $years . " years ago";

        $months = floor($seconds / 2592000);
        if ($months > 1)
            return $months . " months ago";

        $days = floor($seconds / 86400);
        if ($days > 1)
            return $days . " days ago";

        $hours = floor($seconds / 3600);
        if ($hours > 1)
            return $hours . " hours ago";

        $minutes = floor($seconds / 60);
        if ($minutes > 1)
            return $minutes . " minutes ago";

        return $seconds . " seconds ago";
    }
    public function loadmsg($id)
    {
        if ($id == $this->id) {
            $msg = '';
        } else {
            $data = $this->user->getWhere(['id' => $id])->getRow();
            $msg = '';
            $msg_box = '';
            //chat with feind
            if ($data) {
                // $c_with = $this->db->table('conversations')->getWhere(['user1_id' => $this->id, 'user2_id' => $id])->getRow();
                $c_with = $this->db->table('conversations')->where("(user1_id = $id ) OR (user2_id = $id)")->get()->getRow();
                // print_r($c_with);exit;
                if ($c_with) {
                    $chats = $this->chat->getWhere(['conversation_id' => $c_with->id])->getResult();
                    foreach ($chats as $cmsg) {
                        $timestamp = strtotime($cmsg->created_at);
                        $msg_box .= '
                        <div class="message ' . ($this->id == $cmsg->created_by ? 'own' : 'rec') . '">
                            <div class="text">
                                <p>' . $cmsg->message . '</p>
                                <span>' . $this->timeAgos($timestamp) . '</span>
                            </div>
                        </div>';
                    }
                } else {
                    $msg_box = '';
                }
                // print_r($msg_box);exit;
                $msg .= '
                    <div class="center-header">
                    <div class="center-img"><img src="' . (!empty($data->file_loc) ? $data->file_loc : base_url('/assets/image/images.jpg')) . '" alt=""> </div>
                    <div>' . $data->name . '</div>
                    <div class="center-icon">
                        <span class="call" style="cursor: pointer;"  onclick="call(' . $data->id . ')">
                            <i class="fa-solid fa-phone"></i>
                        </span>
                        <span class="call" style="cursor: pointer;" onclick="videoCall(' . $data->id . ')">
                            <i class="fa-solid fa-video"></i>
                        </span>
                    </div>
                </div>
                <div class="center-msg-box"  id="messageBox">
                  ' . $msg_box . '
                </div>
                <div class="center-text-box">
                    <div class="center-fi">
                        <button class="file-btn">+</button>
                        <button class="emoji-btn">😊</button>
                        <emoji-picker id="emojiPicker"></emoji-picker>
                    </div>
                    <div class="center-sec">
                            <input type="text" id="messageInput" placeholder="Type a message">
                            <button id="my_"  class="send" onclick="sendmsg(' . $data->id . ')" style="cursor:pointer;">Send</button>
                    </div>
                </div>
            ';
            }
        }
        echo json_encode($msg);
    }
    public function sendMessage()
    {
        $msg = $this->request->getVar('msg');
        $receiver_id = $this->request->getVar('receiver_id');
        // print_r($receiver_id);
        // print_r( $message);exit;
        $message['message'] = $msg;
        $message['receiver_id'] = $receiver_id;
        $message['sender_id'] = $this->id;
        $message['created_by'] = $this->id;
        $message['conversation_id'] = $this->createConversation($this->id, $receiver_id);
        ;
        $this->chat->insert($message);
        $main_id = $this->db->insertID();
        echo json_encode($main_id);
    }
    public function createConversation($user_1_id, $user_2_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('conversations');
        $query = $builder->where("(user1_id = $user_1_id AND user2_id = $user_2_id) OR (user1_id = $user_2_id AND user2_id = $user_1_id)")
            ->get();
        if ($query->getNumRows() > 0) {
            return $query->getRow()->id;
        } else {
            $data = [
                'user1_id' => $user_1_id,
                'user2_id' => $user_2_id
            ];
            $builder->insert($data);
            return $db->insertID();
        }
    }
}
