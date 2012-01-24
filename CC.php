<?php
/**
 * MonoBook nouveau
 *
 * Translated from gwicke's previous TAL template version to remove
 * dependency on PHPTAL.
 *
 * @todo document
 * @file
 * @ingroup Skins
 */

if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 * @todo document
 * @ingroup Skins
 */
class SkinCC extends SkinTemplate {
	/** Using monobook. */
	function initPage( OutputPage $out ) {
		parent::initPage( $out );
		$this->skinname  = 'cc';
		$this->stylename = 'cc';
		$this->template  = 'CC';

	}
	
}

/**
 * @todo document
 * @ingroup Skins
 */
class CC extends QuickTemplate {
		var $skin;

	function cleanTitle($whichTitle = 'title') {
		global $wgRequest;
		if ($slashPos = strpos($this->data[$whichTitle], "/")) {
			return substr_replace($this->data[$whichTitle], "", 0, $slashPos + 1);
		}
		return $this->data[$whichTitle];
	}
	/**
	 * Template filter callback for MonoBook skin.
	 * Takes an associative array of data set from a SkinTemplate-based
	 * class, and a wrapper for MediaWiki's localization database, and
	 * outputs a formatted page.
	 *
	 * @access private
	 */
	function execute() {
		global $wgRequest;
		$this->skin = $skin = $this->data['skin'];
		$action = $wgRequest->getText( 'action' );
    
    // check if TOC is present
    $hasToc = strpos($this->data['bodytext'], 'id="toc"');
    
		// Suppress warnings to prevent notices about missing indexes in $this->data
		wfSuppressWarnings();

    // adaptor code for cc-wp theme
    if ( ! function_exists('bloginfo') ) {
        function bloginfo ($param) {
            if ( $param == 'home' )
                echo 'http://creativecommons.org';
            if ( $param == 'stylesheet_directory' ) {
                echo '/skins/cc/cc-wp';
                // echo $this->text('stylepath') . '/cc-wp';
            }
        }
    }
    if ( ! function_exists('get_http_security') ) {
        function get_http_security () {
            echo 'https';
        }
    }
    include 'cc-wp/meta.php';
    include 'cc-wp/header-doctype.php';
    // var_dump($this);
?>
<html <?php
	foreach($this->data['xhtmlnamespaces'] as $tag => $ns) {
		?>xmlns:<?php echo "{$tag}=\"{$ns}\" ";
	} ?>xml:lang="<?php $this->text('lang') ?>" lang="<?php $this->text('lang') ?>" dir="<?php $this->text('dir') ?>">
	<head>
		<meta http-equiv="Content-Type" content="<?php $this->text('mimetype') ?>; charset=<?php $this->text('charset') ?>" />
        <?php include 'cc-wp/header-common.php'; ?>
		<?php $this->html('headlinks')?> 
		<title><?php if ($this->data['title'] != 'Main Page') { echo $this->cleanTitle('pagetitle'); ?><?php } else { ?>Creative Commons Wiki <?php } ?></title>
		<?php $this->html('csslinks') ?>

		<!--[if lt IE 7]><script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('stylepath') ?>/common/IEFixes.js?<?php echo $GLOBALS['wgStyleVersion'] ?>"></script>
		<meta http-equiv="imagetoolbar" content="no" /><![endif]-->

    <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.5.2/build/container/assets/skins/sam/container.css" /> 
    <script type="text/javascript" src="http://yui.yahooapis.com/2.5.2/build/yahoo-dom-event/yahoo-dom-event.js"></script> 
    <script type="text/javascript" src="http://yui.yahooapis.com/2.5.2/build/animation/animation-min.js"></script> 
    <script type="text/javascript" src="http://yui.yahooapis.com/2.5.2/build/container/container-min.js"></script>
    
    <link rel="stylesheet" type="text/css" media="screen" href="<?php $this->text('stylepath') ?>/cc/standard.css" />

		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('stylepath' ) ?>/common/wikibits.js?<?php echo $GLOBALS['wgStyleVersion'] ?>"><!-- wikibits js --></script>
		<!-- Head Scripts -->
<?php $this->html('headscripts') ?>
<?php	if($this->data['jsvarurl']) { ?>
		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('jsvarurl') ?>"><!-- site js --></script>
<?php	} ?>
<?php	if($this->data['pagecss']) { ?>
		<style type="text/css"><?php $this->html('pagecss') ?></style>
<?php	}
		if($this->data['usercss']) { ?>
		<style type="text/css"><?php $this->html('usercss') ?></style>
<?php	}
		if($this->data['userjs']) { ?>
		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('userjs' ) ?>"></script>
<?php	}
		if($this->data['userjsprev']) { ?>
		<script type="<?php $this->text('jsmimetype') ?>"><?php $this->html('userjsprev') ?></script>
<?php	}
		if($this->data['trackbackhtml']) print $this->data['trackbackhtml']; ?>
	</head>
<body<?php if($this->data['body_ondblclick']) { ?> ondblclick="<?php $this->text('body_ondblclick') ?>"<?php } ?>
<?php if($this->data['body_onload']) { ?> onload="<?php $this->text('body_onload') ?>"<?php } ?>
 class="yui-skin-sam ccPage mediawiki <?php $this->text('dir') ?> <?php $this->text('pageclass') ?> <?php $this->text('skinnameclass') ?>">
	<div id="container">
        <?php include 'cc-wp/page-nav.php'; ?>
        <div id="main" role="main">
            <div class="container">
                <div class="sixteen columns">

   <div id="mainContent" class="box">
     <!-- toolboxes -->
     <div id="pageNav">
		   <ul id="t-page">
    <li id='mainpage'><a href="<?php echo $this->data['nav_urls']['mainpage']['href']; ?>">CC Wiki Home</a></li>
   	<?php		foreach($this->data['content_actions'] as $key => $tab) {
   					echo '
   				 <li id="' . Sanitizer::escapeId( "ca-$key" ) . '"';
   					if( $tab['class'] ) {
   						echo ' class="'.htmlspecialchars($tab['class']).'"';
   					}
   					echo'><a href="'.htmlspecialchars($tab['href']).'"';
   					# We don't want to give the watch tab an accesskey if the
   					# page is being edited, because that conflicts with the
   					# accesskey on the watch checkbox.  We also don't want to
   					# give the edit tab an accesskey, because that's fairly su-
   					# perfluous and conflicts with an accesskey (Ctrl-E) often
   					# used for editing in Safari.
   				 	if (
						in_array( $action, array( 'edit', 'submit' ) ) &&
   				 		in_array( $key, array( 'edit', 'watch', 'unwatch' ) )
					) {
   				 		echo $this->skin->tooltip( "ca-$key" );
   				 	} else {
						echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs( "ca-$key" ) );
   				 	}
   				 	echo '>'.htmlspecialchars($tab['text']).'</a></li>';
   				} ?>
   		 </ul>      
   		   
