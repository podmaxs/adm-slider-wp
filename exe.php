<?php
	header('Content-Type: application/json');
	
	// /include_once __DIR__."/../../../wp-blog-header.php";
 	include_once "functions.php";

	class request{
		private $ret=array("data"=>array(),"log"=>"","status"=>"no run");	
		public function __construct(){
			// create_cpts_and_taxonomies("bannerImage"); 
			if(isset($_REQUEST["ACTION"])){
				$action=$_REQUEST["ACTION"]."_void";
				if(method_exists($this, $action))
					$this->$action();
				else
					$this->setReturn(array(),"No existe ".$_REQUEST["ACTION"]);	
			}else{
				$this->setReturn(array(),"No se recibio el methodo ");	
			}
		}

// NEW METHOS

		public function save_slider_void(){
			$current_user = wp_get_current_user();
			if ( 0 == $current_user->ID ) {
				$this->setReturn(array(),"User no logged","error");
			}else{
				$r=file_get_contents('php://input');
				$data=json_decode($r);
				if(isset($data->cont->COD) and $data->cont->COD=="0"){
					$cod=createNewSlider($data->parent,$data->cont->image,$data->cont->name,$data->cont->content,$data->cont->align,$data->cont->order);
				}else{
					$cod=updateSlider($data->cont->COD,$data->cont->image,$data->cont->name,$data->cont->content,$data->cont->align,$data->cont->order);
				}
				if($cod!=0){
					$this->setReturn(array("COD"=>$cod,"data"=>$data),"Se guardo el slider","success");
				}else{
					$this->setReturn(array(),"Error al guardar el slider","error");
				}
			}
		}

		public function add_banner_void(){
			$current_user = wp_get_current_user();
			if ( 0 == $current_user->ID ) {
				$this->setReturn(array(),"User no logged","error");
			}else{
				$r=file_get_contents('php://input');
				$dat=json_decode($r);
				$id=createNewBanner($dat->name);
				if($id>0)
					$this->setReturn(array('ID_BAN'=>$id,'NAME'=>$dat->name),"Se creo el banner","success");
				else
					$this->setReturn(array('COD'=>$id),"No se creo el banner","error");
			}
		}

		public function get_banners_void(){
			$ban=getAllBanners();
			$this->setReturn($ban,"Se listaron lso banners","success");
		}

		public function remove_slider_void(){
			$current_user = wp_get_current_user();
			if ( 0 == $current_user->ID ) {
				$this->setReturn(array(),"User no logged","error");
			}else{
				$r=file_get_contents('php://input');
				$dat=json_decode($r);
				if(isset($dat->ref->COD))
					$cod=removeSlider($dat->ref->COD);
				else
					$cod=false;
				if($cod)
					$this->setReturn(array($dat),"Se elimino el slider","success");
				else
					$this->setReturn(array($dat),"Error al eliminar el slider","error");
			}
		}

		public function remove_ban_void(){
			$current_user = wp_get_current_user();
			if ( 0 == $current_user->ID ) {
				$this->setReturn(array(),"User no logged","error");
			}else{
				$r=file_get_contents('php://input');
				$dat=json_decode($r);
				if(isset($dat->ref->COD))
					$cod=removeBanner($dat->ref->COD);
				else
					$cod=false;
				if($cod)
					$this->setReturn(array($dat),"Se elimino el banner","success");
				else
					$this->setReturn(array($dat,$cod),"Error al eliminar el banner","error");
			}
		}

// NEW METHOS END



/*		public function save_slider_void(){
			$r=file_get_contents('php://input');
			$data=json_decode($r);
			if(isset($data->cont->COD) and $data->cont->COD!="0"){
				$my_post = array(
			      'ID'           =>$data->cont->COD,
			      'post_title'   =>$data->cont->name,
			      'post_type'   =>"slider",
			      'post_content' => serialize($data->cont)
			  	);

				// Update the post into the database
			 	 wp_update_post( $my_post ); 
			}else{
				$my_post = array();
				$my_post['post_title'] = $data->cont->name;
				$my_post['post_content'] = serialize($data->cont);
				$my_post['post_type'] = 'slider';
				$my_post['post_status'] = 'publish';
				$my_post['post_author'] = 1;
				$my_post['post_category'] = array($data->parent);


				// Insert the post into the database
			 	 $post_id=wp_insert_post( $my_post, true );
			 	 wp_set_post_terms( $post_id,$data->parent, 'bannerImage' );
			 	//wp_set_object_terms($ids,$data->parent, 'bannerImage', true);
			}
			$this->get_slider_parent($data->parent);
		}*/


	/*	public function add_banner_void(){
			$r=file_get_contents('php://input');
			$dat=json_decode($r);
			$id=$this->create_banner($dat->name);
			$rid="";
			if( is_wp_error( $id ) )
				$rid= $id->get_error_message();
			else
				$rid=$id["term_id"];
			$this->get_banners_void();
			$dd=$this->ret["data"];
			$this->ret["data"]=array("LASTINSERT"=>$rid,"ALLDATA"=>$dd);
		}*/

/*		public function get_slider_parent($p=0){
			global $wpdb;
			$sliders=$wpdb->get_results("SELECT post.*,wtt.term_taxonomy_id as 'parent' FROM wp_posts as post, wp_term_relationships wtt where post.ID=wtt.object_id and wtt.term_taxonomy_id='$p' and post.post_type='slider' ");
			$ss=array();
			foreach ($sliders as $sl) {
				$data=unserialize($sl->post_content);
				$data->COD=$sl->ID;
				$ss[]=$data;
			}
			$this->setReturn($ss,"Se listaron los sliders ".$p,"success");
		}

		public function get_slider_parent_slug($p=0){
			global $wpdb;
			$sliders=$wpdb->get_results("SELECT post.*,wtt.term_taxonomy_id as 'parent' FROM wp_posts as post left JOIN wp_term_relationships wtt on post.ID=wtt.object_id left join wp_terms wt on wtt.term_taxonomy_id=wt.term_id where wt.slug='$p' and  post.post_type='slider' ");
				$ss=array();
				foreach ($sliders as $sl) {
					$data=unserialize($sl->post_content);
					$data->COD=$sl->ID;
					$ss[]=$data;				
				}
			$this->setReturn($ss,"Se listaron los sliders ".$p,"success");
		}*/
/*
		public function get_banners_void(){
			global $wpdb;
			$banners=$wpdb->get_results("SELECT tems.* FROM wp_terms as tems, wp_term_taxonomy wtt where tems.term_id=wtt.term_id and tems.term_group!='-1' and wtt.taxonomy='bannerImage' ");
			$sliders=$wpdb->get_results("SELECT post.*,wtt.term_taxonomy_id as 'parent' FROM wp_posts as post, wp_term_relationships wtt where post.ID=wtt.object_id and post.post_type='slider' ");
			$ban=array();
			foreach ($banners as $bb) {
				$ss=array();
				foreach ($sliders as $sl) {
					if($sl->parent==$bb->term_id){
						$data=unserialize($sl->post_content);
						//$data["COD"]=$sl->ID;
						$ss[]=$data;
					}
				}
				$ban[]=array("COD"=>$bb->term_id,"name"=>$bb->name,"slug"=>$bb->slug,"sliders"=>$ss);
				}
			$this->setReturn($ban,"Se listaron lso banners","success");
		}*/


		/*private function create_banner($name,$desc="",$parent=0){
			return wp_insert_term($name,'bannerImage',array('description' => $desc,'slug'=>sanitize_title($name),'parent'=>$parent));	
		}*/

	/*	public function remove_ban_void(){
			$r=file_get_contents('php://input');
			$dat=json_decode($r);	
			global $wpdb;
			$wpdb->query("UPDATE wp_terms set term_group='-1' where term_id='$dat->ref'");
			$this->get_banners_void();
		}*/

		public function setReturn($data=array(),$log="",$status="error"){
			$this->ret=array("data"=>$data,"log"=>$log,"status"=>$status);	
		}

		public function __destruct(){
			http_response_code(200);
			echo json_encode($this->ret,JSON_UNESCAPED_UNICODE);
		}
	}


	$exe = new request();
 ?>