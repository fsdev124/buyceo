<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php


//////////////////////////////////////////////////////////////////
// Check plugin active
//////////////////////////////////////////////////////////////////
function rh_is_plugin_active( $plugin ) {
    return in_array( $plugin, (array) get_option( 'active_plugins', array() ) ) || rh_is_plugin_active_for_network( $plugin );
}
function rh_is_plugin_active_for_network( $plugin ) {
    if ( !is_multisite() )
        return false;
    $plugins = get_site_option( 'active_sitewide_plugins');
    if ( isset($plugins[$plugin]) )
        return true;
    return false;
}

//////////////////////////////////////////////////////////////////
// Locate template with support RH grandchild
//////////////////////////////////////////////////////////////////
function rh_locate_template($template_names, $load = false, $require_once = true ) {
    $located = '';
    foreach ( (array) $template_names as $template_name ) {
        if ( !$template_name )
            continue;
        if(defined( 'RH_GRANDCHILD_DIR' ) && file_exists(RH_GRANDCHILD_DIR . $template_name)){
            $located = RH_GRANDCHILD_DIR . '/' . $template_name;
            break;            
        }
        if ( file_exists(STYLESHEETPATH . '/' . $template_name)) {
            $located = STYLESHEETPATH . '/' . $template_name;
            break;
        } elseif ( file_exists(TEMPLATEPATH . '/' . $template_name) ) {
            $located = TEMPLATEPATH . '/' . $template_name;
            break;
        }
    } 
    if ( $load && '' != $located )
        load_template( $located, $require_once );
      
    return $located;
}

//////////////////////////////////////////////////////////////////
// Helper Functions
//////////////////////////////////////////////////////////////////
function rehub_kses($html)
{
    $allow = array_merge(wp_kses_allowed_html( 'post' ), array(
        'link' => array(
            'href'    => true,
            'rel'     => true,
            'type'    => true,
        ),
        'script' => array(
            'src' => true,
            'charset' => true,
            'type'    => true,
        ),
        'div' => array(
            'data-href' => true,
            'data-width' => true,
            'data-numposts'    => true,
            'data-colorscheme'    => true,
            'class' => true,
            'id' => true,
            'style' => true,
            'title' => true,
            'role' => true,
            'align' => true,
            'dir' => true,
            'lang' => true,
            'xml:lang' => true,         
        )
    ));
    return wp_kses($html, $allow);
}

//////////////////////////////////////////////////////////////////
// EXCERPT
//////////////////////////////////////////////////////////////////

if( !function_exists('kama_excerpt') ) {
function kama_excerpt($args=''){
    global $post;
        parse_str($args, $i);
        $maxchar     = isset($i['maxchar']) ?  (int)trim($i['maxchar'])     : 350;
        $text        = isset($i['text']) ?          trim($i['text'])        : '';
        $save_format = isset($i['save_format']) ?   trim($i['save_format'])         : false;
        $echo        = isset($i['echo']) ?          false                   : true;
        $more        = isset($i['more']) ?          true                   : false;        

    $out ='';   
    if (!$text){
        $out = $post->post_excerpt ? $post->post_excerpt : $post->post_content;
        $out = preg_replace ("~\[/?.*?\]~", '', $out ); //delete shortcodes:[singlepic id=3]
        // for <!--more-->
        if($more && !$post->post_excerpt && strpos($post->post_content, '<!--more-->') ){
          preg_match ('/(.*)<!--more-->/s', $out, $match);
          $out = str_replace("\r", '', trim($match[1], "\n"));
          $out = preg_replace( "!\n\n+!s", "</p><p>", $out );
          $out = "<p>". str_replace( "\n", "<br />", $out ) ."</p>";
          if ($echo)
              return print $out;
          return $out;
        }
    }

    $out = $text.$out;
    if (!$post->post_excerpt)
        $out = strip_tags($out, $save_format);

    if ( mb_strlen( $out ) > $maxchar ){
        $out = mb_substr( $out, 0, $maxchar );
        $out = preg_replace('@(.*)\s[^\s]*$@s', '\\1 ...', $out ); // убираем последнее слово, оно 99% неполное
    }   

    if($save_format){
        $out = str_replace( "\r", '', $out );
        $out = preg_replace( "!\n\n+!", "</p><p>", $out );
        $out = "<p>". str_replace ( "\n", "<br />", trim($out) ) ."</p>";
    }

    if($echo) return print $out;
    return $out;
}
}

// Create the Custom Truncate
if( !function_exists('rehub_truncate') ) {
function rehub_truncate($args=''){
        parse_str($args, $i);
        $maxchar     = isset($i['maxchar']) ?  (int)trim($i['maxchar'])     : 350;
        $text        = isset($i['text']) ?          trim($i['text'])        : '';
        $save_format = isset($i['save_format']) ?   trim($i['save_format'])         : false;
        $echo        = isset($i['echo']) ?          false                   : true;

    $out ='';   

    $out = $text.$out;
    $out = preg_replace ("~\[/?.*?\]~", '', $out );
    $out = strip_tags(strip_shortcodes($out));

    if ( mb_strlen( $out ) > $maxchar ){
        $out = mb_substr( $out, 0, $maxchar );
        $out = preg_replace('@(.*)\s[^\s]*$@s', '\\1 ...', $out ); // убираем последнее слово, оно 99% неполное
    }   

    if($save_format){
        $out = str_replace( "\r", '', $out );
        $out = preg_replace( "!\n\n+!", "</p><p>", $out );
        $out = "<p>". str_replace ( "\n", "<br />", trim($out) ) ."</p>";
    }

    if($echo) return print $out;
    return $out;
}
}


//////////////////////////////////////////////////////////////////
// Pagination
//////////////////////////////////////////////////////////////////

if( !function_exists('rehub_pagination') ) {
function rehub_pagination() {

    if( is_singular() )
        return;
    global $paged;
    global $wp_query;

    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );

    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;

    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<ul class="page-numbers">' . "\n";

    /** Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li class="prev_paginate_link">%s</li>' . "\n", get_previous_posts_link() );

    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';

        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

        if ( ! in_array( 2, $links ) )
            echo '<li class="hellip_paginate_link">&hellip;</li>';
    }

    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }

    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li class="hellip_paginate_link">&hellip;</li>' . "\n";

        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }

    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li class="next_paginate_link">%s</li>' . "\n", get_next_posts_link() );

    echo '</ul>' . "\n";

}
}

//////////////////////////////////////////////////////////////////
// Breadcrumbs
//////////////////////////////////////////////////////////////////

if( !function_exists('dimox_breadcrumbs') ) {
function dimox_breadcrumbs() {

  /* === OPTIONS === */
  $text['home'] = __('Home', 'rehub_framework');
  $text['category'] = __('Archive category "%s"', 'rehub_framework');
  $text['search'] = __('Search results for "%s"', 'rehub_framework');
  $text['tag'] = __('Posts with tag "%s"', 'rehub_framework');
  $text['author'] = __('Author archive "%s"', 'rehub_framework');
  $text['404'] = __('Error 404', 'rehub_framework');

  $show_current = 1; // 1 - show current name of article
  $show_on_home = 0; 
  $show_home_link = 1; // 1 - show link to Home page
  $show_title = 1; // 1 - show titles for links
  $delimiter = ' &raquo; '; // delimiter
  $before = '<span class="current">'; // tag before current 
  $after = '</span>'; // tag after current

  global $post;
  $home_link = home_url('/');
  $link_before = '<span typeof="v:Breadcrumb">';
  $link_after = '</span>';
  $link_attr = ' rel="v:url" property="v:title"';
  $link = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
  $parent_id = $parent_id_2 = $post->post_parent;
  $frontpage_id = get_option('page_on_front');

  if (is_home() || is_front_page()) {

    if ($show_on_home == 1) echo '<div class="breadcrumb"><a href="' . $home_link . '">' . $text['home'] . '</a></div>';

  } else {
    echo '<div class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#">';
    if ($show_home_link == 1) {
      echo '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $text['home'] . '</a>';
      if ($frontpage_id == 0 || $parent_id != $frontpage_id) echo $delimiter;
    }
    if ( is_category() ) {
      $this_cat = get_category(get_query_var('cat'), false);
      if ($this_cat->parent != 0) {
        $cats = get_category_parents($this_cat->parent, TRUE, $delimiter);
        if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
        $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
        $cats = str_replace('</a>', '</a>' . $link_after, $cats);
        if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
        echo $cats;
      }
      if ($show_current == 1) echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;
    } elseif ( is_search() ) {
      echo $before . sprintf($text['search'], get_search_query()) . $after;
    } elseif ( is_day() ) {
      echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
      echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
      echo $before . get_the_time('d') . $after;
    } elseif ( is_month() ) {
      echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
      echo $before . get_the_time('F') . $after;
    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;
    } elseif ( is_single() && !is_attachment() ) {
        if ( get_post_type() != 'post' ) {
            $post_type = get_post_type_object(get_post_type());
            $slug = $post_type->rewrite;
            printf($link, $home_link . $slug['slug'] . '/', $post_type->labels->singular_name);
            if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;
        } else {
            $cat = get_the_category();
            if(!empty($cat)){ 
            $cat = $cat[0];
            $cats = get_category_parents($cat, TRUE, $delimiter);
            if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
            $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
            $cats = str_replace('</a>', '</a>' . $link_after, $cats);
            if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
            echo $cats;
            if ($show_current == 1) echo $before . get_the_title() . $after;
            }
        }
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;
    } elseif ( is_attachment() ) {
      $parent = get_post($parent_id);
      $cat = get_the_category($parent->ID); $cat = (!empty($cat[0])) ? $cat[0] : '';
      if ($cat) {
        $cats = get_category_parents($cat, TRUE, $delimiter);
        $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
        $cats = str_replace('</a>', '</a>' . $link_after, $cats);
        if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
        echo $cats;
      }
      printf($link, get_permalink($parent), $parent->post_title);
      if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;

    } elseif ( is_page() && !$parent_id ) {
      if ($show_current == 1) echo $before . get_the_title() . $after;
    } elseif ( is_page() && $parent_id ) {
      if ($parent_id != $frontpage_id) {
        $breadcrumbs = array();
        while ($parent_id) {
          $page = get_page($parent_id);
          if ($parent_id != $frontpage_id) {
            $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
          }
          $parent_id = $page->post_parent;
        }
        $breadcrumbs = array_reverse($breadcrumbs);
        for ($i = 0; $i < count($breadcrumbs); $i++) {
          echo $breadcrumbs[$i];
          if ($i != count($breadcrumbs)-1) echo $delimiter;
        }
      }
      if ($show_current == 1) {
        if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) echo $delimiter;
        echo $before . get_the_title() . $after;
      }
    } elseif ( is_tag() ) {
      echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
    } elseif ( is_author() ) {
        global $author;
      $userdata = get_userdata($author);
      echo $before . sprintf($text['author'], $userdata->display_name) . $after;
    } elseif ( is_404() ) {
      echo $before . $text['404'] . $after;
    } elseif ( has_post_format() && !is_singular() ) {
      echo get_post_format_string( get_post_format() );
    }
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo 'Страница ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
    echo '</div><!-- .breadcrumbs -->';
  }
} // end dimox_breadcrumbs()
}