   		 <?php if (!$this->data['personal_urls']['login']) { ?>
       <ul id="t-personal">
   <?php 			foreach($this->data['personal_urls'] as $key => $item) { ?>
   				<li id="<?php echo Sanitizer::escapeId( "pt-$key" ) ?>"<?php
   					if ($item['active']) { ?> class="active"<?php } ?>><a href="<?php
   				echo htmlspecialchars($item['href']) ?>"<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs('pt-'.$key)) ?><?php
   				if(!empty($item['class'])) { ?> class="<?php
   				echo htmlspecialchars($item['class']) ?>"<?php } ?>><?php
   				echo htmlspecialchars($item['text']) ?></a></li>
   <?php			} ?>
   		 </ul>
       <?php } ?>
       
       <ul id="t-toolbox">

         		<?php if($this->data['notspecialpage']) { ?>
         				<li id="t-whatlinkshere"><a href="<?php
         				echo htmlspecialchars($this->data['nav_urls']['whatlinkshere']['href'])
         				?>"<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs('t-whatlinkshere')) ?>><?php $this->msg('whatlinkshere') ?></a></li>
         <?php
         			if( $this->data['nav_urls']['recentchangeslinked'] ) { ?>
         				<li id="t-recentchangeslinked"><a href="<?php
         				echo htmlspecialchars($this->data['nav_urls']['recentchangeslinked']['href'])
         				?>"<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs('t-recentchangeslinked')) ?>><?php $this->msg('recentchangeslinked') ?></a></li>
         <?php 		}
         		}
         		if(isset($this->data['nav_urls']['trackbacklink'])) { ?>
         			<li id="t-trackbacklink"><a href="<?php
         				echo htmlspecialchars($this->data['nav_urls']['trackbacklink']['href'])
         				?>"<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs('t-trackbacklink')) ?>><?php $this->msg('trackbacklink') ?></a></li>
         <?php 	}
         		if($this->data['feeds']) { ?>
         			<li id="feedlinks"><?php foreach($this->data['feeds'] as $key => $feed) {
         					?><span id="<?php echo Sanitizer::escapeId( "feed-$key" ) ?>"><a href="<?php
         					echo htmlspecialchars($feed['href']) ?>"<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs('feed-'.$key)) ?>><?php echo htmlspecialchars($feed['text'])?></a>&nbsp;</span>
         					<?php } ?></li><?php
         		}
                echo '<li><a href="http://wiki.creativecommons.org/Special:Recentchanges">Recent Changes</a></li>';
         		foreach( array('contributions', 'log', 'blockip', 'emailuser', 'upload', 'specialpages') as $special ) {

         			if($this->data['nav_urls'][$special]) {
         				?><li id="t-<?php echo $special ?>"><a href="<?php echo htmlspecialchars($this->data['nav_urls'][$special]['href'])
         				?>"<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs('t-'.$special)) ?>><?php $this->msg($special) ?></a></li>
         <?php		}
         		}

         		if(!empty($this->data['nav_urls']['print']['href'])) { ?>
         				<li id="t-print"><a href="<?php echo htmlspecialchars($this->data['nav_urls']['print']['href'])
         				?>"<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs('t-print')); ?>><?php $this->msg('printableversion') ?></a></li><?php
         		}

         		if(!empty($this->data['nav_urls']['permalink']['href'])) { ?>
         				<li id="t-permalink"><a href="<?php echo htmlspecialchars($this->data['nav_urls']['permalink']['href'])
         				?>"<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs('t-permalink')) ?>><?php $this->msg('permalink') ?></a></li><?php
         		} elseif ($this->data['nav_urls']['permalink']['href'] === '') { ?>
         				<li id="t-ispermalink"<?php echo $this->skin->tooltip('t-ispermalink') ?>><?php $this->msg('permalink') ?></li><?php
         		}

         		wfRunHooks( 'MonoBookTemplateToolboxEnd', array( &$this ) );
         		wfRunHooks( 'SkinTemplateToolboxEnd', array( &$this ) );
         ?>
       </ul>
     </div>
     
     <!-- page title -->
     <div class="block" id="title">
 	    <div class="sideitem">
         <form method="get" id="searchform" action="<?php $this->text('searchaction') ?>">
           <div>
             <input type="text" 
              <?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs('search'));
     					if( isset( $this->data['search'] ) ) {
     						?> value="<?php $this->text('search') ?>" <?php } ?> 
     				  name="search" id="search" class="inactive" /> <input type="submit" id="searchsubmit" value="Go" />
           </div>
         </form>
         <?php if ($this->data['personal_urls']['login']) { ?>
		 <span><a href="<?php echo $this->data['personal_urls']['login']['href']; ?>">Log in / create account</a></span>
         <span>(<a href="/Special:OpenIDLogin">OpenID</a>)</span>
         <?php } ?>
	   </div>
	   <div id="contentSub"><h3 class="category"><?php echo str_replace("&lt; ", "", $this->data['subtitle']) ?></h3></div> 
       <?php
       if ($this->data['title'] != 'Main Page') {
		 ?><h1><?php /*$this->data['displaytitle']!=""?$this->html('title'):$this->text('title')*/ echo $this->cleanTitle();  ?></h1><?php
       } else {
         ?><h1>Creative Commons Wiki</h1><?php
       }
       ?>
 		</div>
     
