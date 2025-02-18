<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class VideoCallController extends BaseController
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
    public function vopen($id)
    {
        $data = $this->user->getWhere(['id' => $id])->getRow();
        $box = '';

        if ($data) {
            $box .= '
            <div class="center-header">
              <div class="center-img">
                <img src="' . (!empty($data->file_loc) ? $data->file_loc : base_url('/assets/image/images.jpg')) . '" alt="">
              </div>
              <div>' . $data->name . '</div>
            </div>
            <div class="center-msg-box" id="videoCallBox">
              <video id="localVideo" autoplay muted></video>
              <video id="remoteVideo" autoplay></video>
              <div id="callingMessage">Calling...</div> 
            </div>
            <div class="center-text-box">
              <div class="center-sec">
                <button class="closeCallBtn" onclick="endCall()">Close</button>
              </div>
              <div class="center-sec">
                <button id="videoToggleBtn" onclick="toggleVideo()">OFF</button>
                <button id="audioToggleBtn" onclick="toggleAudio()">Mute</button>
              </div>
            </div>';
        }
        echo json_encode($box);
    }
    public function copen($id)
    {
        $data = $this->user->getWhere(['id' => $id])->getRow();
        $box = '';

        if ($data) {
            $box .= '
            <div class="center-header">
              <div>' . $data->name . '</div>
            </div>
            <div class="center-msg-box" id="audioCallBox" style="display:none;">
              <img src="' . (!empty($data->file_loc) ? $data->file_loc : base_url('/assets/image/images.jpg')) . '" alt=""> 
              <div id="callingMessageAudio">Calling...</div>
            </div>
            <div class="center-text-box">
              <button class="closeCallBtn" onclick="endCall()">Close</button>
              <div class="center-sec">
                <button id="audioToggleBtn" onclick="toggleAudio()">Mute</button>
              </div>
            </div>';
        }
        echo json_encode($box);
    }
    public function show($id,$type)
    {
        $data = $this->user->getWhere(['id' => $id])->getRow();
        $box = '';

        if ($type == 0) {
            $box .= '
            <div class="center-header">
              <div>' . $data->name . '</div>
            </div>
            <div class="center-msg-box" id="audioCallBox" style="display:none;">
              <img src="' . (!empty($data->file_loc) ? $data->file_loc : base_url('/assets/image/images.jpg')) . '" alt=""> 
              <div id="callingMessageAudio">Calling...</div>
            </div>
            <div class="center-text-box">
              <button class="closeCallBtn" onclick="endCall()">Close</button>
              <div class="center-sec">
                <button id="audioToggleBtn" onclick="toggleAudio()">Mute</button>
              </div>
            </div>';
        }else{
          $box .= '
          <div class="center-header">
            <div class="center-img">
              <img src="' . (!empty($data->file_loc) ? $data->file_loc : base_url('/assets/image/images.jpg')) . '" alt="">
            </div>
            <div>' . $data->name . '</div>
          </div>
          <div class="center-msg-box" id="videoCallBox">
            <video id="localVideo" autoplay muted></video>
            <video id="remoteVideo" autoplay></video>
            <div id="callingMessage">Calling...</div> 
          </div>
          <div class="center-text-box">
            <div class="center-sec">
              <button class="closeCallBtn" onclick="endCall()">Close</button>
            </div>
            <div class="center-sec">
              <button id="videoToggleBtn" onclick="toggleVideo()">OFF</button>
              <button id="audioToggleBtn" onclick="toggleAudio()">Mute</button>
            </div>
          </div>';
        }
        echo json_encode($box);
    }


}
