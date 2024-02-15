$(function() {  //alert('loaded');
				const position = { x: 0, y: 0 }
				interact('.draggable').draggable({
			  listeners: {
				start (event) {
				  console.log(event.type, event.target)
				},
				move (event) {
				  position.x += event.dx
				  position.y += event.dy

				  event.target.style.transform =
					'translate(' + position.x + 'px, ' + position.y + 'px)'
				},
			  }
			})
				
				
				var flip = $("#flip").val();
				      drawLayer(canvasid, false);
					  drawLayer(canvasid2, true); 
					   
						$('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
						  alert("clicked");
						 e.relatedTarget.dispose(); // previous active tab
						})
					});


		$('canvas').setLayer('CTextTop', {
			  fillStyle: '#36b',
			 // rotate: 30,
			 // x: '+=100',
			//  y: '-=100',
			  draggable: false,
		})
		.drawLayers();
		   
		function drawLayer(layerid, flip = false){ //alert('draw...');
				$('canvas').removeLayer(layerid);
				editCText(layerid, flip);
		}		
			
		function flipText(){
			var flip = false;
			var checkBox = document.getElementById("flip");							 
			if (checkBox.checked == true){
				flip = true;
			} else {
				flip = false;
			}
			$('canvas').removeLayer("CTextTop");
				drawLayer("CTextTop",flip);				
			}
	function editCText(layerid, flip = false) {				
				//	context.strokeStyle = '#000'
				var text = $("#dynamicmodel-text").val();
					var fName = "Arial";
					var align = "center";
					var textInside = false;
					var inwardFacing = true;
					/*var radius = flip ? $("#radiusb").val() : $("#radius").val();				
					var fSize = flip ? parseInt($("#fontSizeb").val()) : parseInt($("#fontSize").val());
					var startAngle = flip ? parseInt($("#anglestb").val()) : parseInt($("#anglest").val());
					var kerning = flip ? parseFloat($("#kerningb").val()) : parseFloat($("#kerning").val());*/
					var radius = $("#dynamicmodel-radius").val() ;				
					var fSize =  parseInt($("#dynamicmodel-fontsz").val());
					var startAngle = parseInt($("#dynamicmodel-anglest").val());
					var kerning = parseFloat($("#dynamicmodel-spacing").val());
					$('canvas').drawText({
					layer:true,
					name: layerid,
					draggable:true,
					  fillStyle: 'black',
					 fontFamily: 'Ubuntu, sans-serif',
					  fontSize: fSize,
					  text: text,
					  x: 202, y: 202,
					  lineHeight: 20,
					  rotate: (flip) ? 180 - startAngle : startAngle,
					  radius: radius,
					  letterSpacing: kerning,
					  flipArcText: flip,
					  click: function(layer) {
					  // Click a star to spin it
					  /*$(this).animateLayer(layer, {
						rotate: '+=144'
					  });*/
					},
					mouseover: function(layer) {
						$(this).animateLayer(layer, {
						  fillStyle: '#c33'
						}, 500);
					  },
					   mouseout: function(layer) {
						$(this).animateLayer(layer, {
						  fillStyle: 'black'
						}, 500);
					  },
					}).drawLayers();
					
			}
var canvasid = "CTextTop";
$("body").on("change","#dynamicmodel-text", function() {
						   
						   drawLayer("CTextTop", false);						
						});	
$("#dynamicmodel-radius").on("change", function() {      							
					       drawLayer(canvasid, false);					
						});	
$("body").on("change","#dynamicmodel-anglest", function() {					      
					       drawLayer(canvasid, false);							
						});
$("body").on("change","#dynamicmodel-fontsz", function() {					      
					       drawLayer(canvasid, false);							
						});			           
$("body").on("change","#dynamicmodel-spacing", function() {					      
					       drawLayer(canvasid, false);							
						});						
function download_image(bgImgSrc) {
            var background = new Image();    
          
            var topTextCanvas = document.getElementById('CTextTop');
            var ctx1 = topTextCanvas.getContext('2d');
          //  ctx1.globalCompositeOperation = 'destination-over';
            var top = ctx1.getImageData(0, 0, 150, 105);
         //   var bottomTextCanvas = document.getElementById('bottomTextLayer');
         //   var ctx2 = bottomTextCanvas.getContext('2d');
         //   var bottom = ctx2.getImageData(0, 75, 150, 150);

            // var merged = mergeData(top, bottom);
            // ctx2.putImageData(merged, 0, 0);
            var merged = document.getElementById('merged');
            ctx3 = merged.getContext('2d');
            
            
             background.onload = function(){
                   ctx3.drawImage(background,0,0);  
               
              }
		 background.src = bgImgSrc;
            ctx3.putImageData(top, 10, 12);
            
            
          //  ctx3.putImageData(bottom, 20, 98);
            var link = document.createElement('a');
            link.download = "prov-round-stamp.png";
            link.href = merged.toDataURL("image/png").replace("image/png", "image/octet-stream");
            link.click();
        }    