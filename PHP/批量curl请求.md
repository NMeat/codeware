### 批量curl请求

    //批量curl请求
    public function multiple_threads_request($urls){
        $mh = curl_multi_init();
        $curl_array = array();
    
        foreach ($urls as $i => $url) {
            $curl_array[$i] = curl_init($url);
            curl_setopt($curl_array[$i], CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_array[$i], CURLOPT_NOSIGNAL, 1);
            curl_setopt($curl_array[$i], CURLOPT_CONNECTTIMEOUT_MS, 300);
            curl_setopt($curl_array[$i], CURLOPT_TIMEOUT_MS, 300);
            curl_multi_add_handle($mh, $curl_array[$i]);
        }
    
        $running = NULL;
        do {
            usleep(10000);
            curl_multi_exec($mh, $running);
        } while ($running > 0);
    
        $res = array();
        foreach ($urls as $i => $url) {
            $res[$i] = curl_multi_getcontent($curl_array[$i]);
        }
    
        foreach ($urls as $i => $url) {
            curl_multi_remove_handle($mh, $curl_array[$i]);
        }
    
        curl_multi_close($mh);
        return $res;
    }