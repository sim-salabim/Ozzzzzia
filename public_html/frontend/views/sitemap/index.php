<?= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <? foreach($links as $link){?>
    <sitemap>
        <loc><?= $link->link ?></loc>
    </sitemap>
    <? } ?>
</sitemapindex>