<?php


if (!function_exists(evar_dump)) {
function evar_dump( $object=null ){
    ob_start();                    // start buffer capture
    var_dump( $object );           // dump the values
    $contents = ob_get_contents(); // put the buffer into a variable
    ob_end_clean();                // end capture
    error_log( $contents );        // log contents of the result of var_dump( $object )
}
}



function do_entry_x($new_content, $entry, $shortcodes, $display, $show, $odd, $atts){

    // $new_content = '14 5 [entry_x 3] hello [/entry_x] 6 7';
    // $atts['count'] = 4;
    // replace all unneded spaces

    $entryx = '[/entry_x]';

    $new_content = preg_replace('/\[\/entry_x\ +\]/', '[/entry_x]', $new_content);

    evar_dump($new_content);

    $start = 0;
    $my = '';
    while (True) {
        $pos = strpos($new_content, $entryx);
        if (!$pos) break;



        // now get substring and process it
        $sub = substr($new_content, 0, $pos+strlen($entryx));
        $array = preg_match('/\[entry_x[\ ]*\](.*)\[\/entry_x\]/', $sub, $mat);

        // split content - then we will get substitutions and total count
        $substitutions = split('\$', $mat[1]);
        $subs_count = count($substitutions);


                $sc_content = $substitutions[ ($atts['count']-1) % $subs_count ] ;
                
                $sub = preg_replace( '/(\[entry_x.*\[\/entry_x\])/', $sc_content, $sub);

                // now glue new sub and old content
                $new_content = $sub. substr($new_content, $pos+strlen($entryx));

    }
    evar_dump($new_content);
    return $new_content;

}


class EntryxController{
    function __construct(){
        add_action( 'init', 'EntryxController::load_hooks', 10 );
        // add_action( 'admin_init', 'FrmSigAppController::include_updater', 1 );
        // add_action('after_setup_theme', 'FrmCronAppController::addMyHooks');
    }



    public static function load_hooks(){
        add_filter('frm_display_entry_content', 'do_entry_x', 20, 7);



    }



    public static function path(){
        return WP_PLUGIN_DIR .'/formidable-entryx';
    }


}