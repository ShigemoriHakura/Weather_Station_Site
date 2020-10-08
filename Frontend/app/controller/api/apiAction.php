<?php

namespace app\controller;
use App;
use biny\lib\Language;
use biny\lib\Lunar;
use Constant;

class apiAction extends baseAction
{
    /**
     * API
     */
    public function action_index()
    {
        $result = array(
            "result" => 1,
            "data" => "Welcome"
        );
        header('Content-Type: application/json');
        return json_encode($result);
    }

    public function action_weather()
    {
        header('Content-Type: application/json');
        $result = array(
            "result" => 1,
            "data" => "Error"
        );
        $token = $this->request->get('token');
        if(!$token){
            return json_encode($result);
        }
        $tokenData = $this->tokenDAO->filter([
            'enabled' => 1,
            'token'   => $token,
        ])->find();
        if(!$tokenData){
            return json_encode($result);
        }else{
            $weatherData = $this->weatherDAO->filter([
                'city' => $tokenData['city'],
            ])->order('add_date','Desc')->limit(1)->find();
            if(!$weatherData){
                $updateSet = [];
                $url = "https://restapi.amap.com/v3/weather/weatherInfo?key=" . App::$base->app_config->get('api_Key') . "&extensions=all&city=";
                $data = $this->curl_file_get_contents($url . $tokenData['city']);
                if ($jsonData = json_decode($data, true)) {
                    $updateSet[] = array(
                        "add_date" => time(),
                        "city" => $tokenData['city'],
                        "status" => $data
                    );
                    $this->weatherDAO->addList($updateSet);
                    $result['data'] = $this->convertWeatherData($data);
                    $result['data']['city'] =  $tokenData['city'];
                    $result['data']['note'] =  $tokenData['note'];
                    $result['data']['timestampText'] = date("Y-m-d H:i", time());
                    $result['data']['dayText'] = date("m月d日", time());
                }
            }else{
                $result['data'] = $this->convertWeatherData($weatherData['status']);
                $result['data']['city'] =  $tokenData['city'];
                $result['data']['note'] =  $tokenData['note'];
                $result['data']['timestampText'] = date("H:i", time());
                $result['data']['dayText'] = date("m月d日", time());
            }
        }
        return json_encode($result,JSON_UNESCAPED_UNICODE);
    }
    
    public function action_base()
    {
        header('Content-Type: application/json');
        $result = array(
            "result" => 1,
            "data" => "Error"
        );
        $token = $this->request->get('token');
        if(!$token){
            return json_encode($result);
        }
        $tokenData = $this->tokenDAO->filter([
            'enabled' => 1,
            'token'   => $token,
        ])->find();
        if(!$tokenData){
            return json_encode($result);
        }else{
            $weatherData = $this->weatherBaseDAO->filter([
                'city' => $tokenData['city'],
            ])->order('add_date','Desc')->limit(1)->find();
            if(!$weatherData){
                $updateSet = [];
                $url = "https://restapi.amap.com/v3/weather/weatherInfo?key=" . App::$base->app_config->get('api_Key') . "&extensions=base&city=";
                $data = $this->curl_file_get_contents($url . $tokenData['city']);
                if ($jsonData = json_decode($data, true)) {
                    $updateSet[] = array(
                        "add_date" => time(),
                        "city" => $tokenData['city'],
                        "status" => $data
                    );
                    $this->weatherBaseDAO->addList($updateSet);
                    $result['data'] = $this->convertWeatherBaseData($data);
                    $result['data']['city'] =  $tokenData['city'];
                    $result['data']['note'] =  $tokenData['note'];
                    $result['data']['timestampText'] = date("Y-m-d H:i", time());
                    $result['data']['dayText'] = date("m月d日", time());
                }
            }else{
                $result['data'] = $this->convertWeatherBaseData($weatherData['status']);
                $result['data']['city'] =  $tokenData['city'];
                $result['data']['note'] =  $tokenData['note'];
                $result['data']['timestampText'] = date("H:i", time());
                $result['data']['dayText'] = date("m月d日", time());
            }
        }
        return json_encode($result,JSON_UNESCAPED_UNICODE);
    }

