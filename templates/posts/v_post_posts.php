<?

    $args = "cat=13&posts_per_page=10";

    query_posts($args);

?>


<div id="widget-news" class="pad-up">

<? if (have_posts()) : while (have_posts()) : the_post(); ?>

    <div <? post_class(); ?> class="layout-row" id="post-<? the_ID(); ?>">
        <div class="layout-col layout-col-full-width">

            <div class="layout-col-title">
                <span class="pull-left w60">
                    <a class="noajax" target="_blank" href="<? the_permalink(); ?>"><i class="fa fa-newspaper-o"></i> <? the_title(); ?></a>
                </span>
                <span class="pull-right">
                    <i class="fa fa-calendar"></i> <? the_date() ?>
                </span>

                <div class="clearer"></div>
            </div>
            <div class="padded">
                <? the_content() ?>
            </div>

            <div class="layout-col-footer">
                <span class="pull-right">
                    <i class="fa fa-user"></i> <? the_author() ?>
                </span>
                <div class="clearer"></div>
            </div>
        </div>
    </div>

<? endwhile; ?>

<? endif; ?>
    <div class="clearer"></div>
</div>