/** Autocontents class
 * Taken from: wp-kama.ru/?p=1513
 * V: 2.9.4
 */
class Kama_Contents{    
    // defaults options
    public $opt = array(
        'margin'     => 40,
        'selectors'  => array('h2','h3','h4'),
        'to_menu'    => '↑',
        'title'      => '',
        'css'        => '',
        'min_found'  => 2,
        'min_length' => 1500,
        'page_url'   => '',
        'shortcode'  => 'contents',
        'spec'       => '\'.+$*~=',
        'wrap'       => '',
        'tag_inside' => '',
        // Какой тип анкора использовать: 'a' - <a name="anchor"></a> или 'id' - 
        'anchor_type' => 'a',
    );

    public $contents; // collect html contents

    private $temp;

    static $inst;

    function __construct( $args = array() ){
        $this->set_opt( $args );
        return $this;
    }

    static function init( $args = array() ){
        is_null( self::$inst ) && self::$inst = new self( $args );
        //if( $args ) self::$inst->set_opt( $args ); // ! NO
        return self::$inst;
    }

    function set_opt( $args = array() ){
        $this->opt = (object) array_merge( $this->opt, (array) $args );
    }

    function shortcode( $content, $contents_cb = '' ){
        if( false === strpos( $content, '['. $this->opt->shortcode ) ) 
            return $content; 

        // get contents data
        if( ! preg_match('~^(.*)\['. $this->opt->shortcode .'([^\]]*)\](.*)$~s', $content, $m ) )
            return $content;

        $contents = $this->make_contents( $m[3], $m[2] );

        if( $contents && $contents_cb && is_callable($contents_cb) )
            $contents = $contents_cb( $contents );

        return $m[1] . $contents . $m[3];
    }

    function make_contents( & $content, $tags = '' ){

        //if( mb_strlen( strip_tags($content) ) < $this->opt->min_length ) return;

        $this->temp     = $this->opt;
        $this->temp->i  = 0;
        $this->contents = array();

        if( is_string($tags) && $tags = trim($tags) )
            $tags = array_map('trim', preg_split('~\s+~', $tags ) );

        if( ! $tags )
            $tags = $this->opt->selectors;

        // check tags
        foreach( $tags as $k => $tag ){
            // remove special marker tags and set $args
            if( in_array( $tag, array('embed','no_to_menu') ) ){
                if( $tag == 'embed' ) $this->temp->embed = true;
                if( $tag == 'no_to_menu' ) $this->opt->to_menu = false;

                unset( $tags[ $k ] );
                continue;
            }

            // remove tag if it's not exists in content
            $patt = ( ($tag[0] == '.') ? 'class=[\'"][^\'"]*'. substr($tag, 1) : "<$tag" );
            if( ! preg_match("/$patt/i", $content ) ){
                unset( $tags[ $k ] );
                continue;
            }
        }

        if( ! $tags ) return;

        // set patterns from given $tags
        // separate classes & tags & set
        $class_patt = $tag_patt = $level_tags = array();
        foreach( $tags as $tag ){
            // class
            if( $tag{0} == '.' ){
                $tag  = substr( $tag, 1 );
                $link = & $class_patt;
            }
            // html tag
            else
                $link = & $tag_patt;

            $link[] = $tag;         
            $level_tags[] = $tag;
        }

        $this->temp->level_tags = array_flip( $level_tags );

        $patt_in = array();
        if( $tag_patt )   $patt_in[] = '(?:<('. implode('|', $tag_patt) .')([^>]*)>(.*?)<\/\1>)';
        if( $class_patt ) $patt_in[] = '(?:<([^ >]+) ([^>]*class=["\'][^>]*('. implode('|', $class_patt) .')[^>]*["\'][^>]*)>(.*?)<\/'. ($patt_in?'\4':'\1') .'>)';

        $patt_in = implode('|', $patt_in );

        // collect and replace
        $_content = preg_replace_callback("/$patt_in/is", array( &$this, 'kama_rh_contents_callback'), $content, -1, $count );

        if( ! $count || $count < $this->opt->min_found )
            return;

        $content = $_content; // опять работаем с важной $content
        // html
        static $css;
        $embed = !! isset($this->temp->embed);
        $this->contents = 
            ( ( $this->opt->wrap ) ? '<div id="'.$this->opt->wrap.'">' : '' ) .
            ( ( !$embed && $this->opt->title ) ? '<div class="kc__wrap">' : '' ) .
            ( ( ! $css && $this->opt->css )    ? '<style>'. $this->opt->css .'</style>' : '' ) .
            ( ( !$embed && $this->opt->title ) ? '<div class="kc-title kc__title" id="kcmenu">'. $this->opt->title .'</div>'. "\n" : '' ) .
                '<ul class="autocontents"'. ((!$this->opt->title || $embed) ? ' id="kcmenu"' : '') .'>'. "\n". 
                    implode('', $this->contents ) .
                '</ul>'."\n" .
            ( ( !$embed && $this->opt->title ) ? '</div>' : '' ).
            ( ( $this->opt->wrap ) ? '</div>' : '' );

        return $this->contents;
    }

    private function kama_rh_contents_callback( $match ){
        // it's only class selector in pattern
        if( count($match) == 5 ){
            $tag   = $match[1];
            $attrs = $match[2];
            $title = $match[4];

            $level_tag = $match[3]; // class_name
        }
        // it's found tag selector
        elseif( count($match) == 4 ){
            $tag   = $match[1];
            $attrs = $match[2];
            $title = $match[3];

            $level_tag = $tag;
        }
        // it's found class selector
        else{
            $tag   = $match[4];
            $attrs = $match[5];
            $title = $match[7];

            $level_tag = $match[6]; // class_name
        }

        $anchor = $this->kama_rh_sanitize_anchor( $title );
        $opt = & $this->opt;

        $level = @ $this->temp->level_tags[ $level_tag ];
        if( $level > 0 )
            $sub = ( $opt->margin ? ' style="margin-left:'. ($level*$opt->margin) .'px;"' : '') . ' class="sub sub_'. $level .'"';
        else 
            $sub = ' class="top"';

        // собираем оглавление
        $this->contents[] = "\t". '<li'. $sub .'><a href="'. $opt->page_url .'#'. $anchor .'">'. $title .'</a></li>'. "\n";

        // заменяем
        $to_menu = $new_el = '';
        if( $opt->to_menu )
            $to_menu = (++$this->temp->i == 1) ? '' : '<a class="kc-gotop kc__gotop" href="'. $opt->page_url .'#kcmenu">'. $opt->to_menu .'</a>';

        $tag_inside_head = ( $opt->tag_inside) ? ' class="'.$opt->tag_inside.'"' : '';
        $new_el = "\n<$tag id=\"$anchor\" $tag_inside_head $attrs>$title</$tag>";
        if( $opt->anchor_type == 'a' )
            $new_el = '<a class="kc-anchor kc__anchor" name="'. $anchor .'"></a>'."\n<$tag $attrs>$title</$tag>";

        return $to_menu . $new_el;
    }

    ## Транслитерация УРЛ
    private function kama_rh_sanitize_anchor( $str ){
        $str = strip_tags( $str );

        $iso9 = array(
            'А'=>'A', 'Б'=>'B', 'В'=>'V', 'Г'=>'G', 'Д'=>'D', 'Е'=>'E', 'Ё'=>'YO', 'Ж'=>'ZH',
            'З'=>'Z', 'И'=>'I', 'Й'=>'J', 'К'=>'K', 'Л'=>'L', 'М'=>'M', 'Н'=>'N', 'О'=>'O',
            'П'=>'P', 'Р'=>'R', 'С'=>'S', 'Т'=>'T', 'У'=>'U', 'Ф'=>'F', 'Х'=>'H', 'Ц'=>'TS',
            'Ч'=>'CH', 'Ш'=>'SH', 'Щ'=>'SHH', 'Ъ'=>'', 'Ы'=>'Y', 'Ь'=>'', 'Э'=>'E', 'Ю'=>'YU', 'Я'=>'YA', 'Č' => 'C', 'Š' => 'S', 'Ř' => 'R', 'Ď' => 'D', 'Ň'=> 'N', 'Ť'=> 'T', 'Ž' => 'Z', 'Ľ' => 'L', 'Ý'=> 'Y', 'Á'=> 'A', 'Í'=>'I', 'É'=> 'E', 'Ě'=>'E', 'Ů'=>'U', 'Ú'=> 'U','Ä'=>'AE', 'Ö'=>'OE', 'Ü'=>'UE',
            // small
            'а'=>'a', 'б'=>'b', 'в'=>'v', 'г'=>'g', 'д'=>'d', 'е'=>'e', 'ё'=>'yo', 'ж'=>'zh',
            'з'=>'z', 'и'=>'i', 'й'=>'j', 'к'=>'k', 'л'=>'l', 'м'=>'m', 'н'=>'n', 'о'=>'o',
            'п'=>'p', 'р'=>'r', 'с'=>'s', 'т'=>'t', 'у'=>'u', 'ф'=>'f', 'х'=>'h', 'ц'=>'ts',
            'ч'=>'ch', 'ш'=>'sh', 'щ'=>'shh', 'ъ'=>'', 'ы'=>'y', 'ь'=>'', 'э'=>'e', 'ю'=>'yu', 'я'=>'ya','ó' => 'o',
            // other
            'Ѓ'=>'G', 'Ґ'=>'G', 'Є'=>'YE', 'Ѕ'=>'Z', 'Ј'=>'J', 'І'=>'I', 'Ї'=>'YI', 'Ќ'=>'K', 'Љ'=>'L', 'Њ'=>'N', 'Ў'=>'U', 'Џ'=>'DH',          
            'ѓ'=>'g', 'ґ'=>'g', 'є'=>'ye', 'ѕ'=>'z', 'ј'=>'j', 'і'=>'i', 'ї'=>'yi', 'ќ'=>'k', 'љ'=>'l', 'њ'=>'n', 'ў'=>'u', 'џ'=>'dh', 'č' => 'c', 'š' => 's', 'ř' => 'r', 'ď' => 'd', 'ň'=> 'n', 'ť'=> 't', 'ž' => 'z', 'ľ' => 'l', 'ý' => 'y', 'á' => 'a', 'í' => 'i', 'é' => 'e', 'ě' => 'e', 'ů' => 'u', 'ú' => 'u', '.' => '-', '$' => 's', 'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'ß' => 'ss' 
        );

        $str = strtr( $str, $iso9 );

        $spec = preg_quote( $this->opt->spec );
        $str  = preg_replace("/[^a-zA-Z0-9\-_$spec]+/", '-', $str ); // все ненужное на '-'
        $str  = preg_replace('/^-+|-+$/', '', $str ); // кил конечные ---

        return strtolower( $str );
    }

