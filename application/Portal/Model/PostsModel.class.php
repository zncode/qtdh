<?php
namespace Portal\Model;

use Common\Model\CommonModel;

class PostsModel extends CommonModel {
    
    //自动验证
    protected $_validate = array(
        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
        array('post_title', 'require', '标题不能为空！', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );
    
	protected $_auto = array (
		array('post_date', 'mGetDate', self::MODEL_INSERT, 'callback' ),
		array('post_modified', 'mGetDate',self::MODEL_BOTH, 'callback' ) 
	);
	
	// 获取当前时间
	public function mGetDate() {
		return date( 'Y-m-d H:i:s' );
	}
	
	protected function _before_write(&$data) {
		parent::_before_write($data);
	}

	public function getPosts($tid){
		$news = sp_sql_posts_bycatid($termId,'order: posts.id desc,10',array('recommended'=>1));
		if($news){
			foreach($news as $key => $new){
				$smeta = json_decode($new['smeta']);
				$photos = $smeta->photo;
				
				if($photos){
					foreach($photos as $k => $photo){
						$photo->url = sp_get_file_download_url($photo->url);
						$photos[$k] = $photo;
					}
				}else{
					$photos = false;
				}
				$news[$key]['thumb'] = sp_get_file_download_url($smeta->thumb);
				$news[$key]['photo'] = $photos;	
			}
			
			return $news;
		}else{
			return false;
		}
	}
}