    <!-- page content -->
    <div id="contentPrimary" class="<?php if (!$hasToc) {?>noToc<?php }?>">
	  <div class="block page">
        <?php if($this->data['sitenotice']) { ?><div id="siteNotice"><?php $this->html('sitenotice') ?></div><?php } ?>
    		
        <?php if($this->data['undelete']) { ?><div id="contentSub2"><?php     $this->html('undelete') ?></div><?php } ?>
   			<?php if($this->data['newtalk'] ) { ?><div class="usermessage"><?php $this->html('newtalk')  ?></div><?php } ?>
   			<!-- start content -->
   			<?php $this->html('bodytext') ?>
   			<?php if($this->data['catlinks']) { $this->html('catlinks'); } ?>
   			<!-- end content -->
   			<?php if($this->data['dataAfterContent']) { $this->html ('dataAfterContent'); } ?>
      </div>
    </div>
   </div>

       <ul id="footmeta">
    	  <?php if($this->data['about'     ]) { ?><li><?php      $this->html('about')      ?></li><?php } ?>
          <?php
       	  if($this->data['lastmod'   ]) { ?><li><?php    $this->html('lastmod')    ?></li><?php } ?>
       </ul>
                </div>
            </div><!--! end of .container -->
		</div><!--! end of #main -->

<?php include 'cc-wp/page-footer.php'; ?>
    </div> <!--! end of #container -->
<?php include 'cc-wp/footer-codes.php'; ?>
   
 <?php $this->html('bottomscripts'); /* JS call to runBodyOnloadHook */ ?>
 <?php $this->html('reporttime'); ?>
 <?php if ( $this->data['debug'] ) { ?>
 <!-- Debug output:
 <?php $this->text( 'debug' ); ?>

 -->
 <?php } ?>
</body></html>
<?php
	} // end of execute() method

} // end of class
?>