    ## Strip shortcode
    function strip_shortcode( $text ){
        return preg_replace('~\['. $this->opt->shortcode .'[^\]]*\]~', '', $text );
    }
}


## Proccesing contents shortcode
add_filter('the_content', 'rehub_contents_shortcode');
function rehub_contents_shortcode( $content ){
    $args = array();
    $args['to_menu']  = __('back to menu', 'rehub_framework').' ↑';

    $autocontents = new Kama_Contents($args);   
    if( is_singular() ){        
        return $autocontents->shortcode( $content );
    }
    else{
        return $autocontents->strip_shortcode( $content );
    }
}

## Proccesing toplist shortcode
add_filter('the_content', 'rehubtop_contents_shortcode');
function rehubtop_contents_shortcode( $content ){
    $args = array();
    $args['shortcode'] = 'wpsm_toplist';
    $args['anchor_type'] = 'id';
    $args['wrap'] = 'toplistmenu';
    $args['tag_inside'] = 'wpsm_toplist_heading';
    $args['to_menu']  = __('back to menu', 'rehub_framework').' ↑'; 
    $args['selectors'] = array ('h2');
    $toplist = new Kama_Contents($args);

    if( is_singular() ){
        return $toplist->shortcode( $content );
    }
    else{
        return $toplist->strip_shortcode( $content );
    }
}

//Get site favicon
if (!function_exists('rehub_get_site_favicon')) {

    function rehub_get_site_favicon($url) {
        $shop = parse_url($url, PHP_URL_HOST);
        $shop = preg_replace('/^www\./', '', $shop);

        if ($shop){
            if($shop == 'dl.flipkart.com'){
                $shop = 'flipkart.com';
            }
            elseif($shop == 'click.linksynergy.com'){
                $shop = 'linkshare.com';
            } 
            elseif($shop == 'rover.ebay.com'){
                $shop = 'ebay.com';
            }             
            elseif($shop == 'pdt.tradedoubler.com'){
                $shop = 'tradedoubler.com';
            }
            elseif($shop == 'partners.webmasterplan.com'){
                $shop = 'affili.net';
            } 
            elseif($shop == 'ad.zanox.com'){
                $shop = 'zanox.com';
            }                                                
            $d = explode('.', $shop);
            $title = $d[0]; 
            $logo_urls_trans = get_transient('ce_favicon_urls');
            if (empty($logo_urls_trans)){
                $logo_urls_trans = array();
            }
            if(array_key_exists($shop, $logo_urls_trans)){
                $logo_url = $logo_urls_trans[$shop];
                if(is_ssl()) {$logo_url = str_replace('http://', 'https://', $logo_url);}
                return '<img src="'.$logo_url.'" height=16 width=16 alt='.$title.' /> '.$shop;
            }
            else {         
                $img_uri = '//www.google.com/s2/favicons?domain=http://'.$shop;                  
                $new_logo_url = rh_ae_saveimg_towp($img_uri, $title);
                if(!empty($new_logo_url)){
                    $logo_urls_trans[$shop] = $new_logo_url;
                    set_transient('ce_favicon_urls', $logo_urls_trans, 180 * DAY_IN_SECONDS); 
                    if(is_ssl()) {$new_logo_url = str_replace('http://', 'https://', $new_logo_url);} 
                    if($shop == 'amazon'){
                      return '<span class="compare-domain-text">'.ucfirst($shop).'</span>';
                    } 
                    else{
                      return '<img src="'.$new_logo_url.'" height=16 width=16 alt='.$title.' /> <span class="compare-domain-text">'.ucfirst($shop).'</span>';
                    }                  
                }
            }            
        }
    }
} 

if (!function_exists('rehub_get_site_favicon_icon')) {

    function rehub_get_site_favicon_icon($url) {
        $shop = parse_url($url, PHP_URL_HOST);
        $shop = preg_replace('/^www\./', '', $shop);
        if ($shop){
            if($shop == 'dl.flipkart.com'){
                $shop = 'flipkart.com';
            }
            elseif($shop == 'click.linksynergy.com'){
                $shop = 'linkshare.com';
            } 
            elseif($shop == 'rover.ebay.com'){
                $shop = 'ebay.com';
            }             
            elseif($shop == 'pdt.tradedoubler.com'){
                $shop = 'tradedoubler.com';
            }
            elseif($shop == 'partners.webmasterplan.com'){
                $shop = 'affili.net';
            }  
            elseif($shop == 'ad.zanox.com'){
                $shop = 'zanox.com';
            }                        
            $d = explode('.', $shop);
            $title = $d[0]; 
            $logo_urls_trans = get_transient('ce_favicon_urls');
            if (empty($logo_urls_trans)){
                $logo_urls_trans = array();
            }
            if(array_key_exists($shop, $logo_urls_trans)){
                $logo_url = $logo_urls_trans[$shop];
                if(is_ssl()) {$logo_url = str_replace('http://', 'https://', $logo_url);}              
                return '<img src="'.$logo_url.'" height=16 width=16 alt='.$title.' />';
            }
            else {         
                $img_uri = '//www.google.com/s2/favicons?domain=http://'.$shop;                  
                $new_logo_url = rh_ae_saveimg_towp($img_uri, $title);
                if(!empty($new_logo_url)){
                    $logo_urls_trans[$shop] = $new_logo_url;
                    set_transient('ce_favicon_urls', $logo_urls_trans, 180 * DAY_IN_SECONDS);
                    if(is_ssl()) {$new_logo_url = str_replace('http://', 'https://', $new_logo_url);} 
                    return '<img src="'.$new_logo_url.'" height=16 width=16 alt='.$title.' />';
                }
            }            
        }       
    }
} 

if(!function_exists('rh_fix_domain')){
    function rh_fix_domain($merchant, $domain){
        if($merchant){
            $merchant = trim($merchant);
        }
        if($merchant == 'Ferrari Store UK'){
            $domain = 'ferrari.com';
        }  
        if($domain == 'dl.flipkart.com'){
            $domain = 'flipkart.com';
        }
        elseif($domain == 'click.linksynergy.com'){
            $domain = 'linkshare.com';
        } 
        elseif($domain == 'pdt.tradedoubler.com'){
            $domain = 'tradedoubler.com';
        }
        elseif($domain == 'rover.ebay.com'){
            $domain = 'ebay.com';
        }         
        elseif($domain == 'partners.webmasterplan.com'){
            $domain = 'affili.net';
        }  
        elseif($domain == 'ad.zanox.com'){
            $domain = 'zanox.com';
        }   
        elseif($domain == 'catalog.paytm.com'){
            $domain = 'paytm.com';
        }                     
        return $domain;
    }
}


//Get site favicon
if (!function_exists('rh_best_syncpost_deal')) {
    function rh_best_syncpost_deal($itemsync = '', $wrapclass = 'mb10 compare-domain-icon', $image='yes') {
        if(empty($itemsync)) return;
        $merchant = (!empty($itemsync['merchant'])) ? $itemsync['merchant'] : '';
        $domain = (!empty($itemsync['domain'])) ? $itemsync['domain'] : '';
        $out = '';
        $out .='<div class="'.$wrapclass.'">';
        $out .='<span>'.__("Best deal at: ", "rehub_framework").'</span>';
        if($image == 'yes'){
            $out .=' <img src="'.esc_attr(\ContentEgg\application\helpers\TemplateHelper::getMerhantIconUrl($itemsync, true)).'" alt="'.$domain.'" height=16 />';          
        }

        if ($merchant){
            $out .='<span class="compare-domain-text">'.esc_html($merchant).'</span>';
        }
        elseif($domain){
            $out .='<span class="compare-domain-text">'.esc_html($domain).'</span>';            
        }        
        $out .='</div>';
        return $out;
    }
} 


