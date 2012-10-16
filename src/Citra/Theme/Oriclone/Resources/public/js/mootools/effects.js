/**
 * Oriclone Theme Effects
 *
 * @package    oriclone
 * @subpackage mootools
 * @author     E.R. Nurwijayadi
 * @version    1.0
 */
 
window.addEvent('domready', function() {
	mootools_watermark_scroll();
});
	
if (Browser.ie6){
    // Please upgrade your browser
    window.location = 'http://ie6countdown.com/';
}
	

// http://davidwalsh.name/break-out-frames

if (top.location != self.location) {
	top.location = self.location;
}

// http://davidwalsh.name/mootools-shake
function mootools_shake() {
	var shaker = document.id('system-message');
	
	/* shake baby! */	
  if (shaker!=null && !Browser.ie)	
  {
	shaker.setStyles({
		opacity: 0,
		display: 'block'
	});
	/* event */
	window.addEvent('load',function() {
		/* fade in */
		var x = function() { shaker.fade('in');};
		x.delay(1000);
		/* shake */
		var y = function() { shaker.shake('margin',5,3); };
		y.periodical(3000);
	});
  }	
}

function hover_sidemenu() {
	// side menu
	el = document.id('lay_main').getElement('.moduletable_menu ul.menu li a');
	if (el!=null) {
	var save = el.getStyle('color');	
		
	var list = $$('.moduletable_menu ul.menu li a, '
		+	'.moduletable_menu ul.menu li li a');
	list.each(function(element) {		 
		var fx = new Fx.Morph(element, {duration:700, link:'cancel',
			transition: Fx.Transitions.Quad.easeInOut});			
	 			 
		element.addEvent('mouseenter', function(){
			fx.start({ 	'padding-left': 35, 'color': '#444' });
		});
		 
		element.addEvent('mouseleave', function(){
			fx.start({ 	'padding-left': 10, 'color': save });
		}); 
	});
	}
}

// http://davidwalsh.name/mootools-watermark
function mootools_watermark_scroll() {	
	/* smoothscroll - scroll smoothly to the top*/
	new Fx.SmoothScroll({duration:500});

	/* go to top after 300 pixels down */
	var gototop = document.id('gototop');
	gototop.setStyle('opacity','0').setStyle('display','block');
	window.addEvent('scroll',function(e) {
		if(Browser.ie) {
			gototop.setStyles({
				'position': 'absolute',
				'bottom': window.getPosition().y + 10,
				'width': 100
			});
		}
		gototop.fade((window.getScroll().y > 300) ? '0.7' : 'out')
	});
}

// http://davidwalsh.name/simple-mootools-accordion
function mootools_accordion() {
	var togglers	= $$('.acdn_toggler');
	var elements	= $$('.acdn_element');
	if (togglers.length!=0 && elements.length!=0)
		var accordion = new Fx.Accordion(togglers, elements, {
			opacity: 0,
			onActive: function(toggler) { toggler.setStyle('color', '#f30'); },
			onBackground: function(toggler) { toggler.setStyle('color', '#000'); }
		});		
}


// http://davidwalsh.name/dw-content/mootools-skype.php
function mootools_skypebutton() {			
	// readon
	var list = $$('a.readon');
	list.each(function(element) {		
		element.setStyle('padding-left', '20px');

		var my_skype = new Element( 'div') ;
		my_skype.addClass('skypebutton');
		my_skype.inject(element, 'top');		

		running = false;
		var fx2 = new Fx.Morph(my_skype, 
			{duration: 100, link: 'chain', onChainComplete:function() { 
				running = false; } });
		var fx1 = new Fx.Morph(my_skype, 
			{duration: 200, link: 'chain', onComplete:function() {
				fx2.start({'top':'-7px'})
				.start({'top':'-4px'})
				.start({'top':'-6px'})
				.start({'top':'-4px'});
			}
		});
		element.addEvent('mouseenter',function() {
			if(!running) {
				fx1.start({'top':'-10px'}).start({'top':'-4px'});
				running = true;
			}
		});		
	});
}	

// http://davidwalsh.name/peel-effect
function mootools_peel_effect() {	
	var flip = $('page-flip');
	var flipImage = $('page-flip-image');
	var flipMessage = $('page-flip-message');
	
	if (flip!=null)	
	flip.addEvents({
		mouseenter:function() {
			$$(flipImage,flipMessage).set('morph',{ duration: 500 }).morph({
				width: 154, // 307,
				height: 160 // 319
			});
		},
		mouseleave:function() {
			flipImage.set('morph',{ duration: 220 }).morph({
				width: 50,
				height: 52
			});
			flipMessage.set('morph',{ duration:200 }).morph({
				width: 50,
				height:50
			});
		}	
	});
}


