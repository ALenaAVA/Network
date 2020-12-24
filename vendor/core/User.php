<?php

namespace vendor\core;

use vendor\core\DB;

class User
{
    protected $db, $config;
    public $sess_id, $id, $res_def = 'Не указано';
    public function __construct($login = '')
    {
        $this->connect();
        $this->sess_id();
        $this->id($login);
    }
    protected function connect()
    {
        $this->config = include 'config.php';
        $this->db = new DB(
            $this->config['DB']['name'],
            $this->config['DB']['user'],
            $this->config['DB']['pass'],
            $this->config['DB']['host'],
            $this->config['DB']['type']
        );
    }

    public function sess_id()
    {
        if (empty($_SESSION['id'])) {
            return false;
        } else {
            $this->sess_id = $_SESSION['id'];
        }
    }

    public function sess_login()
    {
        $q = $this->db->getRow("SELECT `login` FROM `users` WHERE `id` = ?", [$this->sess_id]);
        return $q['login'];
    }
    public function sess_email()
    {
        $q = $this->db->getRow("SELECT `email` FROM `users` WHERE `id` = ?", [$this->sess_id]);
        return $q['email'];
    }
    public function sess_password()
    {
        $q = $this->db->getRow("SELECT `password` FROM `users` WHERE `id` = ?", [$this->sess_id]);
        return $q['password'];
    }
    public function sess_name()
    {
        $q = $this->db->getRow("SELECT `name` FROM `users` WHERE `id` = ?", [$this->sess_id]);
        return $q['name'];
    }
    public function sess_surname()
    {
        $q = $this->db->getRow("SELECT `surname` FROM `users` WHERE `id` = ?", [$this->sess_id]);
        return $q['surname'];
    }
    public function sess_birthday()
    {
        $q = $this->db->getRow("SELECT `birthday` FROM `users` WHERE `id` = ?", [$this->sess_id]);
        return $q['birthday'];
    }

    public function sess_birthmonth()
    {
        $q = $this->db->getRow("SELECT `birthmonth` FROM `users` WHERE `id` = ?", [$this->sess_id]);
        return $q['birthmonth'];
    }
    public function sess_birthyear()
    {
        $q = $this->db->getRow("SELECT `birthyear` FROM `users` WHERE `id` = ?", [$this->sess_id]);
        return $q['birthyear'];
    }

    public function sess_sex()
    {
        $q = $this->db->getRow("SELECT `sex` FROM `users` WHERE `id` = ?", [$this->sess_id]);
        return $q['sex'];
    }
    public function sess_avatar()
    {
        $q = $this->db->getRow("SELECT `avatar` FROM `users` WHERE `id` = ?", [$this->sess_id]);
        return AVATARS . $q['avatar'];
    }
    public function sess_banner()
    {
        $q = $this->db->getRow("SELECT `banner` FROM `users` WHERE `id` = ?", [$this->sess_id]);
        if ($q['banner'] == 'no-banner.png') {
            $dir = IMG . '/other/';
        } else {
            $dir = UPLOAD . '/banners/';
        }

        return $dir . $q['banner'];
    }
    public function sess_path()
    {
        $q = $this->db->getRow("SELECT `path` FROM `users` WHERE `id` = ?", [$this->sess_id]);
        return $q['path'];
    }
    public function sess_city()
    {
        $q = $this->db->getRow("SELECT `city` FROM `users` WHERE `id` = ?", [$this->sess_id]);
        return $q['city'];
    }
    public function sess_maritalStatus()
    {
        $q = $this->db->getRow("SELECT `maritalStatus` FROM `users` WHERE `id` = ?", [$this->sess_id]);
        return $q['maritalStatus'];
    }

    public function sess_showBirthday()
    {
        $q = $this->db->getRow("SELECT `showBirthday` FROM `users` WHERE `id` = ?", [$this->sess_id]);
        return $q['showBirthday'];
    }

    public function sess_friendsList()
    {
        $q = $this->db->getRows("SELECT id_user_1 FROM friends WHERE id_user_2 = ? AND `status` = ?", [$this->sess_id, 2]);
        $q2 = $this->db->getRows("SELECT id_user_2 FROM friends WHERE id_user_1 = ? AND `status` = ?", [$this->sess_id, 2]);
        $q = array_merge($q, $q2);
        return $q;
    }

    public function sess_userRole()
    {
        $q = $this->db->getRow("SELECT `role` FROM users WHERE id = ?", [$this->sess_id]);
        
        return $q['role'];
    }

