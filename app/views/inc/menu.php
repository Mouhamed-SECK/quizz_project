<?php 
$pages = array();
$pages["offnungszeiten.php"] = "Öffnungszeiten";
$pages["sauna.php"] = "Sauna";
$pages["frauensauna.php"] = "Frauensauna";
$pages["custom.php"] = "Beauty Lounge";
$pages["feiertage.php"] = "Feiertage";

$activePage = "offnungszeiten.php";


//menu.php
<?php foreach($pages as $url=>$title):?>
<li>
    <a <?php if($url === $activePage):?>class="active" <?php endif;?> href="<?php echo $url;?>">
        <?php echo $title;?>
    </a>
</li>

<?php endforeach;?>