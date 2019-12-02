<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Http\Request;
use Fukuball\Jieba\Jieba;
use Fukuball\Jieba\Finalseg;
use Fukuball\Jieba\JiebaAnalyse;
use Fukuball\Jieba\Posseg;

Route::get('/', function () {
    return view('welcome');
});

Route::post('segment', function (Request $request) {
    ini_set('memory_limit', '1024M');

    $input = $request->all();

    $this->jieba = new Jieba();
    $this->finalseg = new Finalseg();

    $strGbk = iconv("UTF-8", "GBK//IGNORE", $input['string']);
    $strGb2312 = iconv("UTF-8", "GB2312//IGNORE", $input['string']);
    if ($strGbk == $strGb2312) {
        $this->jieba->init();
    } else {
        $this->jieba->init(['mode'=>'default','dict'=>'big']);
    }

    $this->finalseg->init();

    return ['data' => $this->jieba->cut($input['string'])];
});

Route::post('keyword', function (Request $request) {
    ini_set('memory_limit', '1024M');

    $input = $request->all();

    $this->jieba = new Jieba();
    $this->finalseg = new Finalseg();

    $strGbk = iconv("UTF-8", "GBK//IGNORE", $input['string']);
    $strGb2312 = iconv("UTF-8", "GB2312//IGNORE", $input['string']);
    if ($strGbk == $strGb2312) {
        $this->jieba->init();
    } else {
        $this->jieba->init(['mode'=>'default','dict'=>'big']);
    }

    $this->finalseg->init();
    $res = JiebaAnalyse::extractTags($input['string'], 10);
    $result = [];
    foreach ($res as $key => $value) {
        $result[] = $key;
    }

    return ['data' => $result];
});
