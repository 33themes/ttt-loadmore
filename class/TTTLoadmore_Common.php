<?php

class TTTLoadmore_Common {

    const sname = 'tttloadmore';

	public function init() {
        $this->ajax();
    }

    public function ajax() {

		wp_enqueue_script( 'ttt-loadmore-js', plugins_url('template/front/js/loadmore.js' , dirname(__FILE__) ), array('jquery')  );

		$_admin_url = admin_url( 'admin-ajax.php' );
    	$_admin_url = preg_replace('/^(http|https)\:/','', $_admin_url);
    	
		wp_localize_script('ttt-loadmore-js', 'tttloadmoreConf',array(
			'ajax' => $_admin_url,
			'Nonce' => wp_create_nonce( 'ttt-loadmore-nonce' ),
		));
        
		add_action('wp_ajax_ttt-loadmore', array( &$this, 'loadmore' ) );
		add_action('wp_ajax_nopriv_ttt-loadmore', array( &$this, 'loadmore' ) );
    }

	public function _header_callback() {
		header("Content-Type: text/plain; charset=utf-8", true);
		header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
	}
	
	public function loadmore() {
        //do_action('init');
		$this->_header_callback();

        if (!preg_match('/^[a-zA-Z0-9]+$/',$_REQUEST['ndo'])) return false;
        if (!preg_match('/^[0-9]+$/',$_REQUEST['page'])) return false;
        
        $_args = array(
            'post_status' => 'publish'
        );
        
        if (isset($_REQUEST['args'])) {
            $l = preg_split('/;\s*/',$_REQUEST['args']);
            if (count($l) > 0) {
                foreach($l as $key) {
                    //preg_match('/^([^\:]+):\[\"\']*([^\"\'\;]+)\[\"\']*;$/',$key,$regs);
                    preg_match('/^([^\:]+):[\"\']*([^;]+)[\"\']*;*$/',$key,$regs);
                    $_args[ $regs[1] ] = $regs[2];
                }
            }
            unset($_args[""]);
        }

        if (isset($_args['post__not_in']))
            $_args['post__not_in'] = split(',',$_args['post__not_in']);

        do_action('ttt_loadmore_'.$_REQUEST['ndo'], (int) $_REQUEST['page'], $_args );


		die();
	}


	public function _s( $s = false ) {
		if ( $s === false) return self::name;
		return self::sname.'_'.$s;
	}
	
	public function del( $name ) {
		return delete_option( self::sname . '_' . $name );
	}
	
	public function get( $name ) {
		return get_option( self::sname . '_' . $name );
	}
	
	public function set( $name, $value ) {
		if (!get_option( self::sname . '_' . $name ))
			add_option( self::sname . '_' . $name, $value);
		
		update_option( self::sname . '_' . $name , $value);
	}

}
