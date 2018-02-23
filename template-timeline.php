<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php /* Template Name: Timeline */ ?>
<?php get_header(); ?>

<?php
/* Post monthly archive function.
 ----------
 * Settings:
 * $show_comment_count(0) - show number of comments. 1 - show.
 * $before ('<h4>') - HTML tag before title (month).
 * $after ('</h4>') - HTML tag after title.
 * $year (0) - show only one year. If set 2009, only post for this year will be visible
 * $post_type ('post') - post tyle
 * $limit(100) - limit number of posts by one month. If you have big amount of posts - it will be very high  load on DB. Set 0 - if no limits.
 ----------
 Пример вызова: <php echo get_blix_archive(1, '<h4>', '</h4>'); ?>
*/
function get_blix_archive($show_comment_count=0, $before='<h4>', $after='</h4>', $year=0, $post_type='post', $limit=100){
    global $month, $wpdb;
    $result = '';
    if($year) $AND_year = " AND YEAR(post_date)='$year'";
    if($limit) $LIMIT = " LIMIT $limit";
    $arcresults = $wpdb->get_results("SELECT DISTINCT YEAR(post_date) AS year, MONTH(post_date) AS month, count(ID) as posts FROM " . $wpdb->posts . " WHERE post_type='$post_type' $AND_year AND post_status='publish' GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC");
    if($arcresults){
        foreach($arcresults as $arcresult){
            $url  = get_month_link($arcresult->year, $arcresult->month);
            $text = sprintf('%s %d', $month[zeroise($arcresult->month,2)], $arcresult->year);
            $result .= get_archives_link($url, $text, '', $before, $after);
            $thismonth = zeroise($arcresult->month,2);
            $thisyear = $arcresult->year;
                $arcresults2 = $wpdb->get_results("SELECT ID, post_date, post_title, comment_status, guid, comment_count FROM " . $wpdb->posts . " WHERE post_date LIKE '$thisyear-$thismonth-%' AND post_status='publish' AND post_type='$post_type' AND post_password='' ORDER BY post_date DESC $LIMIT");

            if ($arcresults2){
                $result .= "<ul class=\"postspermonth\">\n";
                foreach ($arcresults2 as $arcresult2) {
                    if ($arcresult2->post_date != '0000-00-00 00:00:00') {
                        $url       =  get_permalink($arcresult2->ID); //$arcresult2->guid;
                        $arc_title = $arcresult2->post_title;

                        if ($arc_title) $text = strip_tags($arc_title);
                        else $text = $arcresult2->ID;

                        $result .= "<li>". get_archives_link($url, $text, '');
                        if($show_comment_count){
                            $cc = $arcresult2->comment_count;
                            if ($arcresult2->comment_status == "open" OR $comments_count > 0) $result .= " ($cc)";
                        }
                        $result .= "</li>\n";
                    }
                }
                $result .= "</ul>\n";
            }
        }
    }
    return $result;
}
?>

    <!-- CONTENT -->
<div class="rh-container"> 
    <div class="rh-content-wrap clearfix">
		      <!-- Main Side -->
              <div class="main-side page clearfix">
                <div class="title"><h1><?php the_title(); ?></h1></div>
                <article class="post" id="page-<?php the_ID(); ?>">				
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <div id="timeline_posts">
                        <?php echo get_blix_archive(0, '<h4>', '</h4>'); ?> 
                    </div>
                <?php endwhile; endif; ?>                
                </article>
                <?php comments_template(); ?>
			</div>	
            <!-- /Main Side -->  
            <!-- Sidebar -->
            <?php get_sidebar(); ?>
            <!-- /Sidebar --> 
        </div>
    </div>
    <!-- /CONTENT -->     
<!-- FOOTER -->
<?php get_footer(); ?>