    public function id($login = '')
    {
        if (empty($login)) {
            $this->id = $this->sess_id;
        } else {
            $q = $this->db->getRow("SELECT `id` FROM `users` WHERE `login` = ?", [trim($login)]);
            $this->id = $q['id'];
        }
    }
    public function login()
    {
        $q = $this->db->getRow("SELECT `login` FROM `users` WHERE `id` = ?", [$this->id]);
        return $q['login'];
    }
    public function email()
    {
        $q = $this->db->getRow("SELECT `email` FROM `users` WHERE `id` = ?", [$this->id]);
        return $q['email'];
    }
    public function password()
    {
        $q = $this->db->getRow("SELECT `password` FROM `users` WHERE `id` = ?", [$this->id]);
        return $q['password'];
    }
    public function name()
    {
        $q = $this->db->getRow("SELECT `name` FROM `users` WHERE `id` = ?", [$this->id]);
        return $q['name'];
    }
    public function surname()
    {
        $q = $this->db->getRow("SELECT `surname` FROM `users` WHERE `id` = ?", [$this->id]);
        return $q['surname'];
    }
    public function birthday()
    {
        $q = $this->db->getRow("SELECT `birthday` FROM `users` WHERE `id` = ?", [$this->id]);
        return $q['birthday'];
    }
    public function birthmonth()
    {
        $q = $this->db->getRow("SELECT `birthmonth` FROM `users` WHERE `id` = ?", [$this->id]);
        return $q['birthmonth'];
    }
    public function birthyear($type = '')
    {

        $q = $this->db->getRow("SELECT `birthyear` FROM `users` WHERE `id` = ?", [$this->id]);
        return $q['birthyear'];
    }

    public function sex()
    {
        $q = $this->db->getRow("SELECT `sex` FROM `users` WHERE `id` = ?", [$this->id]);
        return $q['sex'];
    }
    public function avatar()
    {
        $q = $this->db->getRow("SELECT `avatar` FROM `users` WHERE `id` = ?", [$this->id]);
        return '/network3/uploads/avatars/' . $q['avatar'];
    }
    public function banner()
    {
        $q = $this->db->getRow("SELECT `banner` FROM `users` WHERE `id` = ?", [$this->id]);
        if ($q['banner'] == 'no-banner.png') {
            $dir = IMG . '/other/';
        } else {
            $dir = UPLOAD . '/banners/';
        }

        return $dir . $q['banner'];
    }
    
    public function path()
    {
        $q = $this->db->getRow("SELECT `path` FROM `users` WHERE `id` = ?", [$this->id]);
        return $q['path'];
    }

    public function city()
    {
        $q = $this->db->getRow("SELECT `city` FROM `users` WHERE `id` = ?", [$this->id]);
        if (!empty($q['city'])) {
            return $q['city'];
        } else {
            return "<label style = 'color: rgba(0,0,0,.4)'>" . $this->res_def . "</label>";
        }
    }

    public function maritalStatus()
    {
        $q = $this->db->getRow("SELECT `maritalStatus` FROM `users` WHERE `id` = ?", [$this->id]);
        return $q['maritalStatus'];
    }

    public function showBirthday()
    {
        $q = $this->db->getRow("SELECT `showBirthday` FROM `users` WHERE `id` = ?", [$this->id]);
        return $q['showBirthday'];
    }

    public function friendsList($p = '')
    {
        $q = $this->db->getRows("SELECT id_user_1 FROM friends WHERE id_user_2 = ? AND `status` = ?", [$this->id, 2]);
        if ($q) {
            for ($i = 0; $i < count($q); $i++) {
                $q[$i]['id_user'] = $q[$i]['id_user_1'];
            }
        }

        $q2 = $this->db->getRows("SELECT id_user_2 FROM friends WHERE id_user_1 = ? AND `status` = ?", [$this->id, 2]);
        if ($q2) {
            for ($i = 0; $i < count($q2); $i++) {
                $q2[$i]['id_user'] = $q2[$i]['id_user_2'];
            }
        }

        $q = array_merge($q, $q2);

        if ($p == 'online') {
            $query = [];
            for ($i = 0; $i < count($q); $i++) {
                $qr = $this->db->getRow("SELECT id FROM users WHERE id = ? AND `online` = ?", [$q[$i]['id_user'], 1]);
                if (!empty($qr))
                    $query[] = $qr['id'];
            }
            return $query;
        }
        return $q;
    }

    public function lastVisit()
    {
        //$this->online();
        $q = $this->db->getRow("SELECT lastVisit FROM users WHERE id = ?", [$this->id]);
        
        return $q['lastVisit'];
    }
    public function online()
    {
        $h = substr($this->lastVisit(), -5, 2);
        $min = substr($this->lastVisit(), -2);
        $d = substr($this->lastVisit(), 0, 2);
        $m = substr($this->lastVisit(), 3, 2);
        $y = substr($this->lastVisit(), 6, 4);

        $q = $this->db->getRow("SELECT `online` FROM users WHERE id = ?", [$this->id]);

        // if ($q['online'] == 1)
        //     return 'Online';
        // elseif ($q['online'] == 1 && mktime($h, $min, 0, $m, $d, $y) + 600 < date('U')) {
        //     $this->db->updateRow('UPDATE users SET `online` = ?', ['0']);

        //     return $this->lastVisit();
        // } else
        //     return $this->lastVisit();

        if ($q['online'] == 1 && (mktime($h, $min, 0, $m, $d, $y) + 600 < date('U'))) {
            $this->db->updateRow('UPDATE users SET `online` = ? WHERE id = ?', ['0',$this->id]);
            return $this->lastVisit();
        } elseif ($q['online'] == 1)
            return 'Online';
        else
            return $this->lastVisit();
    }
}
