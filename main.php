<?php
/**
 * DokuWiki Default Template
 *
 * This is the template you need to change for the overall look
 * of DokuWiki.
 *
 * You should leave the doctype at the very top - It should
 * always be the very first line of a document.
 *
 * @link   http://dokuwiki.org/templates
 * @author Andreas Gohr <andi@splitbrain.org>
 */

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();

if(plugin_isdisabled('jquery')) msg('KeckCAVES template requires jQuery plugin.', -1);

// Utterly taken from tpl_searchform, but allows using an image
// for the search button.
function kc_searchform($ajax=true,$autocomplete=true){
    global $lang;
    global $ACT;
    global $QUERY;

    // don't print the search form if search action has been disabled
    if (!actionOk('search')) return false;

    print '<form action="'.wl().'" accept-charset="utf-8" class="search" id="dw__search" method="get"><div class="no">';
    print '<input type="hidden" name="do" value="search" />';
    print '<input type="text" ';
    if($ACT == 'search') print 'value="'.htmlspecialchars($QUERY).'" ';
    if(!$autocomplete) print 'autocomplete="off" ';
    print 'id="qsearch__in" accesskey="f" name="id" class="edit" title="[F]" />';
    print '<input type="image" alt="'.$lang['btn_search'].'" class="button" title="'.$lang['btn_search'].'" src="'.DOKU_TPL.'images/search.png" />';
    if($ajax) print '<div id="qsearch__out" class="ajax_qsearch JSpopup"></div>';
    print '</div></form>';
    return true;
}

global $ACT; // Needed for template content conditional on current action
global $ID; 
global $INFO;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $conf['lang']?>"
 lang="<?php echo $conf['lang']?>" dir="<?php echo $lang['direction']?>">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>
    <?php tpl_pagetitle()?>
    [<?php echo strip_tags($conf['title'])?>]
  </title>

  <?php tpl_metaheaders()?>

  <link rel="shortcut icon" href="<?php echo DOKU_TPL?>images/favicon.ico" />
</head>

<body>
<div class="dokuwiki">
  <?php html_msgarea()?>

  <div class="stylehead">

    <div class="header">
      <div class="logo">
        <?php tpl_link(wl(),'<img alt="'.$conf['title'].'" src="'.DOKU_TPL.'images/keckcaves_banner.png'.'"/>','name="dokuwiki__top" id="dokuwiki__top" accesskey="h" title="[H]"')?>
      </div>

      <div class="clearer"></div>

    <?php if($INFO['userinfo']){?>
        <ul id="kc_menu">
          <?php if($r=tpl_actionlink('edit','','','',true))echo'<li>'.$r.'</li>'?>
          <?php if($r=tpl_actionlink('history','','','',true))echo'<li>'.$r.'</li>'?>
          <?php if($r=tpl_actionlink('revert','','','',true))echo'<li>'.$r.'</li>'?>
          <?php if($r=tpl_actionlink('subscribe','','','',true))echo'<li>'.$r.'</li>'?>
          <?php if($r=tpl_actionlink('profile','','','',true))echo'<li>'.$r.'</li>'?>
          <?php if($r=tpl_actionlink('admin','','','',true))echo'<li>'.$r.'</li>'?>
          <?php if($r=tpl_actionlink('login','',' '.hsc($INFO['userinfo']['name']),'',true))echo'<li>'.$r.'</li>'?>
        </ul>
     <?php }else{?>
      <div class="user">
        <?php tpl_actionlink('login')?>
      </div>
     <?php }?>

    </div>

    <div class="bar" id="bar__top">
      <div class="bar-left" id="bar__topleft">
        <?php tpl_include_page(tpl_getConf('tabs'))?>
      </div>

      <div class="bar-right" id="bar__topright">
        <?php kc_searchform()?>&nbsp;
      </div>

      <div class="clearer"></div>
    </div>

    <?php if($conf['breadcrumbs']){?>
    <div class="breadcrumbs">
      <?php tpl_breadcrumbs()?>
    </div>
    <?php }?>

    <?php if($conf['youarehere']){?>
    <div class="breadcrumbs">
      <?php tpl_youarehere() ?>
    </div>
    <?php }?>

  </div>
  <?php tpl_flush()?>

  <div class="page <?php echo $ACT?> <?php if($ID==$conf['start']) echo 'start';?>">
    <!-- wikipage start -->
    <?php tpl_content()?>
    <!-- wikipage stop -->
    <div class="meta">
      <?php $return=tpl_pageinfo(true); if($ACT=='show' && $return) tpl_actionlink('edit','','',$return);?>
    </div>
  </div>

  <div class="clearer">&nbsp;</div>

  <?php tpl_flush()?>

  <div class="stylefoot">

  </div>

  <?php tpl_license(' ');?>

</div>

<?php
if ($conf['allowdebug']) {
    echo '<!-- page made in '.round(delta_time(DOKU_START_TIME), 3).' seconds -->';
}
?>

<div class="no"><?php /* provide DokuWiki housekeeping, required in all templates */ tpl_indexerWebBug()?></div>
</body>
</html>
