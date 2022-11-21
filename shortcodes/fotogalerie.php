<?php

$folder = $shortcode->getParameter("folder");

$folder = "upload/source/$folder";

$files = scandir($folder);

echo "<div class='photos' id='galerie-swiper'>";
foreach ($files as $file)
{
    // preskocit files co nas nezajimaji
    if ($file[0] == ".")
    {
        continue;
    }

    $path = "$folder/$file";
    $info = pathinfo($path);
    if ($info["extension"] == "jpg")
    {
        $dimensions = getimagesize($path);
        $width = $dimensions[0];
        $height = $dimensions[1];
        echo "
            <a href='$path' data-pswp-width=$width data-pswp-height=$height>
            <img src='$path' height=200>
            </a>";
    }
}
echo "</div>";

?>
<script type="module">
import PhotoSwipeLightbox from './vendor/photoswipe/dist/photoswipe-lightbox.esm.js';
const lightbox = new PhotoSwipeLightbox({
  gallery: '#galerie-swiper',
  children: 'a',
  pswpModule: () => import('./vendor/photoswipe/dist/photoswipe.esm.js')
});
lightbox.init();
</script>