<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Services;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->user2 = $this->db->table('user_friend');
        $this->user = $this->db->table('user');
        $this->user3 = $this->db->table('user_info');
        $this->chat = $this->db->table('chat_messages');
        $this->request = $this->db->table('request');
        $this->id = session('login')['id'];
        $this->name = session('login')['name'];
        if (session('login') == "") {
            header("Location:" . base_url());
            exit;
        }
    }
    public function index()
    {
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
            $frnd .= '
                    <span class="user-box" onclick="sid_bar(' . $view->id . ')">
                            <span><img src="' . $view->file_loc . '" alt=""></span>
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
        $frnd = '';
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
                $name = 'ME';
                $button = '<button class="block-btn log-btn" id="logout">LOG OUT</button>';
            } else {
                $name = $data->name;
                $button = '<button class="block-btn" onclick="block(' . $data->id . ')">BLOCK</button>';
                // $statu = $this->checkExist('user_friend',['block'=>0,'user_id'->$data->id]);
                // if($statu){
                // }else{
                //     $button = '<button class="block-btn" onclick="unblock(' . $data->id . ')">UNBLOCK</button>';
                // }
            }
            $shoe .= '
                <div class="image-box">
                    <img src="' . $data->file_loc . '" alt="" srcset="">

                    <span style="font-size:26px;">' . $name . '</span>
                </div>
                <div class="show-box">
                    <span>Active</span>
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
        $data = $this->user2->where('user_id', $this->id)->where('friend', $id)->set('block', 1)->update();
        return (!empty($data)) ? true : false;
    }
    public function unblock($id)
    {
        $data = $this->user2->where('user_id', $this->id)->where('friend', $id)->set('block', 0)->update();
        return (!empty($data)) ? true : false;
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
                $c_with = $this->db->table('conversations')->getWhere(['user1_id' => $this->id, 'user2_id' => $id])->getRow();
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
                    <div class="center-img"><img src="' . $data->file_loc . '" alt=""> </div>
                    <div>' . $data->name . '</div>
                    <div class="center-icon">
                        <span class="call">
                            <i class="fa-solid fa-phone"></i>
                        </span>
                        <span class="call">
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
                            <input type="hidden" id="recdata" value="' . $data->id . '">
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
        $message = $this->request->getPost('message');
        $receiver_id = $this->request->getPost('receiver_id');
        $conversation_id = $this->createConversation($this->id, $receiver_id);
        $data = [
            'conversation_id' => $conversation_id,
            'receiver_id' => $receiver_id,
            'sender_id' => $this->id,
            'message' => $message,
            'created_by' => $this->id,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->chat->insert($data);
        $pusher = Services::pusher();
        $message_data = '';
        $pusherData = [
            'sender_id' => $this->id,
            'receiver_id' => $receiver_id,
            'message' => $message_data
        ];
        $pusher->trigger('chat-channel', 'new-message', $pusherData);
        return $this->response->setJSON(['status' => 'success']);
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
+-------------------+      +---------------------------+      +---------------------------+
|                   |      |                           |      |                           |
|   User Frontend   +----->|   WebSocket Server (Ratchet) +----->|   Backend (CI)           |
|                   |      |                           |      |                           |
+-------------------+      +---------------------------+      +---------------------------+
       |                          |                                  |
       |    WebSocket             |    Store Messages in DB         |    Send/Receive Messages
       |    Connects to           |                                  |
       |    WebSocket Server      |                                  |
       |                          |                                  |
       v                          v                                  v
  Send Messages        Real-Time Message Broadcast           Save Messages to DB

