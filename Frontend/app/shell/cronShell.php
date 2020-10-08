<?php

namespace app\shell;
use App;
use biny\lib\Shell;

class cronShell extends Shell
{

    //默认路由index
    public function action_index()
    {
        $url = "https://restapi.amap.com/v3/weather/weatherInfo?key=" . App::$base->app_config->get('api_Key') . "&extensions=all&city=";
        $tokenData = $this->tokenDAO->filter([
            'enabled' => 1,
        ])->distinct('city');
        $updateSet = [];
        $time = time();
        foreach ($tokenData as $v){
            $data = $this->curl_file_get_contents($url . $v['city']);
            if ($jsonData = json_decode($data, true)) {
                $updateSet[] = array(
                    "add_date" => $time,
                    "city" => $v['city'],
                    "status" => $data
                );
            }
            sleep(0.05);
        }
        $result = $this->weatherDAO->addList($updateSet);
        return json_encode(array("result" => $result, "data" => $updateSet));
    }
    
    public function action_base()
    {
        $url = "https://restapi.amap.com/v3/weather/weatherInfo?key=" . App::$base->app_config->get('api_Key') . "&extensions=base&city=";
        $tokenData = $this->tokenDAO->filter([
            'enabled' => 1,
        ])->distinct('city');
        $updateSet = [];
        $time = time();
        foreach ($tokenData as $v){
            $data = $this->curl_file_get_contents($url . $v['city']);
            if ($jsonData = json_decode($data, true)) {
                $updateSet[] = array(
                    "add_date" => $time,
                    "city" => $v['city'],
                    "status" => $data
                );
            }
            sleep(0.05);
        }
        $result = $this->weatherBaseDAO->addList($updateSet);
        return json_encode(array("result" => $result, "data" => $updateSet));
    }

    public function action_clean(){
        $todayTimestamp = strtotime(date('Y-m-d'));
        $result = $this->weatherDAO->filter([
            '<'=>array('add_date'=> $todayTimestamp)
        ])->delete();
        return json_encode(array("result" => $result, "data" => $todayTimestamp));
    }

    public function curl_file_get_contents($durl){
        // header传送格式
        $headers = array(
        );
        $user_agent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36";

        // 初始化
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_USERAGENT,$user_agent);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1 );
        // 设置url路径
        curl_setopt($curl, CURLOPT_URL, $durl);
        // 将 curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true) ;
        // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        curl_setopt($curl, CURLOPT_BINARYTRANSFER, true) ;
        // 添加头信息
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        // CURLINFO_HEADER_OUT选项可以拿到请求头信息
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        // 不验证SSL
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        // 执行
        $data = curl_exec($curl);
        // 打印请求头信息
//        echo curl_getinfo($curl, CURLINFO_HEADER_OUT);
        // 关闭连接
        curl_close($curl);
        // 返回数据
        return $data;
    }

}