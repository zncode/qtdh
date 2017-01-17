<?php
namespace Portal\Controller;
use Common\Controller\HomebaseController; 


/**
 * 首页
 */
class IndexController extends HomebaseController {
	
    //首页
	public function index() {
		$modelTerms = D('Terms');
		$modelPosts = D('Posts');

		//新闻
		$newsTermId = $modelTerms->getTermID('新闻');
		$news 		= $modelPosts->getPosts($termId);

		$this->assign('news', $news);
    	$this->display(":index");
    }

}