    public function action_time()
    {
        $result = array(
            "result" => 1,
            "data" => array(
                "timeStamp" => time(),
                "timeStampText" => date("Y-m-d H:i", time()),
            )
        );
        header('Content-Type: application/json');
        return json_encode($result);
    }

    public function convertWeatherData($data){
        if($jsonData = json_decode($data, true)) {
            $dayTemp = "";
            $nightTemp = "";
            $code_d = "";
            $code_n = "";
            $text_d = "";
            $text_n = "";
            $date = "";
            $point_n = count($jsonData['forecasts'][0]['casts']);
            $line_n = count($jsonData['forecasts'][0]['casts']);
            foreach ($jsonData['forecasts'][0]['casts'] as $v) {
                $dayTemp .= $v['daytemp'] . ",";
                $nightTemp .= $v['nighttemp'] . ",";
                $code_d .= $this->getWeatherCodeIcon($v['dayweather']) . ",";
                $code_n .= $this->getWeatherCodeIcon($v['nightweather']) . ",";
                $text_d .= $v['dayweather'] . ",";
                $text_n .= $v['nightweather'] . ",";
                $date  .= date("m-d",strtotime($v['date'])) . ",";
            }
            $dayTemp = substr($dayTemp,0,strlen($dayTemp)-1);
            $nightTemp = substr($nightTemp,0,strlen($nightTemp)-1);
            $code_d = substr($code_d,0,strlen($code_d)-1);
            $code_n = substr($code_n,0,strlen($code_n)-1);
            $text_d = substr($text_d,0,strlen($text_d)-1);
            $text_n = substr($text_n,0,strlen($text_n)-1);
            $date = substr($date,0,strlen($date)-1);
            $result = array(
                "dayTemp"   => $dayTemp,
                "nightTemp" => $nightTemp,
                "code_d" => $code_d,
                "code_n" => $code_n,
                "text_d" => $text_d,
                "text_n" => $text_n,
                "point_n" => $point_n,
                "line_n" => $line_n,
                "date" => $date,
            );
            return $result;
        }else{
            return [];
        }
    }

    public function convertWeatherBaseData($data){
        if($jsonData = json_decode($data, true)) {
            $result = array(
                "temperature" => $jsonData["lives"][0]["temperature"],
                "humidity"    => $jsonData["lives"][0]["humidity"],
                "icon"        => $this->getWeatherCodeIcon($jsonData["lives"][0]["weather"]),
                "winddirection" => $jsonData["lives"][0]["winddirection"],
                "windpower"     => $jsonData["lives"][0]["windpower"],
                "weather"       => $jsonData["lives"][0]["weather"],
            );
            return $result;
        }else{
            return [];
        }
    }

    public function getWeatherCodeIcon($weather){
        $arr = array(
            "晴"=>"0",
            "多云"=>"1",
            "少云"=>"2",
            "晴间多云"=>"3",
            "阴"=>"4",
            "阵雨"=>"19",
            "强阵雨"=>"20",
            "雷阵雨"=>"21",
            "强雷阵雨"=>"22",
            "雷阵雨伴有冰雹"=>"23",
            "小雨"=>"24",
            "中雨"=>"25",
            "大雨"=>"26",
            "极端降雨"=>"27",
            "毛毛雨/细雨"=>"28",
            "暴雨"=>"29",
            "大暴雨"=>"30",
            "特大暴雨"=>"31",
            "冻雨"=>"32",
            "小雪"=>"33",
            "中雪"=>"34",
            "大雪"=>"35",
            "暴雪"=>"36",
            "雨夹雪"=>"37",
            "雨雪天气"=>"38",
            "阵雨夹雪"=>"39",
            "阵雪"=>"40",
            "雾"=>"41",
            "薄雾"=>"42",
            "霾"=>"43",
            "扬沙"=>"44",
            "浮尘"=>"45",
            "沙尘暴"=>"46",
            "强沙尘暴"=>"47",
            "热"=>"48",
            "冷"=>"49",
            "未知"=>"50"
        );
        if(isset($arr[$weather])){
            return $arr[$weather];
        }else{
            return 0;
        }
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

