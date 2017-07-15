<?php

class Security {
    
    public function generate_csrf_token() {
        $extra = sha1($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
        $token = base64_encode(time() . $extra . $this->randomString(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }
    
    
    protected function randomString($length)
    {
        $seed = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijqlmnopqrtsuvwxyz0123456789';
        $max = strlen($seed) - 1;
        $string = '';
        for ($i = 0; $i < $length; ++$i) {
                $string .= $seed{intval(mt_rand(0.0, $max))};
        }
        return $string;
    }
    
}

