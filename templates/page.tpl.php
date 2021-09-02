 <?php if($page['header_top_left'] || $page['header_top_right']): ?>
<div class="header-top">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <?php print render($page['header_top_left']); ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <?php print render($page['header_top_right']); ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php if ($logo || $site_name || $site_slogan || ($page['header']) || ($page['search_box'])): ?>
<div id="header"><!-- Header -->
    <div class="container">
        <div class="row header-first"><!-- Row 1 -->
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <?php if ($logo): ?>
                    <div id="logo"><a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><img src="<?php print $logo; ?>" alt="<?php print $site_name; ?>" role="presentation" /></a></div>
                <?php endif; ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                <?php if (($main_menu)): ?><!-- Main Menu -->
                    <div id="main-menu" class="clearfix">
                        <nav role="navigation" class="navbar navbar-default">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <!-- <a href="#" class="navbar-brand">Brand</a> -->
                            </div>
                            <div id="navbarCollapse" class="collapse navbar-collapse">
                                <?php if (($primary_nav) && empty($page['navigation'])): ?>
                                    <?php print render($primary_nav); ?><!-- /#primary-menu -->
                                <?php endif; ?>
                                <?php if (!empty($page['navigation'])): ?>
                                    <?php print render($page['navigation']); ?>
                                <?php endif; ?>
                            </div>
                        </nav>
                    </div>
                <?php endif; ?><!-- /Main Menu -->
                <?php print render($page['header']); ?>
            </div>                
        </div><!-- /Row 1 -->
    </div>
</div><!-- /Header -->
<?php endif; ?>
<div id="page-wrapper"><!-- Page Wrapper -->
    <?php if($page['main_slider']): ?>
    <div id="main-slider">
        <div  class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <?php print render($page['main_slider']); ?>
                </div>
            </div>
        </div>
    </div><!-- /main-slider -->
    <?php endif; ?>
    <?php if ($page['page_banner']): ?>
    <div id="page-banner">
        <div  class="container-fluid">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php print render($page['page_banner']); ?>
            </div>
        </div>
    </div><!-- /page-banner -->
    <?php endif; ?>

    <div class="container">
    <div id="main" class="clearfix"><!-- Main -->
       <?php if ($breadcrumb): ?>
            <div id="breadcrumb" class="row"><?php print $breadcrumb; ?></div>
        <?php endif; ?>

        <?php if ($page['main_top']): ?>
            <div id="main-top" class="row"><?php print render($page['main_top']); ?></div>
        <?php endif; ?>

        <?php if ($page['main_upper']): ?>
            <div id="main-upper" class="row"><?php print render($page['main_upper']); ?></div>
        <?php endif; ?>

        <div id="main-content" class="row"><!-- Main Content -->

            <?php if ($page['sidebar_first']): ?><!-- Sidebar First -->
                <div id="sidebar-first" class="sidebar <?php print $sidebar; ?>">
                    <?php print render($page['sidebar_first']); ?>
                </div>
            <?php endif; ?><!-- /Sidebar Firsrt -->

             <div id="content" class="<?php print $main_content; ?>"><!-- Content -->
                <div id="content-wrapper"><!-- Content Wrapper -->
                    <div id="content-head" class="row"><!-- Content Head -->
                        <div id="highlighted" class="clearfix"><?php print render($page['highlighted']); ?></div>
                        <?php print render($title_prefix); ?>
                        <?php if ($title): ?>
                                <div class="title-head">
                                    <h1 class="title" id="page-title"> <?php print $title; ?> </h1>
                                </div>
                        <?php endif; ?>
                        <?php print render($title_suffix); ?>                            
                        <?php if ($tabs): ?>
                            <div class="tabs"> <?php print render($tabs); ?> </div>
                        <?php endif; ?>
                        <?php if ($messages): ?>
                            <div id="messages" class="clearfix"><?php print $messages; ?></div>
                        <?php endif; ?>
                        <?php if ($page['help']): ?>
                            <div id="help" class="clearfix"> <?php print render($page['help']); ?> </div>
                        <?php endif; ?>
                        <?php if ($action_links): ?>
                            <ul class="action-links">
                              <?php print render($action_links); ?>
                            </ul>
                        <?php endif; ?>
                    </div><!-- /content-head -->

                    <?php if ($page['content_top']): ?>
                        <div id="content-top" class="row"> <?php print render($page['content_top']); ?> </div>
                    <?php endif; ?>

                    <?php if ($page['content_upper']): ?>
                        <div id="content-upper" class="row"> <?php print render($page['content_upper']); ?> </div>
                    <?php endif; ?>   

                    <?php if (($page['content']) || ($feed_icons)): ?>
                        <div id="content-body" class="row">
                            <?php print render($page['content']); ?> 
                            <?php print $feed_icons; ?> 
                        </div>
                    <?php endif; ?>

                    <?php if (($page['content_col2-1']) || ($page['content_col2-2'])): ?>
                        <div id="content-col2" class="row-fluid">
                            <?php if ($page['content_col2-1']): ?>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <div id="content-col2-1" class="span12 clearfix clear-row"> <?php print render($page['content_col2-1']); ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if ($page['content_col2-2']): ?>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div id="content-col2-2" class="span12 clearfix clear-row"> <?php print render($page['content_col2-2']); ?> </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($page['content_lower']): ?>
                        <div id="content-lower" class="row"><?php print render($page['content_lower']); ?></div>
                    <?php endif; ?>
        
                    <?php if ($page['content_bottom']): ?>
                        <div id="content-bottom" class="row"><?php print render($page['content_bottom']); ?></div>
                    <?php endif; ?>

                    <?php if ($page['sidebar_second']): ?>
                        <div id="sidebar-second" class="sidebar <?php print $sidebar; ?>">
                            <div class="row"><?php print render($page['sidebar_second']); ?></div>
                        </div><!-- /#sidebar-second -->
                    <?php endif; ?>
                    
                </div><!-- /Content Wrapper -->
            </div><!-- /Content -->
        </div><!-- /Main Content -->

        <?php if ($page['main_lower']): ?>
            <div id="main-lower" class="row"><?php print render($page['main_lower']); ?></div>
        <?php endif; ?>

        <?php if ($page['main_bottom']): ?>
            <div id="main-bottom" class="row"><?php print render($page['main_bottom']); ?></div>
        <?php endif; ?>                

    </div><!-- /Main -->
    </div>
</div><!-- /Page Wrapper -->
<?php if ($page['footer']): ?>
<div class="footer clearfix" role="contentinfo">
    <div class="container">
        <div class="row footer-content">
            <?php print render($page['footer']); ?>
        </div>
    </div>
</div>
<?php endif; ?><!-- /footer -->
<div class="page-bottom clearfix">
    <div class="container">
        <div class="row copyright-site-info">
            <div class="content">
        &copy <?php print date('Y'); ?> All rights reserved <?php print $copyright_site_name; ?> . Site By: <?php print $site_by; ?>
            </div>
        </div>
    </div>
</div>