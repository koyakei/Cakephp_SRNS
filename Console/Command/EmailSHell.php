<?php
//これが２
App::uses("CakeEmail","Network/Email");

class EmailShell extends AppShell {

    var $uses = array('Email');

    function startup() {}   //空っぽの関数を定義することで起動時の出力を抑制する
    function initialize() {
        parent::initialize();
        $this->_useLogger(false);    //ログの標準出力を禁止
    }
    function main() {
        //これが３
        $email = new CakeEmail("default");
        //これが４
        $email->from(array("koyakeiaaaaa@gmail.com" => "koyakei" ));
        $email->to( "koyakeiaaaaa@hotmail.com");
        $email->subject( "sub" );
        $result = $email->send( "maincontents" );
    }
}