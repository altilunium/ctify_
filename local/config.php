<?php if (!defined('PmWiki')) exit();
include_once("scripts/xlpage-utf-8.php");
$WikiTitle = "ctify";
$PageLogoUrl = "https://pbs.twimg.com/profile_images/1716831335724326912/8ujZJHcJ_400x400.jpg";

$DefaultPasswords['admin'] = pmcrypt('yourpasswordhere');
$EnableUpload = 1;
//$DefaultPasswords['upload'] = pmcrypt('yourpasswordhere');
$DefaultPasswords['upload'] = '';


$TimeFmt = '%B %d, %Y, at %I:%M %p %Z';

$EnablePathInfo = 1;
$ScriptUrl = $UrlScheme.'://'.$_SERVER['HTTP_HOST'];
$Skin = 'pmwiki-responsive';

include_once("$FarmD/scripts/authuser.php");
$DefaultPasswords['edit'] = array('@admins', 'id:*');
//$DefaultPasswords['edit'] = '';
date_default_timezone_set('Asia/Jakarta');
$EnableWikiWords = 0;
$SpaceWikiWords = 1;
$PmTOC['Enable'] = 1;

$HTMLHeaderFmt['folder-js'] = "<script src='\$PubDirUrl/custom.js'></script>";
$HTMLHeaderFmt['folder-css'] = "<link rel='stylesheet' href='\$PubDirUrl/custom.css'>";

// Define the [[folder:Title]] opening tag
Markup('folder-open', 'directives',
    '/\\[\\[folder:(.*?)\\]\\]/i',
    function($m) {
        $title = htmlspecialchars(trim($m[1]), ENT_QUOTES);
        return Keep("<details class='tvt-folder'>\n<summary><span class='folder-icon'>&#128193;</span> {$title}</summary>\n<div class='folder-content'>\n");
    }
);

// Define the [[/folder]] closing tag
Markup('folder-close', 'directives',
    '/\\[\\[\/folder\\]\\]/i',
    function($m) {
        return Keep("\n</div>\n</details>");
    }
);

Markup('quoteright', 'inline',
  '/\[\[quoteright:(\d+):([^\]]+)\]\]/',
  function($m) {
    $width = $m[1];
    $url = $m[2];
    // We use a standard container; you can adjust the padding-top 
    // or remove it if you prefer a simpler box.
    return Keep('<div class="quoteright" style="width:'.$width.'px;">
                    <div class="lazy_load_img_box" >
                        <img src="'.$url.'" class="embeddedimage" border="0" width="'.$width.'">
                    </div>
                 </div>');
  }
);

Markup(
    'caption-width-right',             // Unique ID for this markup rule
    'inline',                          // When to process this (inline formatting)
    '/\[\[caption-width-right:(\d+):(.*?)\]\]/', // The Regex pattern to match
    '<div class="acaptionright" style="width:$1px;">$2</div>' // The HTML replacement
);

Markup('ref', 'fulltext',
  '/\\[\\[ref\\]\\](.*?)\\[\\[\\/ref\\]\\]/is',
  function($m) {
    static $refcount = 0;
    $refcount++;

    //$content = htmlspecialchars($m[1], ENT_QUOTES);
    $content = $m[1];
    return "<sup class=\"pm-ref\" data-ref=\"$content\">[$refcount]</sup>";
  }
);
