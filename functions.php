<?php 
    require_once 'libs/class.sliders.php';
    global $wpdb;
    $sdw=new slider($wpdb);

     function create_cpts_and_taxonomies($namet) {
        $args = array( 
            'hierarchical'                      => true,  
            'labels' => array(
                'name'                          => _x($namet, 'taxonomy general name' ),
                'singular_name'                 => _x($namet, 'taxonomy singular name'),
                'search_items'                  => __('Search '.$namet),
                'popular_items'                 => __('Popular '.$namet),
                'all_items'                     => __('All '.$namet),
                'edit_item'                     => __('Edit '.$namet),
                'edit_item'                     => __('Edit '.$namet),
                'update_item'                   => __('Update '.$namet),
                'add_new_item'                  => __('Add New '.$namet),
                'new_item_name'                 => __('New Test '.$namet),
                'separate_items_with_commas'    => __('Seperate '.$namet.'with Commas'),
                'add_or_remove_items'           => __('Add or Remove '.$namet),
                'choose_from_most_used'         => __('Choose from Most Used '.$namet)
            ),  
            'query_var'                         => true,  
            'rewrite'                           => array('slug' =>sanitize_title($namet))        
        );
        register_taxonomy( $namet, array( 'sliders' ), $args );
    }

    function get_data_slider_obj($slug=""){
        return array("hola mundo");
    }


    function createNewSlider($ID_BAN=0,$image="",$title="",$content="",$align="center",$order=0){
        global $sdw;
        return $sdw->addSlider($ID_BAN,$image,$title,$content,$align,$order);
    }

    function updateSlider($ID_SLIDER=0,$image="",$title="",$content="",$align="center",$order=0){
        global $sdw;
        return $sdw->update_slider($ID_SLIDER,$image,$title,$content,$align,$order);
    }

    function createNewBanner($NAME=""){
        global $sdw;
        return $sdw->add_banner($NAME);
    }

    function getAllBanners(){
        global $sdw;
        return $sdw->get_banners();
    }

    function removeSlider($ID=0){
        global $sdw;
        return $sdw->remove_slider($ID);
    }

    function removeBanner($id=0){
        global $sdw;
        return $sdw->change_state($id);
    }




 ?>
