	angular.module("slidersApp",[])
	.directive("ngInner",function(){
		return {
		link:function(scope, element, attrs){
			
			scope.$watch(attrs.ngInner, function(value) {
		    	innnerVal(element,value);
		    });

			innnerVal(element,attrs.ngInner);
			
			function innnerVal(en,val){
				$(en).html(val);
			}
		}
	}
	})
	.controller("silersController",function($scope,$http){
		$scope.bannSelected="Seleccione un banner";
		$scope.sliderSelected="Seleccione un Slider";
		$scope.sliders=[];
		$scope.bannSelectedCod="";
		$scope.sliderEdited={};
		$scope.nameNewBanner="";
		
		$scope.loadBanners=function(){
			$http.get(URLTEMPLATE+"exe.php?ACTION=get_banners").success(function(dx){
				console.log(dx,'load banners');
				if(dx.status=="success"){
					$scope.banners=dx.data;
					if($scope.bannSelectedCod!=undefined && $scope.bannSelectedCod!=''){
						var ban=$scope.banners.filter(function(it){
							return it.COD==$scope.bannSelectedCod;
						});
						if(ban[0])
							$scope.loadBanner(ban[0]);
					}	
				}
			});
		};

		$scope.loadBanners();
		
		$scope.addBanner=function(){
			if($scope.nameNewBanner!=""){
				var data=JSON.stringify({"name":$scope.nameNewBanner});
				$http.post(URLTEMPLATE+"exe.php?ACTION=add_banner",data)
				.success(function(dx){
					console.log(dx);
					if(dx.status=="success"){
						$scope.banners.push({
							"COD":dx.data.ID_BAN,
							"NAME":dx.data.NAME,
							"sliders":[]
						});
						$scope.nameNewBanner="";
					}
				})
				.error(function(dx) {
					console.log(dx);
				});
			}else{
				alert("Ingrese el nombre del nuevo banner");
			}
		};

		$scope.addSlider=function(){
			if($scope.bannSelectedCod!=""){
				if($scope.newNameSlider!="" && $scope.newNameSlider!=undefined){
					$scope.sliders.push({
						"COD":"0",
						"name":$scope.newNameSlider,
						"content":"<a href='#'>Lorem</a> ipsum dolor sit amet, consectetur adipisicing elit. Molestiae incidunt labore sapiente temporibus ab est non quia, cupiditate, ea accusantium perferendis cum quo repellendus, inventore quae id voluptates voluptatum voluptas.",
						"image":URLTEMPLATE+"drawable/bg-ban.png",
						"align":"center",
						"order":$scope.sliders.length
					});
					$scope.loadslider($scope.sliders[$scope.sliders.length-1]);
					$scope.newNameSlider="";
				}else{
					alert("Ingrese el nombre del slider");	
				}
			}else{
				alert("No selecciono un banner");
			}
		};

		$scope.banners=[];

		$scope.loadBanner=function(it){
			$scope.bannSelected=it.NAME;
			$scope.bannSelectedCod=it.COD;
			if(it.sliders!=undefined)
				$scope.sliders=it.sliders;
			else
				$scope.sliders=[];
			$scope.sliderSelected="Seleccione un Slider";
		};

		$scope.clodeBanner=function(){
			$scope.bannSelected="Seleccione un banner";
			$scope.bannSelectedCod=undefined;
			$scope.sliders=[];
			$scope.sliderSelected="Seleccione un Slider";
		};

		$scope.loadslider=function(it){
			$scope.sliderEdited=angular.copy(it);
		};

		$scope.saveSlider=function(){
			if($scope.bannSelectedCod!="" && $scope.sliderEdited.COD!=undefined){
				var data=JSON.stringify({"parent":$scope.bannSelectedCod,"cont":{
					"COD":$scope.sliderEdited.COD,
					"name":$scope.sliderEdited.name,
					"content":$scope.sliderEdited.content,
					"image":$scope.sliderEdited.image,
					"align":$scope.sliderEdited.align,
					"order":$scope.sliderEdited.order
				}});

				$http.post(URLTEMPLATE+"exe.php?ACTION=save_slider",data)
				.success(function(dx){
					console.log(dx);
					if(dx.status=="success"){
						if(dx.data.COD)
							$scope.sliderEdited={};
							$scope.loadBanners();
					}
				})
				.error(function(dx) {
					console.log(dx);
				});
			}else{
				alert("No fue posible corroborar la información");
			}	
		};

		$scope.openGal=function(){
			tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		};

		$scope.removeBanner=function(ref){
			var data=JSON.stringify({"ref":ref});
			$http.post(URLTEMPLATE+"exe.php?ACTION=remove_ban",data)
			.success(function(dx){
				if(dx.status=="success"){
					$scope.sliderEdited={};
					$scope.bannSelected={};
					$scope.loadBanners();
					$scope.clodeBanner();
				}else{
					alert('Error on remove slider');
				}

			})
			.error(function(dx){
				console.log(dx);
			});
		};
	
		$scope.removeSlider=function(ref){
			var data=JSON.stringify({"ref":ref});
			$http.post(URLTEMPLATE+"exe.php?ACTION=remove_slider",data)
			.success(function(dx){
				if(dx.status=="success"){
					$scope.sliderEdited={};
					$scope.loadBanners();
				}else{
					alert('Error on remove slider');
				}

			})
			.error(function(dx){
				console.log(dx);
			});
		};
		
		window.send_to_editor = function(html) {
		    console.log(html,'data requitre');
		    var pa=html.split('src="');
		    if(pa[1])
		    	pa=pa[1].split('"');
		    if(pa[0] && pa[0]!=''){
			    $scope.$apply(function(){
			    	$scope.sliderEdited.image=pa[0];
			    });
			}
		    /*var imgurl = $('img',html).attr('src');
		    $scope.$apply(function(){
		    	$scope.sliderEdited.image=imgurl;
		    });	*/
		    tb_remove();
		}
	});