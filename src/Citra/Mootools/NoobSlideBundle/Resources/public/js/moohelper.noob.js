/* noob nav helper class */
// written by epsi

var mooNoobSlideHelper = new Class({
	Implements: [Options],
		options: {
			items: [], // array of {img, thumb, zoom}
			path: '',
			mediaboxAdv : false,
			slimbox: false
		},
	initialize: function(options){
		this.setOptions(options);		
		this.splitImages();
		
		// nav run
		leftIndex = this.fillNavDOM('noob_lnav_box', this.leftItems);
		rightIndex = this.fillNavDOM('noob_rnav_box', this.rightItems);			
		this.createNav('noob_lnav_box', leftIndex, 
			'noob_lnav_prev', 'noob_lnav_next');
		this.createNav('noob_rnav_box', rightIndex, 
			'noob_rnav_prev', 'noob_rnav_next');

		// main run
		this.fillMainDOM();
		this.createMain();
		this.addLightBox();
	},	
	splitImages: function() {	
		var images = this.options.items;
		this.leftItems = [];
		this.rightItems = [];		
		
		middle = Math.floor(images.length/2);
		for ( i=0; i < images.length; i++ ) {		
			thumb = {img: images[i].thumb};	// perbaiki: array langsung
			if (i+1<=middle)
				this.leftItems[i] = thumb;
			else
				this.rightItems[i-middle] = thumb;	
		}	
	}.protect(),
	fillMainDOM: function() {			
		var main_box= document.id('noob_main_box');
		var path = this.options.path;
		
		// Initialize DOM
		this.options.items.each(function(item, index){
	    	var span = new Element('span');
	    	span.inject(main_box);
	    
			var a = new Element('a', { 
				'id' : 'noob'+index,
				'href':  path+item.zoom,
				'rel': 'lightbox[noob]'
			});
			a.inject(span);
		});	
	}.protect(),	
	fillNavDOM: function(elBox, navItems) {
		// DOM
		var noob_nav_box = document.id(elBox);
		var path = this.options.path;
		
		navItems.each(function(item, index){
	    	var div = new Element('div');
	    	div.inject(noob_nav_box);
	    	var	img = new Element('img', 
				{ 'src' : path+item.img, 'alt' : 'Photo Thumb'});
			img.inject(div);	
		});		
	
		// also return index for navigation
		var noobIndex=[];
		for ( i=0; i < navItems.length; i++ )
  			noobIndex[i]=i;
  		return noobIndex;			
	}.protect(),
	createNav: function(elBox, navIndex, prev, next) {	
		// Navigation 		
		new noobSlide({
			mode: 'vertical',
			box: document.id(elBox),
			items: navIndex,
			size: 45,
			addButtons: {
				previous: $(prev),
				next: $(next)
			},
			button_event: 'click',
			fxOptions: {
				duration: 1000,
				transition: Fx.Transitions.Back.easeOut,
				link:'cancel'
			},
			onWalk: function(currentItem,currentHandle){
				if (this.currentIndex>navIndex.length-5)
					this.walk(navIndex.length-5);	
			}				
		});
	},	
	createMain: function() {
		// this function is an adaptation from original noob6 sample
		var path = this.options.path;
		var noobItems = this.options.items;
		
		// Main (on "mouseenter" walk)
		var info = $('noob_main_box').getNext().set('opacity',0.5);
		var nS_main = new noobSlide({
			mode: 'vertical',
			box: document.id('noob_main_box'),
			items: noobItems,
			size: 240,
			handles: $$('#noob_handles_1 div div').append($$('#noob_handles_2 div div')),
			handle_event: 'mouseenter',
			addButtons: {
				previous: $('noob_prev'),
				play: $('noob_play'),
				stop: $('noob_stop'),
				playback: $('noob_playback'),
				next: $('noob_next')
			},
			button_event: 'click',
			fxOptions: {
				duration: 1000,
				transition: Fx.Transitions.Back.easeOut,
				link:'cancel'
			},
			onWalk: function(currentItem,currentHandle){
				this.handles.set('opacity',0.3);
				currentHandle.set('opacity',1);
			
				holder = document.id('noob'+this.currentIndex);
				holder.empty();

				var img = new Element('img', 
					{ 'src' : path+currentItem.img, 'alt' : 'Photo'});
				img.inject(holder);
				img.reflect({});
			}
		});
		//walk to next item
		nS_main.next();	
	},
	addLightBox: function() {	
		if (this.options.mediaboxAdv 
		|| this.options.slimbox 
		|| this.options.diabox)
		var links = $$('#noob_main_box a').filter(function(el) {
			return el.rel && el.rel.test(/^lightbox/i);
		});

		if (this.options.mediaboxAdv)
		links.mediabox({}, null, function(el) {
			var rel0 = this.rel.replace(/[[]|]/gi," ");
			var relsize = rel0.split(" ");
			return (this == el) || ((this.rel.length > 8) && el.rel.match(relsize[1]));
		});	
	
		if (this.options.slimbox)
		links.slimbox({}, null, function(el) {
			return (this == el) || ((this.rel.length > 8) && (this.rel == el.rel));
		});	
		
		if (this.options.diabox)
			window.diabox.observe_anchors();
	}		
});
		



