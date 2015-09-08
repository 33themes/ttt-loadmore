# TTT Loadmore #
**Contributors:** 33themes, gabrielperezs, lonchbox, tomasog  
**Tags:** loadmore, pagination, posts pagination, core pagination, vertical pagination, posts per page, pagination animation  
**Requires at least:** 3.7  
**Tested up to:** 4.3  
**Stable tag:** 1.1.1 
**License:** GPLv2  
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html  


WordPress plugin to loadmore event with your own template

## Description ##

WordPress plugin to loadmore event with your own template.

So code contributions please go to https://github.com/33themes/ttt-loadmore

### Whow to use ###

*The base html is like this:*

```
<a href="#" data-tttloadmore-do="archiveposts" data-tttloadmore-to="#main" data-tttloadmore-args="category:php;">
    Load more content
</a>
```

*data-tttloadmore-do* is the action to load more content
*data-tttloadmore-to* is where the script put the content after load more posts (the result of the "do" action)
*data-tttloadmore-args* is all the arguments want to send to the "do" action

*Then, you have to create a action with the same name of the data-tttloadmore-do*

``` 
<?php
function loadmore_archiveposts( $page, $args = false ){

    $archiveposts = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'order' => 'DESC',
        'orderby' => 'date',
        'paged' => $page,
        'ignore_sticky_posts' => 1,
        'category_name' => $args['category'],
    );
    $archiveposts_query = new WP_Query($archiveposts);
    ?>

    <?php if ($archiveposts_query->have_posts()) : ?>
        <?php while ($archiveposts_query->have_posts()) : $archiveposts_query->the_post(); ?>
                <?php get_template_part( 'partials/content', 'content' ); ?>
        <?php wp_reset_postdata();?>
        <?php endwhile; ?>
    <?php endif;?>
    
    <?
}
add_action('ttt_loadmore_archiveposts','loadmore_archiveposts', 1, 2);
?>
``` 

## Changelog ##

### 1.1 ###
Remove assets from the main file

### 1.0 ###
First version

## Installation ##

This section describes how to install the plugin and get it working.

e.g.

1. Upload `ttt-loadmore` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

