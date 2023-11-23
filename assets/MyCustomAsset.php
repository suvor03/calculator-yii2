<?php

namespace app\assets;

use yii\web\AssetBundle;

class MyCustomAsset extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
		'https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css',
	];
	public $js = [
		'https://cdn.jsdelivr.net/npm/vue@2.7.14/dist/vue.js',
		'js/app.js'
	];

}