//Get social buttons
if( !function_exists('rehub_social_inimage') ) {
function rehub_social_inimage($small = '', $favorite = '', $rh_favorite = '', $type = '', $wishlistids='')
{   
    global $post;
    if ($small == 'minimal') {
        $small_class = ' social_icon_inimage small_social_inimage';
        $text_fb = $text_tw = '';
    }
    elseif ($small =='row') {
        $small_class = ' row_social_inpost';
        $text_fb = 'Facebook';
        $text_tw = '';
    }
    elseif ($small == 'flat') {
        $text_fb = $text_tw = $small_class = '';
    }    
    else {
        $small_class = ' social_icon_inimage';
    }
    $output ='';
    $output .='<div class="social_icon '.$small_class.'">';
    if ($favorite == '1') {
        if(function_exists('get_favorites_button')){
            $output .='<div class="favour_in_row">'.get_favorites_button().'</div>';
        } 
    }
    if ($rh_favorite == '1' && !function_exists('get_favorites_button')) {
        $output .= getHotThumb($post->ID, false, false, true);
    }    
    if($type=='user' && function_exists('bp_core_get_user_domain')){
      $link = bp_core_get_user_domain(bp_displayed_user_id());
      $image = bp_get_displayed_user_avatar('type=full&html=false');
      $title = get_the_title().' - '.get_bloginfo('name' );
    }
    else{
      $link = get_permalink();
      $image = WPSM_image_resizer::get_post_thumb_static();
      $title = get_the_title();
    }
    if($wishlistids){
      $link = $link.'?wishlistids='.$wishlistids;
    }
    $output .= do_action('rh_social_inimage_before');
    $output .= '<span data-href="https://www.facebook.com/sharer/sharer.php?u='.urlencode($link).'" class="fb share-link-image" data-service="facebook"><i class="fa fa-facebook"></i></span>';
    $output .='<span data-href="https://twitter.com/share?url='.urlencode($link).'&text='.urlencode(html_entity_decode($title, ENT_COMPAT, 'UTF-8')).'" class="tw share-link-image" data-service="twitter"><i class="fa fa-twitter"></i></span>';
    $output .='<span data-href="https://pinterest.com/pin/create/button/?url='.urlencode($link).'&amp;media='.$image.'&amp;description='.urlencode($title).'" class="pn share-link-image" data-service="pinterest"><i class="fa fa-pinterest-p"></i></span>';
    if ($small =='row' || $small =='flat' ) {
        $output .='<span data-href="https://plus.google.com/share?url='.urlencode($link).'" class="gp share-link-image" data-service="googleplus"><i class="fa fa-google-plus"></i></span>';
    }
    $output .= do_action('rh_social_inimage_after');
    $output .='</div>';         
    return $output; 
}
}

if(!function_exists('rehub_get_ip')) {
    #get the user's ip address
    function rehub_get_ip() {
        if (empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip_address = $_SERVER["REMOTE_ADDR"];
        } else {
            $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        if(strpos($ip_address, ',') !== false) {
            $ip_address = explode(',', $ip_address);
            $ip_address = $ip_address[0];
        }
        return esc_attr($ip_address);
    }
}

if (!function_exists('rehub_truncate_title')) {
    #get custom length titles
    function rehub_truncate_title($len = 110, $id = NULL) {
        $title = get_the_title($id);        
        if (!empty($len) && mb_strlen($title)>$len) $title = mb_substr($title, 0, $len-3) . "...";
        return $title;
    }
}

if ( !function_exists( 'rh_serialize_data_review' ) ) {
    function rh_serialize_data_review( $array_data ) {
        serialize( $array_data );
        return $array_data;
    }
}

if ( !function_exists( 'rh_ae_logo_get' ) ) {
    function rh_ae_logo_get( $offerurl, $size=120 ) {
        if ($offerurl){
             $domain = str_ireplace('www.', '', parse_url($offerurl, PHP_URL_HOST));
        }
        if ($domain){   
            if ($domain == 'amazon.de' || $domain == 'amazon.com' || $domain == 'amazon.co.uk' || $domain == 'amazon.es' || $domain == 'amazon.in' || $domain == 'amazon.nl' ){
                return get_template_directory_uri().'/images/logos/amazon.png';
            } 
            elseif ($domain == 'ebay.de' || $domain == 'ebay.com' || $domain == 'ebay.co.uk' || $domain == 'ebay.es' || $domain == 'ebay.in' || $domain == 'ebay.nl' ){
                return get_template_directory_uri().'/images/logos/ebay.png';
            }  
            elseif ($domain == 'aliexpress.com'){
                return get_template_directory_uri().'/images/logos/aliexpress.png';
            }  
            elseif ($domain == 'flipkart.com' || $domain == 'dl.flipkart.com' ){
                return get_template_directory_uri().'/images/logos/flipkart.png';
            }    
            elseif ($domain == 'snapdeal.com'){
                return get_template_directory_uri().'/images/logos/snapdeal.png';
            }  
            elseif ($domain == 'banggood.com'){
                return get_template_directory_uri().'/images/logos/banggood.png';
            }             
            elseif ($domain == 'shopclues.com'){
                return get_template_directory_uri().'/images/logos/shopclues.png';
            }  
            elseif ($domain == 'etsy.com'){
                return get_template_directory_uri().'/images/logos/etsy.png';
            }  
            elseif ($domain == 'wiggle.com' || $domain == 'wiggle.co.uk'){
                return get_template_directory_uri().'/images/logos/wiggle.jpg';
            } 
            elseif ($domain == 'iherb.com' || $domain == 'ru.iherb.com'){
                return get_template_directory_uri().'/images/logos/iherb.jpg';
            }  
            elseif ($domain == 'airbnb.com' || $domain == 'ru.airbnb.com'){
                return get_template_directory_uri().'/images/logos/airbnb.jpg';
            } 
            elseif ($domain == 'infibeam.com'){
                return get_template_directory_uri().'/images/logos/infibeam.png';
            }                                                                                                        
            $logo_urls_trans = get_transient('ae_logo_store_urls');
            if (empty($logo_urls_trans)){
                $logo_urls_trans = array();
            }
            if(array_key_exists($domain, $logo_urls_trans)){
                return $logo_urls_trans[$domain];
            }
            else {
                $d = explode('.', $domain);
                $title = $d[0];  
                $img_uri = '//logo.clearbit.com/'.$domain.'?size='.$size.'';                  
                $new_logo_url = rh_ae_saveimg_towp($img_uri, $title);
                if(!empty($new_logo_url)){
                    $logo_urls_trans[$domain] = $new_logo_url;
                    set_transient('ae_logo_store_urls', $logo_urls_trans, 180 * DAY_IN_SECONDS); 
                    return $new_logo_url;
                }
            }

        }
    }
}

if ( !function_exists( 'rh_ae_saveimg_towp' ) ) {
    function rh_ae_saveimg_towp($img_uri, $title = '', $check_image_type = true)
    {
        if (!defined('FS_CHMOD_FILE'))
            define('FS_CHMOD_FILE', ( fileperms(ABSPATH . 'index.php') & 0777 | 0644));

        $uploads = wp_upload_dir();
        $newfilename = $title;
        $newfilename = preg_replace('/[^a-zA-Z0-9\-]/', '', $newfilename);
        $newfilename = strtolower($newfilename);
        if (!$newfilename)
            $newfilename = time();
        if (0 === strpos($img_uri, '//')) {
            $img_uri = 'https:' . $img_uri;
        }
        elseif(false === strpos($img_uri, '://')){
            $img_uri = 'https://' . $img_uri;
        }   
        require_once(ABSPATH . 'wp-admin/includes/file.php');     
        $downloadfile = download_url( $img_uri, 30 );
        if (is_wp_error($downloadfile) ){
            return false;
        }

        $newfilename .= '.png';
        $newfilename = wp_unique_filename($uploads['path'], $newfilename);

        if ($check_image_type)
        {
            $filetype = wp_check_filetype($newfilename, null);
            if (substr($filetype['type'], 0, 5) != 'image')
                return false;
        }

        $file_path = $uploads['path'] . DIRECTORY_SEPARATOR . $newfilename;
        $current = @file_get_contents($downloadfile);
        if (!file_put_contents($file_path, $current)) {
            return false;
        }

        @chmod($file_path, FS_CHMOD_FILE);
        return trailingslashit($uploads['url']).$newfilename;
    }

}

if(!function_exists('wpsm_inline_list_shortcode')) {
    function wpsm_inline_list_shortcode($atts, $content) {  
      $content = do_shortcode($content);    
        return '<div class="inline-list-wrap">' . $content . '</div>';  
    } 
    // add the shortcode to system
    add_shortcode('wpsm_inline_list', 'wpsm_inline_list_shortcode');
}

if(!function_exists('wpsm_stickypanel_shortcode')) {
    function wpsm_stickypanel_shortcode($atts, $content) {  
        $content = do_shortcode($content); 
        wp_enqueue_script('rehubwaypoints' );   
        return '<div id="content-sticky-panel"><span id="mobileactivate"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></span>' . $content . '</div>';  
    } 
    // add the shortcode to system
    add_shortcode('wpsm_stickypanel', 'wpsm_stickypanel_shortcode');
}


add_filter( 'gmw_pt_map_icon', 'rh_gmw_post_mapin', 10, 2);
if (!function_exists('rh_gmw_post_mapin')){
    function rh_gmw_post_mapin ($post, $gmw_form){
        global $post;
        $postid = $post->ID;
        return get_template_directory_uri() . '/images/default/mappostpin.png';        
    }
}

if (!function_exists('rh_gmw_post_in_popup')){
    function rh_gmw_post_in_popup ($output, $post, $gmw_form){
        $address   = ( !empty( $post->formatted_address ) ) ? $post->formatted_address : $post->address;
        $permalink = get_permalink( $post->ID );
        $thumb     = get_the_post_thumbnail( $post->ID );
        
        $output                  = array();
        $output['start']         = "<div class=\"gmw-pt-info-window-wrapper wppl-pt-info-window\">";
        $output['thumb']         = "<div class=\"thumb wppl-info-window-thumb\">{$thumb}</div>";
        $output['content_start'] = "<div class=\"content wppl-info-window-info\"><table>";
        $output['title']         = "<tr><td><div class=\"title wppl-info-window-permalink\"><a href=\"{$permalink}\">{$post->post_title}</a></div></td></tr>";
        $output['address']       = "<tr><td><span class=\"address\">{$gmw_form['labels']['info_window']['address']}</span>{$address}</td></tr>";
        
        if ( isset( $post->distance ) ) {
            $output['distance'] = "<tr><td><span class=\"distance\">{$gmw_form['labels']['info_window']['distance']}</span>{$post->distance} {$gmw_form['units_array']['name']}</td></tr>";
        }
        
        if ( !empty( $gmw_form['search_results']['additional_info'] ) ) {
        
            foreach ( $gmw_form['search_results']['additional_info'] as $field ) {
                if ( isset( $post->$field ) ) {
                    $output[$gmw_form['labels']['info_window'][$field]] = "<tr><td><span class=\"{$gmw_form['labels']['info_window'][$field]}\">{$gmw_form['labels']['info_window'][$field]}</span>{$post->$field}</td></tr>";
                }
            }
        }
        
        $output['content_end'] = "</table></div>";
        $output['end']         = "</div>";
        return $output;
    }
}
//add_filter( 'gmw_pt_info_window_content', 'rh_gmw_post_in_popup', 10, 3);

//////////////////////////////////////////////////////////////////
// PRICE HELPER
//////////////////////////////////////////////////////////////////
if(!class_exists('PriceTemplateHelper')){
class RhPriceTemplateHelper {

    static public function currencyTyping($c)
    {
        $types = array("RUB" => "руб.", "UAH" => "грн.", "USD" => "$", "CAD" => "C$", "GBP" => "&pound;", "EUR" => "&euro;", "JPY" => "&yen;", "CNY" => "&yen;", "INR" => "&#8377;", "AUD" => "AU $", "RUR" => 'руб.');
        if (key_exists($c, $types))
            return $types[$c];
        else
            return $c;
    }

    public static function number_format_i18n($number, $decimals = 0)
    {
        $decimal_point = __('number_format_decimal_point', 'rehub_framework');
        $thousands_sep = __('number_format_thousands_sep', 'rehub_framework');

        if ($decimal_point == 'number_format_decimal_point')
            $decimal_point = '.';

        if ($thousands_sep == 'number_format_thousands_sep')
            $thousands_sep = ',';

        return number_format($number, absint($decimals), $decimal_point, $thousands_sep);
    }

    public static function price_format_i18n($number, $currency = null)
    {
        if ($currency && in_array($currency, array('RUB', 'UAH', 'INR', 'RUR')))
            $decimal = 0;
        else
            $decimal = 2;
        return self::number_format_i18n($number, $decimal);
    }

    public static function formatPriceCurrency($price, $currencyCode)
    {
        $return = '';
        $currency = self::currencyTyping($currencyCode);
        $price = self::price_format_i18n($price, $currencyCode);

        if (in_array($currencyCode, array('RUB', 'UAH', 'RUR')))
            return $price . ' ' . $currency;
        else
            return $currency . '' . $price;
    }
}
}

//////////////////////////////////////////////////////////////////
// Hex to RGBA
//////////////////////////////////////////////////////////////////
if (!function_exists('hex2rgba')){
function hex2rgba($color, $opacity = false) {
 
    $default = 'rgb(0,0,0)';
 
    //Return default if no color provided
    if(empty($color))
          return $default; 
 
    //Sanitize $color if "#" is provided 
        if ($color[0] == '#' ) {
            $color = substr( $color, 1 );
        }
 
        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }
 
        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);
 
        //Check if opacity is set(rgba or rgb)
        if($opacity){
            if(abs($opacity) > 1)
                $opacity = 1.0;
            $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
            $output = 'rgb('.implode(",",$rgb).')';
        }
 
        //Return rgb(a) color string
        return $output;
}
}


