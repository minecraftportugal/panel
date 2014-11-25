
<?= WP_ENABLED ?>

<? if (WP_ENABLED): ?>
    <div id="news" class="section">
        <h2>Notícias</h2>
        <?
        $posts = get_posts('numberposts=10&order=desc&orderby=post_date');
        foreach ($posts as $post) : setup_postdata( $post );
            ?>
            <div class="section2 pushd2">
                <h3><a href="<?= get_permalink($post->ID) ?>" target="_blank"><?= get_the_time("F j, Y", $post->ID); ?>: <?= get_the_title($post->ID); ?></a></h3>
                <p><?= get_the_excerpt($post->ID); ?></p>
            </div>
        <?
        endforeach;
        ?>
    </div>
<? endif; ?>