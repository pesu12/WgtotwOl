<!doctype html>
<html class='no-js summer rain' lang='<?=$lang?>'>
<head>
<meta charset='utf-8'/>
<title><?=$title_append?></title>
<?php if(isset($favicon)): ?><link rel='icon' href='<?=$this->url->asset($favicon)?>'/><?php endif; ?>
<?php foreach($stylesheets as $stylesheet): ?>
<link rel='stylesheet' type='text/css' href='<?=$this->url->asset($stylesheet)?>'/>
<?php endforeach; ?>
<?php if(isset($style)): ?><style><?=$style?></style><?php endif; ?>
<script src='<?=$this->url->asset($modernizr)?>'></script>
</head>

<body>

<div id='wrapper'>

<div id='header'>
<?php if(isset($header)) echo $header?>
<?php $this->views->render('header')?>
</div>

<?php if ($this->views->hasContent('navbar')) : ?>
<div id='navbar'>
<?php $this->views->render('navbar')?>
</div>
<?php endif; ?>

<?php if ($this->views->hasContent('flash')) : ?>
<div id='wrap-flash'>
  <div id='flash'><?php $this->views->render('flash')?></div>
</div>
<?php endif; ?>

<?php if ($this->views->hasContent('flashregion')) : ?>
<div id='wrap-flash'>
  <div id='flashregion'><?php $this->views->render('flashregion')?></div>
</div>
<?php endif; ?>

<?php if ($this->views->hasContent('featured-1', 'featured-2', 'featured-3')) : ?>
<div id='wrap-featured'>
    <div id='featured-1'><?php $this->views->render('featured-1')?></div>
    <div id='featured-2'><?php $this->views->render('featured-2')?></div>
    <div id='featured-3'><?php $this->views->render('featured-3')?></div>
</div>
<?php endif; ?>

<?php if ($this->views->hasContent('featuredregion-1', 'featuredregion-2', 'featuredregion-3')) : ?>
<div id='wrap-featured'>
    <div id='featuredregion-1'><?php $this->views->render('featuredregion-1')?></div>
    <div id='featuredregion-2'><?php $this->views->render('featuredregion-2')?></div>
    <div id='featuredregion-3'><?php $this->views->render('featuredregion-3')?></div>
</div>
<?php endif; ?>

<?php if ($this->views->hasContent('main','sidebar')) : ?>
<div id='wrap-main'>
    <div id='main'><?php $this->views->render('main')?></div>
    <div id='sidebar'><?php $this->views->render('sidebar')?></div>
</div>
<?php endif; ?>

<?php if ($this->views->hasContent('mainregion','sidebarregion')) : ?>
<div id='wrap-main'>
    <div id='mainregion'><?php $this->views->render('mainregion')?></div>
    <div id='sidebarregion'><?php $this->views->render('sidebarregion')?></div>
</div>
<?php endif; ?>

<?php if ($this->views->hasContent('triptych-1', 'triptych-2', 'triptych-3')) : ?>
<div id='wrap-triptych'>
    <div id='triptych-1'><?php $this->views->render('triptych-1')?></div>
    <div id='triptych-2'><?php $this->views->render('triptych-2')?></div>
    <div id='triptych-3'><?php $this->views->render('triptych-3')?></div>
</div>
<?php endif; ?>

<?php if ($this->views->hasContent('triptychregion-1', 'triptychregion-2', 'triptychregion-3')) : ?>
<div id='wrap-triptych'>
    <div id='triptychregion-1'><?php $this->views->render('triptychregion-1')?></div>
    <div id='triptychregion-2'><?php $this->views->render('triptychregion-2')?></div>
    <div id='triptychregion-3'><?php $this->views->render('triptychregion-3')?></div>
</div>
<?php endif; ?>

<?php if ($this->views->hasContent('footer-col-1', 'footer-col-2', 'footer-col-3')) : ?>
<div id='wrap-footer-col'>
    <div id='footer-col-1'><?php $this->views->render('footer-col-1')?></div>
    <div id='footer-col-2'><?php $this->views->render('footer-col-2')?></div>
    <div id='footer-col-3'><?php $this->views->render('footer-col-3')?></div>
</div>
<?php endif; ?>

<?php if ($this->views->hasContent('footer-colregion-1', 'footer-colregion-2', 'footer-colregion-3', 'footer-colregion-4')) : ?>
<div id='wrap-footer-col'>
    <div id='footer-colregion-1'><?php $this->views->render('footer-colregion-1')?></div>
    <div id='footer-colregion-2'><?php $this->views->render('footer-colregion-2')?></div>
    <div id='footer-colregion-3'><?php $this->views->render('footer-colregion-3')?></div>
    <div id='footer-colregion-4'><?php $this->views->render('footer-colregion-4')?></div>
</div>
<?php endif; ?>

<div id='footer'>
<?php if(isset($footer)) echo $footer?>
<?php $this->views->render('footer')?>
</div>
</br>
</br>
</div>

<?php if(isset($jquery)):?><script src='<?=$this->url->asset($jquery)?>'></script><?php endif; ?>

<?php if(isset($javascript_include)): foreach($javascript_include as $val): ?>
<script src='<?=$this->url->asset($val)?>'></script>
<?php endforeach; endif; ?>

<?php if(isset($google_analytics)): ?>
<script>
  var _gaq=[['_setAccount','<?=$google_analytics?>'],['_trackPageview']];
  (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
  g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
  s.parentNode.insertBefore(g,s)}(document,'script'));
</script>
<?php endif; ?>

</body>
</html>