//////////////////////////////////////////////////////////////////
// CSS minify
//////////////////////////////////////////////////////////////////
if (!function_exists('rehub_quick_minify')){ 
function rehub_quick_minify( $css ) {
    $css = preg_replace( '/\s+/', ' ', $css );
    $css = preg_replace( '/\/\*[^\!](.*?)\*\//', '', $css );
    $css = preg_replace( '/(,|:|;|\{|}) /', '$1', $css );
    $css = preg_replace( '/ (,|;|\{|})/', '$1', $css );
    $css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );
    $css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );
    return trim( $css );
}
}


//////////////////////////////////////////////////////////////////
// AMP CUSTOMIZATIONS
//////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////
// 1.1 AMP HEADER META
//////////////////////////////////////////////////////////////////


add_action( 'amp_post_template_css', 'rh_amp_additional_css_styles', 11 );

function rh_amp_additional_css_styles( $amp_template ) {
    // only CSS here please...
    ?>
h1, h2, h3, h4, h5, h6, .rehub-main-font, .wpsm-button, .btn_offer_block, .offer_title, .rh-deal-compact-btn, .egg-container .btn, .cegg-price{font-family: "Roboto", BlinkMacSystemFont, "Ubuntu", "Helvetica Neue", "Arial"}
.rehub-body-font, body{font-family: "Merriweather", "Roboto", "Helvetica Neue", "Arial"}
<?php 
  $boxshadow = '';
  if (rehub_option('rehub_btnoffer_color')) {
    $btncolor = rehub_option('rehub_btnoffer_color');
  } 
  else {
    if (REHUB_NAME_ACTIVE_THEME == 'REPICK') {
      $btncolor = '#D7541A';  
    }
    elseif (REHUB_NAME_ACTIVE_THEME == 'RETHING') {
      $btncolor = '#B07C01';  
    }
    elseif (REHUB_NAME_ACTIVE_THEME == 'REWISE') {
      $btncolor = '#43c801';  
    }   
    else{
      $btncolor = '#43c801';      
    }
  }
?>
<?php if (REHUB_NAME_ACTIVE_THEME == 'REWISE' || rehub_option('enable_smooth_btn') == 1):?>
    <?php $boxshadow = hex2rgba($btncolor, 0.25);?>
.price_count, .rehub_offer_coupon, a.btn_offer_block{border-radius: 100px}
<?php endif;?>    
.rh-cat-label-title a,.rh-cat-label-title a:visited,a.rh-cat-label-title,a.rh-cat-label-title:visited{font-style:normal;background-color:#111;padding:3px 6px;color:#fff;font-size:11px;white-space:nowrap;text-decoration:none;display:inline-block;margin:0 5px 5px 0;line-height:1}.post-meta-big{margin:0 0 5px;padding:0 0 15px;color:#aaa;border-bottom:1px solid #eee;overflow:hidden}a.btn_offer_block,.rh-deal-compact-btn,.btn_block_part a.btn_offer_block,.wpsm-button.rehub_main_btn,.widget_merchant_list .buttons_col,#toplistmenu > ul li:before,a.btn_offer_block:visited,.rh-deal-compact-btn:visited,.wpsm-button.rehub_main_btn:visited
{ background: none <?php echo $btncolor ?>; color: #fff; border:none;text-decoration: none; outline: 0;  
  <?php if($boxshadow) :?>
    border-radius: 100px;box-shadow: -1px 6px 19px <?php echo $boxshadow;?>;
  <?php else:?>
    border-radius: 0;box-shadow: 0 2px 2px #E7E7E7;
  <?php endif; ?>
}    
.amp-rh-article-header{margin:1.5em 16px;max-width:1000px}.amp-wp-article-featured-image{margin-top:10px}.floatleft{float:left}.floatright{float:right}.post-meta-big img{border-radius:50%}.post-meta-big a{text-decoration:none;color:#111}.post-meta-big span.postthumb_meta{color:#c00}.post-meta-big span.comm_count_meta svg,.post-meta-big span.postthumb_meta svg{padding-right:4px;line-height:12px;vertical-align:middle}.post-meta-big span.postthumb_meta svg path{fill:#c00}.post-meta-big span.comm_count_meta svg path{fill:#999}.authortimemeta{line-height:18px;font-weight:700}.date_time_post{font-size:13px;font-weight:400}.postviewcomm{line-height:28px;font-size:14px}.amp-rh-title{font-size:28px;line-height:34px;margin:0 0 25px}strong{font-weight:700}.single_price_count del{opacity:.3;font-size:80%}.btn_block_part a.btn_offer_block,.rehub_quick_offer_justbtn a.btn_offer_block{display:block;padding:10px 16px;font-size:16px;font-weight:700;text-transform:uppercase;margin-bottom:10px}.rehub_offer_coupon{display:block;padding:7px 14px;border:1px dashed #888;text-align:center;position:relative;font-size:14px;clear:both}.single_priced_block_amp{text-align:center}.single_price_count{font-size:22px;margin-bottom:10px;font-weight:700;display:block}.rehub_main_btn,.wpsm-button.rehub_main_btn,a.btn_offer_block{padding:10px 20px;display:inline-block;position:relative;line-height:18px;font-weight:700}.text-center{text-align:center}.mr5{margin-right:5px}.mr10{margin-right:10px}.mr15{margin-right:15px}.mr20{margin-right:20px}.mr25{margin-right:25px}.mr30{margin-right:30px}.ml5{margin-left:5px}.ml10{margin-left:10px}.ml15,.ml20{margin-left:20px}.ml25{margin-left:25px}.ml30{margin-left:30px}.mt10{margin-top:10px}.mt5{margin-top:5px}.mt15{margin-top:15px}.mt20{margin-top:20px}.mt25{margin-top:25px}.mt30{margin-top:30px}.mb0{margin-bottom:0}.mb5{margin-bottom:5px}.mb10{margin-bottom:10px}.mb15{margin-bottom:15px}.mb20{margin-bottom:20px}.mb25{margin-bottom:25px}.mb30,.mb35{margin-bottom:30px}.mt0{margin-top:0}.ml0{margin-left:0}.mr0{margin-right:0}.amp-wp-article-content .aff_tag amp-img,.amp-wp-article-content .widget_merchant_list .merchant_thumb amp-img,.amp-wp-article-content a.btn_offer_block .mtinside amp-img{display:inline-block;margin:0 4px;vertical-align:middle}.product_egg .deal-box-price{font-size:27px;line-height:40px;margin-bottom:10px}.aff_tag{font-size:14px}.priced_block{margin-bottom:5px; margin-top:10px}
<?php if(rehub_option('amp_default_css_disable') == ''):?>
.flowhidden,.pros_cons_values_in_rev,.rate_bar_wrap,.review-top,.rh-cartbox{overflow:hidden}.widget_merchant_list .buttons_col{border-radius:0}.rh-tabletext-block-heading,.rh-tabletext-block-left,.rh-tabletext-block-right{display:block;margin-bottom:25px}ins{text-decoration:none}.redcolor{color:#b00}.greencolor{color:#009700}.whitecolor{color:#fff}.tabledisplay{display:table;width:100%}.rowdisplay{display:table-row}.celldisplay{display:table-cell;vertical-align:middle}.img-thumbnail-block,.inlinestyle{display:inline-block}.fontbold{font-weight:700}.lineheight20{line-height:20px}.lineheight15{line-height:15px}.border-top{border-top:1px solid #eee}.font90,.font90 h4{font-size:90%}.font80,.font80 h4{font-size:80%}.font70,.font70 h4{font-size:70%}.font110,.font110 h4{font-size:110%}.font120{font-size:120%}.font130{font-size:130%}.font140{font-size:140%}.font150{font-size:150%}.font250{font-size:250%}.pr5{padding-right:5px}.pr15{padding-right:15px}.rh-cartbox{box-shadow:rgba(0,0,0,.15) 0 1px 2px;background:#fff;padding:20px;position:relative;border-top:1px solid #efefef}.no-padding,.rh-cartbox.no-padding{padding:0}.rh-line{height:1px;background:#ededed;clear:both}.rh-line-right{border-right:1px solid #ededed}.rh-line-left{border-left:1px solid #ededed}.fontnormal,.fontnormal h4{font-weight:400}.wpsm-button.rehub_main_btn.small-btn{font-size:17px;padding:9px 16px;text-transform:none;margin:0}.clearfix:after,.clearfix:before{content:"";display:table}.clearfix:after{clear:both}a.rh-cat-label-title.rh-dealstore-cat{background-color:green}.floatright.postviewcomm{margin-top:15px;float:none}.re-line-badge{color:#fff;padding:5px 10px;background:#77B21D;text-shadow:0 1px 0 #999;font:700 10px/14px Roboto,Arial;position:relative;text-transform:uppercase;display:inline-block;z-index:999}.re-line-badge.re-line-small-label{display:inline-block;padding:3px 6px;margin:0 5px 5px 0;text-align:center;white-space:nowrap;font-size:11px;line-height:11px}.rh-cat-list-title{margin:0 0 8px;line-height:11px;display:inline-block}.rate-bar{position:relative;display:block;margin-bottom:34px;width:100%;background:#ddd;height:14px;}.rate-bar-percent,.rate-bar-title{position:absolute;top:-21px;font-size:14px}.rate-bar-title{left:0}.rate-bar-title span{display:block;height:18px;line-height:18px}.rate-bar-bar{height:14px;width:0;background:#E43917}.rate-bar-percent{right:0;height:18px;line-height:18px;font-weight:700}.rate_bar_wrap{clear:both;background:#f2f2f2;padding:20px;margin-bottom:25px;border:1px dashed #aaa;box-shadow:0 0 20px #F0F0F0}.review-top .overall-score{background:#E43917;width:100px;text-align:center;float:left;margin:0 20px 10px 0}.review-top .overall-score span.overall{font-size:52px;color:#FFF;padding:8px 0;display:block;line-height:52px}.review-top .overall-score span.overall-text{background:#000;display:block;color:#FFF;font-weight:700;padding:6px 0;text-transform:uppercase;font-size:11px}.review-top .overall-score .overall-user-votes{background-color:#111;color:#fff;font-size:11px;line-height:11px;padding:8px 0}.review-top .review-text span.review-header{font-size:32px;font-weight:700;font-family:Roboto,trebuchet ms;color:#000;line-height:32px;display:block;margin-bottom:9px}.review-top .review-text p{margin:0}.rate_bar_wrap_two_reviews .l_criteria{margin:0 0 35px;padding:8px 0;overflow:hidden}.rate_bar_wrap_two_reviews .l_criteria span.score_val{text-align:right;float:right;font:36px/36px Arial}.rate_bar_wrap_two_reviews .score_val{border-bottom:3px solid #E43917}.rate_bar_wrap_two_reviews .l_criteria span.score_tit{font-size:16px;line-height:36px;text-transform:uppercase;float:left}.user-review-criteria .rate-bar-bar{background-color:#2C7FD0}.rate_bar_wrap_two_reviews .user-review-criteria .score_val{border-bottom:3px solid #2C7FD0}.rate_bar_wrap .review-criteria{margin-top:20px;border-top:1px dashed #d2d2d2;border-bottom:1px dashed #d2d2d2;padding:40px 0 0;}.rate_bar_wrap_two_reviews .review-criteria{border:none;padding:0;margin-top:0}.review-header{display:block;font-size:20px;font-weight:700}.rate_bar_wrap .your_total_score .user_reviews_view_score{float:right}.rate-bar-bar.r_score_1{width:10%}.rate-bar-bar.r_score_2{width:20%}.rate-bar-bar.r_score_3{width:30%}.rate-bar-bar.r_score_4{width:40%}.rate-bar-bar.r_score_5{width:50%}.rate-bar-bar.r_score_6{width:60%}.rate-bar-bar.r_score_7{width:70%}.rate-bar-bar.r_score_8{width:80%}.rate-bar-bar.r_score_9{width:90%}.rate-bar-bar.r_score_10{width:100%}.pros_cons_values_in_rev{border-bottom:1px dashed #d2d2d2;margin:20px 0 10px;padding:0 0 10px}.wpsm_cons .title_cons,.wpsm_pros .title_pros{margin:0 0 15px;font-size:16px;font-style:italic;font-weight:700}.rating_bar,.wpsm-table{overflow:auto}.wpsm_pros .title_pros{color:#58c649}.wpsm_cons .title_cons{color:#f24f4f}.rating_bar{margin:15px 0 0}.widget_merchant_list{border:3px solid #eee;padding:1px;background:#fff;line-height:22px}.table_merchant_list{display:table-row}.table_merchant_list>div{display:table-cell;margin:0;vertical-align:middle}.widget_merchant_list .merchant_thumb{font-size:13px;border-bottom:1px solid #eee}.table_merchant_list a{display:block;text-decoration:none;color:#111;padding:8px 5px}.widget_merchant_list .price_simple_col{text-align:center;background-color:#f5f9f0;border-bottom:1px solid #eee;font-size:14px;font-weight:700}ul.slides{margin:0 0 20px}ul.slides li{list-style:none}.carousel-style-deal .deal-item-wrap .deal-detail h3{font-size:16px;line-height:20px}.aff_offer_links .table_view_block,.egg_grid .small_post{padding:15px 10px;border-top:1px dotted #ccc}.aff_offer_links .table_view_block:first-child,.egg_grid .small_post:first-child{border-top:none;box-shadow:none}.table_view_block h4.offer_title{margin:0 0 15px;}.egg_grid .small_post .affegg_grid_title{font-size:16px;line-height:22px;margin-bottom:25px;font-weight:700}.egg_sort_list .last_update{background-color:#f9f9f9;padding:8px;text-align:center;font-size:11px}.egg_sort_list.simple_sort_list .offer_thumb{width:120px;padding:0;text-align:center;float:left;margin:0 15px 15px 0}.egg_sort_list.simple_sort_list .buttons_col,.egg_sort_list.simple_sort_list .desc_col{margin:0 0 10px 130px;text-align:left}.egg_sort_list.simple_sort_list .price_count,.egg_sort_list.simple_sort_list .price_simple_col{text-align:left}.rtl .egg_sort_list.simple_sort_list .offer_thumb{float:right;margin:0 0 15px 15px}.rtl .egg_sort_list.simple_sort_list .buttons_col,.rtl .egg_sort_list.simple_sort_list .desc_col{margin:0 130px 10px 0;text-align:right}.rtl .egg_sort_list.simple_sort_list .price_count,.rtl .egg_sort_list.simple_sort_list .price_simple_col{text-align:right}.widget_merchant_list .buttons_col a{color:#fff;font-weight:700;font-family:Roboto;padding:8px 10px;white-space:nowrap;border-bottom:1px solid #fff;text-align:center}.egg_sort_list.simple_sort_list{line-height:24px}.sale_a_proc{z-index:9;width:36px;height:36px;border-radius:50%;background-color:#4D981D;font:12px/36px Arial;color:#fff;display:block;text-decoration:none;text-align:center;position:absolute;top:10px;left:10px}.best_offer_badge{color:red}.small_post figure{position:relative}.amp-section-thumbs,.amp-section-videos{padding:30px 0}.amp-section-thumbs img{height:auto}.amp-wp-article-content .amp-section-thumbs amp-img{border:1px solid #eee;margin:2px;max-width:100px}.rehub-amp-subheading svg{vertical-align:middle;margin:0 5px;display:inline-block}.rehub-amp-subhead{vertical-align:middle;display:inline-block;font-weight:700;font-size:18px;line-height:25px}.-amp-accordion-header{padding:14px}.egg_grid .buttons_col,.table_view_block .buttons_col,.table_view_block .desc_col,.table_view_block .price_col{text-align:center;margin:0 auto 20px}.masonry_grid_fullwidth.egg_grid,.rehub_feat_block{margin-bottom:25px;box-shadow:0 2px 8px #f1f1f1;padding:20px;border:1px solid #f4f4f4}.table_view_block>div{margin:0 auto 15px}.additional_line_merchant,.popup_cont_div,.price-alert-form-ce,.pricealertpopup-wrap,.r_show_hide,.rehub_woo_tabs_menu,.rh-table-price-graph{display:none}.table_view_block .offer_thumb img{max-height:120px}.price_count del,.price_count strike,.price_simple_col strike{opacity:.3}.egg_sort_list.simple_sort_list .egg-logo amp-img{margin:5px 0}.egg_sort_list.simple_sort_list .table_view_block{padding:15px 0}.table_view_block .price_count{font-size:18px;line-height:20px;font-weight:700}.aff_offer_links h5{font-size:16px}.yes_available{color:#4D981D}.egg-logo amp-img,.widget_logo_list .offer_thumb amp-img{max-height:50px;max-width:80px}.table_div_list>a{display:table;width:100%;float:none;border: 1px solid #ddd;vertical-align:middle;border-radius:100px;text-decoration:none;margin-bottom:10px}.table_div_list img{max-height: 30px;vertical-align:middle}.table_div_list>a>div{display:table-cell;margin:0;vertical-align:middle;}.widget_logo_list .offer_thumb{width:110px;text-align:center;border-right:1px solid #eee;padding:10px 15px;}.widget_logo_list .price_simple_col{text-align:left;font-size:16px;color:#111;font-weight:bold;padding:8px 15px;line-height:20px;width:auto;}.widget_logo_list .buttons_col{width:40px;text-align:center;}
.widget_logo_list .buttons_col i{font-size:20px}.col_wrap_two .product_egg .col_item .buttons_col{margin-bottom:25px}a.btn_offer_block .mtinside{text-align:right;position:absolute;bottom:-19px;left:0;color:#ababab;text-shadow:none;font:11px/11px Arial;text-transform:none}ul.featured_list{margin:15px;text-align:left;padding:0}.rh_opacity_7{opacity: 0.7}.rh_opacity_5{opacity: 0.5}.rh_opacity_3{opacity: 0.3}.wpsm_box{display:block;padding:15px;margin:0 0 20px;font-size:15px}.wpsm_box.gray_type{color:#666;background:#f9f9f9;border:1px solid #ddd}.wpsm_box.red_type{color:#de5959;background:#ffe9e9;border:1px solid #fbc4c4}.wpsm_box.green_type{color:#5f9025;background:#ebf6e0;border:1px solid #b3dc82}.wpsm_box.blue_type{color:#5091b2;background:#e9f7fe;border:1px solid #b6d7e8}.wpsm_box.yellow_type{color:#c4690e;background:#fffdf3;border:1px solid #f2dfa4}.wpsm_box.dashed_border_type{border:1px dashed #CCC}.wpsm_box.solid_border_type{border:1px solid #CCC}.wpsm_box.transparent_type{background-color:transparent}.wpsm_box.download_type,.wpsm_box.error_type,.wpsm_box.info_type,.wpsm_box.note_type,.wpsm_box.standart_type,.wpsm_box.warning_type{border-bottom-style:solid;border-top-style:solid;border-width:1px;color:#363636;min-height:52px;padding:15px 15px 15px 20px;margin:0 0 25px;overflow:auto}.wpsm_box.warning_type{background-color:#FFF7F4;border-color:#F38867;color:#A61818}.wpsm_box.standart_type{background-color:#F9F9F9;border-color:#E3E3E3}.wpsm_box.info_type{background-color:#F0FFDE;border-color:#ABE19A}.wpsm_box.error_type{background-color:#FFD3D3;border-color:red;color:#DC0000}.wpsm_box.download_type{background-color:#E8F9FF;border-color:#BCD0DE}.wpsm_box.note_type{background-color:#FFFCE5;border-color:#FFDC7D}.wpsm_box.download_type i,.wpsm_box.error_type i,.wpsm_box.info_type i,.wpsm_box.note_type i,.wpsm_box.standart_type i,.wpsm_box.warning_type i{font-weight:400;font-style:normal;vertical-align:baseline;font-size:27px;float:left;margin:0 14px 10px 0}.wpsm_box.warning_type i:before{content:"❗";color:#E25B32}.wpsm_box.info_type i:before{content:"ℹ";color:#53A34C}.wpsm_box.error_type i:before{content:"❗";color:#DC0000}.wpsm_box.download_type i:before{content:"↓";color:#1AA1D6}.wpsm_box.note_type i:before{content:"ℹ";color:#555}.wpsm-button{margin:0 5px 8px 0;cursor:pointer;display:inline-block;outline:0;background:#aaa;border:1px solid #7e7e7e;color:#fff;font-weight:700;padding:4px 10px;line-height:.8em;text-decoration:none;text-align:center;white-space:normal;text-shadow:0 1px 0 rgba(0,0,0,.25);box-shadow:0 1px 2px rgba(0,0,0,.2);position:relative;font-size:15px;box-sizing:border-box;font-style:normal}.wpsm-button.white{border:1px solid #ccc;background-color:#fff;color:#111;text-shadow:none;box-shadow:0 1px 1px rgba(0,0,0,.1)}.wpsm-button.small{padding:5px 12px;line-height:12px;font-size:12px}.wpsm-button.medium{padding:8px 16px;line-height:15px;font-size:15px}.wpsm-button.big{padding:12px 24px;line-height:22px;font-size:22px}.wpsm-button.giant{padding:16px 30px;line-height:30px;font-size:30px}.wpsm-button.black{background:#505050;border:1px solid #101010}.wpsm-button.red{background:#d01d10;border:1px solid #d01d10}.wpsm-button.orange{background:#fa9e19;border:1px solid #FB6909}.wpsm-button.blue{background:#1571f0;border:1px solid #1a6dd7}.wpsm-button.rosy{background:#f295a2;border:1px solid #e84a5f}.wpsm-button.pink{background:#e3618d;border:1px solid #cb245c}.wpsm-button.green{background:#43c801;border-color:#43c801}.wpsm-button.brown{background:#876565;border:1px solid #604848}.wpsm-button.purple{background:#524656;border:1px solid #372f3a}.wpsm-button.gold{background:#ffc750;border:1px solid #faaa00;color:#844D1E;text-shadow:1px 1px 1px #ffe2a5}.wpsm-button.teal{background:#3c9091;border:1px solid #286061}.wpsm-button.navy{background:#2c76cf;border:1px solid #1d4e89}.wpsm-button.left{float:left}.wpsm-button.right{float:right;margin-right:0;margin-left:5px}.wpsm-button.small i.fa{padding-right:5px}.wpsm-button.medium i.fa{padding-right:8px}.wpsm-button.big i.fa{padding-right:10px}.wpsm-button.wpsm-flat-btn{border-radius:0;font-weight:400}.wpsm-bar-title,.wpsm-bar-title span{border-top-left-radius:3px;border-bottom-left-radius:3px}.wpsm-bar,.wpsm-bar-bar{border-radius:3px;height:28px}.popup_cont_inside{padding:20px}.wpsm-table table{border-collapse:separate;padding-bottom:1px;width:100%;margin:10px 0 20px;border-spacing:0;font-size:14px}.wpsm-table table tr td,.wpsm-table table tr th{padding:12px 15px;border-bottom:1px solid #e8e8e8;text-align:left;vertical-align:middle}.wpsm-table table tr th{background:#222;color:#FFF;font-size:15px;font-weight:700;text-transform:uppercase}.wpsm-table table tbody tr td{background:#FAFAFA}.wpsm-table table tbody tr:nth-child(2n+1) td{background:#fff}.wpsm-bar{position:relative;display:block;margin-bottom:15px;width:100%;background:#eee;}.wpsm-bar-title{position:absolute;top:0;left:0;font-weight:700;font-size:13px;color:#fff;background:#6adcfa}.wpsm-bar-title span{display:block;background:rgba(0,0,0,.1);padding:0 20px;height:28px;line-height:28px}.wpsm-bar-bar{width:0;background:#6adcfa}.wpsm-bar-percent{position:absolute;right:10px;top:0;font-size:11px;height:28px;line-height:28px;color:#444;color:rgba(0,0,0,.4)}.wpsm-clearfix:after{content:".";display:block;clear:both;visibility:hidden;line-height:0;height:0}.wpsm-titlebox{margin:0 0 30px;padding:15px 20px 12px;position:relative;border:3px solid #E7E4DF}.wpsm-titlebox>strong:first-child{background:#fff;float:left;font-size:16px;font-weight:600;left:11px;line-height:18px;margin:0 0 -9px;padding:0 10px;position:absolute;text-transform:uppercase;top:-10px}.wpsm-divider{display:block;width:100%;height:0;margin:0;background:0 0;border:none}.wpsm-divider.solid_divider{border-top:1px solid #e6e6e6}.wpsm-divider.dashed_divider{border-top:2px dashed #e6e6e6}.wpsm-divider.dotted_divider{border-top:3px dotted #e6e6e6}.wpsm-divider.double_divider{height:5px;border-top:1px solid #e6e6e6;border-bottom:1px solid #e6e6e6}.wpsm-divider.clear_divider{clear:both}.wpsm-highlight-yellow,.wpsm-highlight-yellow a{background-color:#FFF7A8;color:#695D43}.wpsm-highlight-blue,.wpsm-highlight-blue a{color:#185a7c;background:#e9f7fe}.wpsm-highlight-green,.wpsm-highlight-green a{color:#5f9025;background:#ebf6e0}.wpsm-highlight-red,.wpsm-highlight-red a{color:#c03b3b;background:#ffe9e9}.wpsm-highlight-black,.wpsm-highlight-black a{color:#fff;background:#222}.wpsm_pretty_list ul li a{display:inline-block;line-height:18px;text-decoration:none;}.darklink ul li a{color:#111}.wpsm_pretty_list ul li{position:relative;list-style-type:none;margin:0;padding:10px 20px 10px 28px;border-radius:100px}.wpsm_pretty_list.small_gap_list ul li{padding:6px 12px 6px 28px}.wpsm_pretty_list ul li:before{text-align:center;position:absolute;top:0;bottom:0;left:0;width:15px;height:15px;margin:auto;line-height:1}.wpsm_pretty_list.wpsm_pretty_hover ul li:hover{padding:10px 20px 10px 34px}.wpsm_pretty_list.small_gap_list.wpsm_pretty_hover ul li:hover{padding:6px 12px 6px 34px}.wpsm_pretty_list.wpsm_pretty_hover ul li:hover:before{left:12px}.font130 .wpsm_pretty_list ul li{padding-left:34px}.rtl .wpsm_pretty_list ul li a:before{left:auto;right:0}.rtl .wpsm_pretty_list ul li{padding:12px 28px 12px 20px}.rtl .wpsm_pretty_list.small_gap_list ul li{padding:6px 28px 6px 12px}.rtl .wpsm_pretty_list.wpsm_pretty_hover ul li:hover{padding:10px 34px 10px 20px}.rtl .wpsm_pretty_list.small_gap_list.wpsm_pretty_hover ul li:hover{padding:6px 34px 6px 12px}.rtl .wpsm_pretty_list.wpsm_pretty_hover ul li:hover:before{right:12px;left:auto}.rtl .font130 .wpsm_pretty_list ul li{padding-right:34px}.wpsm_arrowlist ul li:before{content:"→"}.wpsm_checklist ul li:before{content:"✔";color:#1abf3d}.wpsm_starlist ul li:before{content:"★"}.wpsm_bulletlist ul li:before{content:"∙"}.wpsm_pretty_hover ul li:hover:before{color:#fff}.wpsm-icecat-spec.wpsm-table table tr.heading-th-spec-line th{padding:8px 0;border-bottom:1px solid #eee}.wpsm-table table tr:first-child th{border-top:0 none}.wpsm-icecat-spec.wpsm-table table tr th{font-size:16px;padding:18px 0;background-color:transparent;color:#111;border-bottom:none}.wpsm-icecat-spec.wpsm-table table tbody tr td.icecat-spec-val{color:#777;width:25%;min-width:100px;padding:6px 15px 6px 0}.wpsm-icecat-spec.wpsm-table table tbody tr td{vertical-align:top;min-width:100px;padding:6px 0;border:none}a.add_user_review_link{color:#111}.amp-wp-article .comment-button-wrapper a{background:#43c801;border-color:#43c801;box-shadow:0 1px 2px rgba(0,0,0,.2);color:#fff;font-size:16px}amp-sidebar .toggle-navigationv2 ul li a{font-size:15px;line-height:22px}#toplistmenu ul{counter-reset:item;list-style:none;box-shadow:0 4px 12px #e0e0e0;margin:0 4px 12px;border:1px solid #ddd;border-top:none}#toplistmenu ul li{list-style:none;padding:15px 15px 15px 5px;margin:0;border-top:1px solid #ddd}.autocontents li.top{counter-increment:list;counter-reset:list1;font-size:105%}#toplistmenu>ul li:before{border-radius:50%;color:#fff;content:counter(item);counter-increment:item;float:left;height:25px;line-height:25px;margin:-3px 20px 20px 15px;text-align:center;width:25px;font-weight:700;font-size:16px}.autocontents li.top:before{content:counter(list) '. '}#toplistmenu ul li a{font-size:18px;line-height:14px;border-bottom:1px dotted #111;text-decoration:none}.egg-listcontainer{text-align:center}.egg-item .cegg-price-row .cegg-price{font-size:32px;line-height:30px;white-space:nowrap;font-weight:700;margin-bottom:15px;display:inline-block}.text-right{text-align:right}.egg-container .egg-listcontainer .row-products{border-bottom:1px solid #ddd;margin:0;padding:15px 0}.egg-container .h4,.egg-container h4{font-size:1.2em}.egg-container .text-muted{color:#777;font-size:.9em;line-height:.9em}.amp-wp-article-content .offer_price .cegg-thumb amp-anim,.amp-wp-article-content .offer_price .cegg-thumb amp-img{display:inline-block;margin:0 0 15px}.rh_comments_list{margin:2.5em 16px}.rh_comments_list ul{margin:0}.comment-meta{font-size:13px;margin-bottom:10px}.comment-content{padding:15px;background:#f7f7f7}.user_reviews_view_criteria_line{overflow:hidden;margin:0 0 4px}.rh_comments_list>ul>li{background:#FFF;border:1px solid #eee;box-shadow:0 1px 1px #ededed;height:auto;max-width:100%;position:relative;list-style:none;margin:0 0 18px;padding:12px 20px 20px}.user_reviews_average{font-size:115%;overflow:hidden;display:block;font-weight:700;margin-bottom:15px}.comment-content-review{margin:25px 0 10px;font-size:13px}.user_reviews_view_pros{margin-top:20px}.user_reviews_view_pros .user_reviews_view_pc_title{color:#00a100}.user_reviews_view_cons .user_reviews_view_pc_title{color:#c00}.cons_comment_item,.pros_comment_item{list-style:disc;margin:0 0 0 15px}.rh_comments_list .rate-bar,.rh_comments_list .rate-bar-bar{height:9px;clear:both;margin:0}.relatedpost .related_posts ol li{border:1px solid #ededed;padding:15px 18px;box-sizing:border-box}.relatedpost .no_related_thumbnail{padding:15px 18px}.relatedpost .related_posts h3{font-size:18px}.amp-wp-footer{background:#f7f7f7;border-color:#eee}#pagination .next{margin-bottom: 20px}.val_sim_price_used_merchant{font-size: 10px; display: block;}.table_merchant_list .val_sim_price_used_merchant{font-size: 9px;}.cegg-rating > span {display: inline-block;position: relative;font-size: 30px;color: #F6A123;}.product_egg .image{position:relative}
<?php endif;?>
<?php if(rehub_option('amp_custom_css')):?>
    <?php echo rehub_kses(rehub_option('amp_custom_css')); // amphtml content; no kses ?>
<?php endif;?>

    <?php
}

// Logo
add_action( 'amp_post_template_css', 'rh_amp_additional_css_logo' );
function rh_amp_additional_css_logo( $amp_template ) {
  if ( rehub_option( 'rehub_logo_amp' ) && !function_exists('ampforwp_custom_template')) : 
  ?>
   .amp-wp-header a {background-image: url( '<?php echo rehub_option( 'rehub_logo' ); ?>' );background-repeat: no-repeat;background-size: contain;background-position: center top;display: block;height: 32px;width: 100%;text-indent: -9999px;}
    <?php endif;
}

// Add meta description from Seo By Yoast
add_filter( 'amp_post_template_metadata', 'rehub_amp_update_metadata', 10, 2 );
function rehub_amp_update_metadata( $metadata, $post ) {
    if ( class_exists('WPSEO_Frontend') ) {
        $front = WPSEO_Frontend::get_instance();
        $desc = $front->metadesc( false );
        if ( $desc ) {
            $metadata['description'] = $desc;
        }
    }
    return $metadata;
}

add_action('ampforwp_post_before_design_elements', 'rehub_amp_add_custom_before_title' );
if(!function_exists('rehub_amp_add_custom_before_title')){
    function rehub_amp_add_custom_before_title(){
        if(rehub_option('amp_custom_in_header_top')):
            echo '<div class="amp-wp-article-content">'.do_shortcode(rehub_option('amp_custom_in_header_top')).'</div><div class="clearfix mb20"></div>';    
        endif;
    }    
}

add_action('ampforwp_inside_post_content_after', 'rehub_amp_add_custom_in_footer' );
if(!function_exists('rehub_amp_add_custom_in_footer')){
    function rehub_amp_add_custom_in_footer(){
        if(rehub_option('amp_custom_in_footer')):
            echo do_shortcode(rehub_option('amp_custom_in_footer')).'<div class="clearfix"></div>';   
        endif;
    }    
}

add_action('amp_post_template_footer', 'rehub_amp_add_custom_footer_section' );
if(!function_exists('rehub_amp_add_custom_footer_section')){
    function rehub_amp_add_custom_footer_section(){
        if(rehub_option('amp_custom_in_footer_section')):
            echo rehub_option('amp_custom_in_footer_section');   
        endif;
    }    
}

add_action('amp_post_template_head', 'rehub_amp_add_custom_header_section' );
if(!function_exists('rehub_amp_add_custom_header_section')){
    function rehub_amp_add_custom_header_section(){
        if(rehub_option('amp_custom_in_head_section')):
            echo rehub_option('amp_custom_in_head_section');    
        endif;
    }    
}

add_action('amp_post_template_head', 'rehub_amp_add_custom_scripts' );
if(!function_exists('rehub_amp_add_custom_scripts')){
    function rehub_amp_add_custom_scripts(){
    ?>     
        <?php
            global $post;
            $postid = $post->ID;
            if(!$postid) return;
        ?>
        <?php 
            $post_image_gallery = get_post_meta( $postid, 'rh_post_image_gallery', true );
            $post_image_videos = get_post_meta( $postid, 'rh_post_image_videos', true );
        ?>
        <?php if(!empty($post_image_videos) || !empty($post_image_gallery) ) :?>
            <script async custom-element="amp-accordion" src="https://cdn.ampproject.org/v0/amp-accordion-0.1.js"></script>
        <?php endif;?>      
        <?php if(!empty($post_image_gallery) ) :?>
            <script async custom-element="amp-image-lightbox" src="https://cdn.ampproject.org/v0/amp-image-lightbox-0.1.js"></script>
        <?php endif;?>
        <?php if(!empty($post_image_videos) ) :?>
            <script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>
        <?php endif;?>
    
    <?php
    }    
}

add_filter( 'amp_post_template_file', 'rehub_amp_delete_custom_title_section', 11, 3 ); //Delete AMP custom plugin title section
if(!function_exists('rehub_amp_delete_custom_title_section')){
    function rehub_amp_delete_custom_title_section( $file, $type, $post ) {
        if ( 'ampforwp-the-title' === $type ) {
            $file = rh_locate_template('amp/title-section.php');
        }
        elseif ( 'ampforwp-meta-info' === $type ) {
            $file = '' ;
        }   
        elseif ( 'ampforwp-comments' === $type ) {
            $file = rh_locate_template('amp/comments.php');
        }         
        return $file;
    }
}

add_action('ampforwp_inside_post_content_before', 'rehub_amp_add_custom_before_content' );
if(!function_exists('rehub_amp_add_custom_before_content')){
    function rehub_amp_add_custom_before_content(){
        include(rh_locate_template('amp/before-content.php'));
    }    
}

add_filter( 'amp_post_template_data', 'rehub_amp_disable_font' );
function rehub_amp_disable_font( $data ) {
    if (rehub_option('amp_disable_default') == 1){
        $data['font_urls'] = array();
    }
    return $data;
}

//FILTER FUNCTION FOR MDTF
if(class_exists('MetaDataFilter')){
    
    add_filter('rh_category_args_query', 'rh_module_args_filter');
    add_filter('rh_module_args_query', 'rh_module_args_filter');
    add_action('rh_after_module_args_query', 'rh_module_args_filter_after');
    add_action('rh_after_category_args_query', 'rh_module_args_filter_after');

    if (!function_exists('rh_module_args_filter')){
        function rh_module_args_filter($args){
            $additional_tax_query_array = array();
            if (is_category()){
                $catID = get_query_var( 'cat' );
                $additional_tax_query_array[] = array(
                    'taxonomy' => 'category',
                    'field' => 'term_id',
                    'terms' => array($catID)
                );
                $_REQUEST['MDF_ADDITIONAL_TAXONOMIES'] = $additional_tax_query_array;               
            } 
            if(is_tax('dealstore')){
                $tagid = get_queried_object()->term_id;
                $additional_tax_query_array[] = array(
                    'taxonomy' => 'dealstore',
                    'field' => 'term_id',
                    'terms' => array($tagid)
                );
                $_REQUEST['MDF_ADDITIONAL_TAXONOMIES'] = $additional_tax_query_array;                 
            }             
            if(MetaDataFilter::is_page_mdf_data()){   
                $_REQUEST['mdf_do_not_render_shortcode_tpl'] = true;
                $_REQUEST['mdf_get_query_args_only'] = true;
                do_shortcode('[meta_data_filter_results]');
                $args = $_REQUEST['meta_data_filter_args']; 
            }
            return $args;
        }
    }
    if (!function_exists('rh_module_args_filter_after')){
        function rh_module_args_filter_after($wp_query){           
            if(MetaDataFilter::is_page_mdf_data()){
                $_REQUEST['meta_data_filter_found_posts']=$wp_query->found_posts;
            }
        }
    }   
}
