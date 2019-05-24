<?php 

 if( !defined( 'ABSPATH' ) ) exit;

function debug($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

function list_sites() {

    $id_now = get_current_blog_id();
    echo '<h2> ID subsitio </h2>';
    debug($id_now);


    $blog_list = get_sites();
    if (count($blog_list) > 1):
        foreach ($blog_list AS $blog) {
            if( $id_now == $blog->blog_id):
                debug($blog->blog_id);
                $str_subd = $blog->domain;
                $subdomain = explode('.', $str_subd, 2);
                debug($subdomain[0]);
                echo '<br>';
            endif;
            
        }
    endif;
}

function now_site() {
    $id_now = get_current_blog_id();
    $blog_now = get_sites();
    if (count($blog_now) > 1):
        foreach ($blog_now AS $blog) {
            if( $id_now == $blog->blog_id):
             //   debug($blog->blog_id);
                $str_subd = $blog->domain;
                $subdomain = explode('.', $str_subd, 2);
              //  debug($subdomain[0]);
                // debug($blog);
                return $subdomain[0];
            endif;
            
        }
    endif;
}