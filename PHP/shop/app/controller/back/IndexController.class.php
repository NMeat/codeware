<?php
header("content-type:text/html;charset=utf-8");

class IndexController extends BackPlatformController{

	public function indexAction(){
		require CURRENT_VIEW_DIR . 'index.html';
	}
	public function topAction(){
		require CURRENT_VIEW_DIR . 'header.html';
	}
	public function menuAction(){
		require CURRENT_VIEW_DIR . 'menu.html';
	}
	public function dragAction(){
		require CURRENT_VIEW_DIR . "drag.html";
	}
	public function mainAction(){
		require CURRENT_VIEW_DIR . 'main.html';
	}
}