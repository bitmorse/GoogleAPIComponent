<?php
App::uses('Component', 'Controller');

//your developer key here (or move this line to bootstrap.php)
Configure::write('Google.developer_key','');

class GoogleAPIComponent extends Component {

    public function Translate($source, $target, $text) {
        
        $api_key = Configure::read('Google.developer_key');
        $url = 'https://www.googleapis.com/language/translate/v2?key='.$api_key.'&source='.$source.'&target='.$target;
        $datastring = 'q='.urlencode(utf8_encode($text));

        //caching config: keep the translations for a week
        Cache::config('googleTranslate', array(
            'engine' => 'File',
            'duration' => '+1 week',
            'probability' => 100,
            'path' => CACHE . 'googleTranslate' . DS,
        ));


        //check if the text is in cache
        $cached_result = Cache::read(md5($text), 'googleTranslate');

        if($cached_result){
            $result = $cached_result;
        }else{
            //query the google api for the translation

            //open connection
            $ch = curl_init();

            //set the url, number of POST vars, POST data
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $datastring);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-HTTP-Method-Override: GET'));

            //execute post
            $result = curl_exec($ch);

            //close connection
            curl_close($ch);

            //cache the result
            Cache::write(md5($text), $result, 'googleTranslate');
        } 


        //return as array
        return json_decode($result, 1);
    }
    
}
