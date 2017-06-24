<script type="text/javascript" src="<?php echo  plugins_url( 'slider-ds/libs/angular.min.js' ); ?>"></script>
<script type="text/javascript" src="<?php echo  plugins_url( 'slider-ds/libs/slider.controller.js' ); ?>"></script>
<script type="text/javascript" src="<?php echo  plugins_url( 'slider-ds/libs/jquery.min.js' ); ?>"></script>
<link rel="stylesheet" href="<?php echo plugins_url( 'slider-ds/libs/slider.face.css' ); ?>">
<?php wp_enqueue_script('media-upload');  wp_enqueue_script('thickbox');  wp_enqueue_style('thickbox'); ?>
<script>var URLTEMPLATE="<?php echo  plugins_url( 'slider-ds/' ); ?>";</script>
<div class="container" ng-app="slidersApp">
<div ng-controller="silersController">
	<div class="navbar">
		<ul class="navbar-menu">
		<li><img src="<?php echo plugins_url( 'slider-ds/' ); ?>drawable/menu.svg" alt="Administrar banners">{{bannSelected}}
			<ul>
				<li><input type="text" placeholder="Nombre de banner" ng-model="nameNewBanner"><div class="add-img" ng-click="addBanner()"><img src="<?php echo plugins_url( 'slider-ds/' ); ?>drawable/add.svg" pleaceholder="Nombre de slider" alt="add slider"></div></li>
				<li ng-repeat="ban in banners"><a href="#" ng-click="loadBanner(ban)" title="{{ban.slug}}">{{ban.NAME}}</a><img ng-click="removeBanner(ban)" src="<?php echo plugins_url( 'slider-ds/' ); ?>drawable/remove.svg" title="Remover banner"></li>
			</ul>
		</li>
		<li><img src="<?php echo plugins_url( 'slider-ds/' ); ?>drawable/menu.svg" alt="Administrar sliders">{{sliderSelected}}
			<ul>
				<li><input type="text" placeholder="Nombre de slider" ng-model="newNameSlider"><div ng-click="addSlider()" class="add-img"><img src="<?php echo plugins_url( 'slider-ds/' ); ?>drawable/add.svg" pleaceholder="Nombre de slider" alt="add slider"></div></li>
				<li ng-repeat="ss in sliders | orderBy: 'order'"><a href="#" ng-click="loadslider(ss)">{{ss.name}}</a><img src="<?php echo plugins_url( 'slider-ds/' ); ?>drawable/remove.svg" alt="Remover slider" ng-click="removeSlider(ss)"></li>
			</ul>
		</li>
		</ul>
	</div>


	<div class="well">
		<div class="min-bar">
		<button class="button" ng-click="sliderEdited={}">Cerrar</button>	
		<button class="button button-primary" ng-click="saveSlider()">Guardar</button>	
		<button class="button" ng-click="openGal()"><img src="<?php echo plugins_url( 'slider-ds/' ); ?>drawable/image.svg" title="Cambiar imagen"></button>	
		<button class="button" ng-class="{'button-primary':sliderEdited.align=='left'}" ng-click="sliderEdited.align='left'"><img src="<?php echo plugins_url( 'slider-ds/' ); ?>drawable/left.svg" title="Cambiar imagen"></button>	
		<button class="button" ng-class="{'button-primary':sliderEdited.align=='center'}" ng-click="sliderEdited.align='center'"><img src="<?php echo plugins_url( 'slider-ds/' ); ?>drawable/center.svg" title="Cambiar imagen"></button>	
		<button class="button" ng-class="{'button-primary':sliderEdited.align=='right'}" ng-click="sliderEdited.align='right'"><img src="<?php echo plugins_url( 'slider-ds/' ); ?>drawable/right.svg" title="Cambiar imagen"></button>	
		<input ng-model="sliderEdited.order" placeholder="Order" type="text"  size="10" aria-required="true">
		<input ng-model="sliderEdited.name" placeholder="Nombre del slider" type="text"  size="40" aria-required="true">
		<textarea rows="1" placeholder="Descripcion de slider" class="textarea-expanded" required="required" ng-model="sliderEdited.content" aria-required="true"></textarea>
		</div>
		<div class="slider-cover" style="background-image:url('{{sliderEdited.image}}');">
			<div class="caption {{sliderEdited.align}}" ng-hide="sliderEdited.name=='' || sliderEdited.name==undefined">
				<h3>{{sliderEdited.name}}</h3>
				<span ng-inner="sliderEdited.content"></span>
			</div>
		</div>
	</div>
	<p>Las dimenciones y los estilos de los banners estan sujetos a la maquetación del template que se aplica.</p>
	</div>
</div>
