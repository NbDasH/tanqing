﻿<?php
	

    /**
     * Created by JetBrains PhpStorm.
     * User: taoqili
     * Date: 12-7-18
     * Time: 上午10:42
    */
	
	/*az 2013-12-7 遇到了一个莫名其妙的问题，百度编辑器上传图片，按不了确定，结果，注释这行，问题解决
    header("Content-Type: text/html; charset=utf-8");
	*/
    error_reporting(E_ERROR | E_WARNING);
    date_default_timezone_set("Asia/chongqing");
    include "Uploader.class.php";
    //上传图片框中的描述表单名称，
    $title = htmlspecialchars($_POST['pictitle'], ENT_QUOTES);
    $path = htmlspecialchars($_POST['dir'], ENT_QUOTES);

    //上传配置
    $config = array(
        "savePath" => ($path == "1" ? "upload/" : "upload1/"),
        "maxSize" => 10000, //单位KB
        "allowFiles" => array(".gif", ".png", ".jpg", ".jpeg", ".bmp")
    );

    //生成上传实例对象并完成上传
    $up = new Uploader("upfile", $config);
	
	

    /**
     * 得到上传文件所对应的各个参数,数组结构
     * array(
     *     "originalName" => "",   //原始文件名
     *     "name" => "",           //新文件名
     *     "url" => "",            //返回的地址
     *     "size" => "",           //文件大小
     *     "type" => "" ,          //文件类型
     *     "state" => ""           //上传状态，上传成功时必须返回"SUCCESS"
     * )
     */
    $info = $up->getFileInfo();
	
	

    /**
     * 向浏览器返回数据json数据
     * {
     *   'url'      :'a.jpg',   //保存后的文件路径
     *   'title'    :'hello',   //文件描述，对图片来说在前端会添加到title属性上
     *   'original' :'b.jpg',   //原始文件名
     *   'state'    :'SUCCESS'  //上传状态，成功时返回SUCCESS,其他任何值将原样返回至图片上传框中
     * }
     */
	 $title = substr($title,0,-4);
	 if(strlen($title) > 50){
		$title = substr($title,0,50); 
	 }
	 
    echo "{'url':'" . $info["url"] . "','title':'" . $title . "','original':'" . $info["originalName"] . "','state':'" . $info["state"] . "'}";
	
	require_once('resizeimage.php');
	
	$url_arr = explode('.',$info["url"]);
	new resizeimage($info["url"], "680", "1", "0",$url_arr[0].'_small.'.$url_arr[1]);
	new resizeimage($info["url"], "320", "1", "0",$url_arr[0].'_phone.'.$url_arr[1]);

