<?php 

/**
* Slider class controller
*/
class slider
{
	private $con;
	public $table="wp_dw_sliders";
	public $table_banner="wp_dw_banners";
	function __construct($c)
	{
		$this->con=$c;
		$this->setTable();
	}

	public function setTable(){
		$this->con->query("
 		CREATE TABLE IF NOT EXISTS `".$this->table."`(
			`ID` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`ID_BAN` int NOT NULL,
			`IMAGE` TEXT NOT NULL,
			`TITLE` TEXT NOT NULL,
			`CONTENT` TEXT NOT NULL,
			`ALIGN` TEXT NOT NULL,
			`MENUORDER` INT NOT NULL,
			`STATE` TEXT NOT NULL,
			`DATE` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
 		);");
		$this->con->query("
 		CREATE TABLE IF NOT EXISTS `".$this->table_banner."` (
			`ID` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`NAME` TEXT NOT NULL,
			`STATE` TEXT NOT NULL,
			`DATE` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
 		);");
	}

	public function add_banner($name=""){
		if($this->con->query("INSERT INTO ".$this->table_banner." (NAME,STATE) VALUES ('$name','publish')")>0)
			return $this->con->insert_id;
		else
			return 0;
	}

	public function get_banners(){
		$r=$this->con->get_results("SELECT a1.ID as 'BAN',a2.ID,a1.NAME,a2.IMAGE,a2.TITLE,a2.CONTENT,a2.ALIGN,a2.MENUORDER,a1.DATE FROM ".$this->table_banner." as a1 left JOIN ".$this->table." as a2 ON a2.ID_BAN=a1.ID WHERE a1.STATE='publish' and (a2.STATE='publish' or a2.STATE IS NULL) ORDER BY a1.ID ");
		if(isset($r[0]->BAN))
			return $this->parseBanners($r);
		else
			return array();
	}

	public function parseBanners($d=array()){
		$ar=array();
		foreach ($d as $line) {
			if(!isset($ar[$line->BAN]))
				$ar[$line->BAN]=new stdClass();
			$ar[$line->BAN]->COD=$line->BAN;
			$ar[$line->BAN]->NAME=$line->NAME;
				if($line->ID!=null){
				if(!isset($ar[$line->BAN]->sliders))
					$ar[$line->BAN]->sliders=array();
				if(!isset($ar[$line->BAN]->sliders[$line->ID]))
					$ar[$line->BAN]->sliders[$line->ID]=new stdClass();
				$ar[$line->BAN]->sliders[$line->ID]->COD=$line->ID;
				$ar[$line->BAN]->sliders[$line->ID]->image=$line->IMAGE;
				$ar[$line->BAN]->sliders[$line->ID]->name=$line->TITLE;
				$ar[$line->BAN]->sliders[$line->ID]->content=$line->CONTENT;
				$ar[$line->BAN]->sliders[$line->ID]->align=$line->ALIGN;
				$ar[$line->BAN]->sliders[$line->ID]->order=$line->MENUORDER;
				$ar[$line->BAN]->sliders[$line->ID]->date=$line->DATE;
			}
		}
		$nar=array();
		foreach ($ar as $key => $value) {
			if(isset($ar[$key]->sliders)){
				$sd=array();
				foreach ($ar[$key]->sliders as $key2 => $v2) {
					$sd[]=$ar[$key]->sliders[$key2];
				}
				$ar[$key]->sliders=$sd;	
			}
			$nar[]=$ar[$key];
		}
		$ar=$nar;

		return $ar;
	}

	public function change_state($ID_BAN=0,$STATE='delete'){
		return $this->con->query("UPDATE ".$this->table_banner." set STATE='$STATE' WHERE ID='$ID_BAN' and STATE='publish' ");
	}

	public function addSlider($ID_BAN=0,$image="",$title="",$content="",$align="center",$order=0,$state='publish'){
		if($this->con->query("INSERT INTO ".$this->table." (`ID_BAN`,`IMAGE`,`TITLE`,`CONTENT`,`ALIGN`,`MENUORDER`,`STATE`) VALUES ('$ID_BAN','".$this->con->_real_escape($image)."','".$this->con->_real_escape($title)."','".$this->con->_real_escape($content)."','".$this->con->_real_escape($align)."','".$this->con->_real_escape($order)."','$state') ")>0)
			return $this->con->insert_id;
		else
			return 0;
	}

	public function remove_slider($ID_SLIDER=0,$state='delete'){
		return $this->con->query("UPDATE ".$this->table." SET STATE='$state' WHERE ID='$ID_SLIDER' and STATE='publish' ");
	}

	public function update_slider($ID_SLIDER=0,$image="",$title="",$content="",$align="center",$order=0){
		if($this->con->query("UPDATE ".$this->table." SET IMAGE='".$this->con->_real_escape($image)."',TITLE='".$this->con->_real_escape($title)."',CONTENT='".$this->con->_real_escape($content)."',ALIGN='".$this->con->_real_escape($align)."',MENUORDER='".$this->con->_real_escape($order)."' WHERE ID='$ID_SLIDER' and STATE='publish' ")>0)
			return $ID_SLIDER;
		else
			return 0;
	}

	

}
 ?>