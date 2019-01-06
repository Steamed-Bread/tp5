<?php
/**
 * 
 * 接口访问类，包含所有微信开发API列表的封装，类中方法为static方法，
 * 每个接口有默认超时时间（除提交被扫支付为10s，上报超时时间为1s外，其他均为6s）
 * @author xuxing
 *
 */
namespace app\admin\tools;
class WSCApi
{

	protected $values = array();


	/**
	 *数据库连接 wsc
	**/
	public static function conn(){

	    $con = mysql_connect(WSCConfig::DBHOST,WSCConfig::USERNAME,WSCConfig::PASSWD)or die("error connecting");
	    if ($con)
	      {
	     //echo "Connect successfully<br>";
	      }
	    mysql_query("set names 'utf8'");
	    mysql_select_db(WSCConfig::DBDATABASE);  
	    return $con;
	}


		/**
	 *数据库连接 nb
	**/
	public static function conn_nb(){

	    $con = mysql_connect(WSCConfig::DBHOST,WSCConfig::USERNAME,WSCConfig::PASSWD)or die("error connecting");
	    if ($con)
	      {
	     //echo "Connect successfully<br>";
	      }
	    mysql_query("set names 'utf8'");
	    mysql_select_db(WSCConfig::DBDATABASE_NB);  
	    return $con;
	}

	/**
	 * 输出xml字符
	 * @throws WSCException
	**/
	public function ToXml()
	{
		if(!is_array($this->values) 
			|| count($this->values) <= 0)
		{
    		throw new WSCException("数组数据异常！");
    	}
    	
    	$xml = "<xml>";
    	foreach ($this->values as $key=>$val)
    	{
    		if (is_numeric($val)){
    			$xml.="<".$key.">".$val."</".$key.">";
    		}else{
    			$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
    		}
        }
        $xml.="</xml>";
        return $xml; 
	}
	
    /**
     * 将xml转为array
     * @param string $xml
     * @throws WSCException
     */
	public function FromXml($xml)
	{	
		if(!$xml){
			throw new WSCException("xml数据异常！");
		}
        //将XML转为array 
        $this->values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);		
		return $this->values;
	}
	

	/**
	 * 
	 * 产生随机字符串，不长于32位
	 * @param int $length
	 * @return 产生的随机字符串
	 */
	public static function getNonceStr($length = 32) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
		$str ="";
		for ( $i = 0; $i < $length; $i++ )  {  
			$str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
		} 
		return $str;
	}
	
	/**
	 * 直接输出xml
	 * @param string $xml
	 */
	public static function replyNotify($xml)
	{
		echo $xml;
	}
	
	
    /**
	 * 以get方式请求数据
	 */
	public static function http_get($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22");
		curl_setopt($ch, CURLOPT_ENCODING ,'gzip'); //加入gzip解析
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}

    /**
	 * 以post方式提交到对应的接口url
	 * 
	 * @param string $data  需要post的数据
	 * @param string $url  url
	 */
	public static function http_post($data,$url){
		 $ch = curl_init();
		 curl_setopt($ch, CURLOPT_URL, $url);
		 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		 curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		 curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		 curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		 $tmpInfo = curl_exec($ch);
		 if (curl_errno($ch)) {
		  return curl_error($ch);
		 }
		 curl_close($ch);
		 return $tmpInfo;
	}

	/**
	 * 以post方式提交xml到对应的接口url
	 * 
	 * @param string $xml  需要post的xml数据
	 * @param string $url  url
	 * @param bool $useCert 是否需要证书，默认不需要
	 * @param int $second   url执行超时时间，默认30s
	 * @throws WxPayException
	 */
	private static function postXmlCurl($xml, $url, $useCert = false, $second = 30)
	{		
		$ch = curl_init();
		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		
		//如果有配置代理这里就设置代理
		// if(WSCConfig::CURL_PROXY_HOST != "0.0.0.0" 
		// 	&& WSCConfig::CURL_PROXY_PORT != 0){
		// 	curl_setopt($ch,CURLOPT_PROXY, WSCConfig::CURL_PROXY_HOST);
		// 	curl_setopt($ch,CURLOPT_PROXYPORT, WSCConfig::CURL_PROXY_PORT);
		// }
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
		//设置header
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	
		if($useCert == true){
			//设置证书
			//使用证书：cert 与 key 分别属于两个.pem文件
			curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
			curl_setopt($ch,CURLOPT_SSLCERT, WSCConfig::SSLCERT_PATH);
			curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
			curl_setopt($ch,CURLOPT_SSLKEY, WSCConfig::SSLKEY_PATH);
		}
		//post提交方式
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		//运行curl
		$data = curl_exec($ch);
		//返回结果
		if($data){
			curl_close($ch);
			return $data;
		} else { 
			$error = curl_errno($ch);
			curl_close($ch);
			throw new WSCException("curl出错，错误码:$error");
		}
	}

	/**
	 * 以post方式提交json到对应的接口url
	 * 
	 * @param string $json 需要post的xml数据
	 * @param string $url  url
	 */

	public static function http_post_data($url, $josn) {  
  
        $ch = curl_init();  
        curl_setopt($ch, CURLOPT_POST, 1);  
        curl_setopt($ch, CURLOPT_URL, $url);  
        curl_setopt($ch, CURLOPT_POSTFIELDS, $josn);  
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
            'Content-Type: application/json; charset=utf-8',  
            'Content-Length: ' . strlen($josn))  
        );  
        ob_start();  
        curl_exec($ch);  
        $return_content = ob_get_contents();  
        ob_end_clean();  
  
        $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
        return array($return_code, $return_content);  
    }   
	

	 /*
    *http_post请求 接收返回值 
    */
    public static function http_post_json($data,$url){
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
       curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
       curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
       curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       $tmpInfo = curl_exec($ch);
       if (curl_errno($ch)) {
          return curl_error($ch);
      }
      curl_close($ch);
      return $tmpInfo;
  }


	/**
	 * 获取毫秒级别的时间戳
	 */
	private static function getMillisecond()
	{
		//获取毫秒的时间戳
		$time = explode ( " ", microtime () );
		$time = $time[1] . ($time[0] * 1000);
		$time2 = explode( ".", $time );
		$time = $time2[0];
		return $time;
	}
}

