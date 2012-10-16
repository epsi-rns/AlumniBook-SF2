// written from scratch by E.R. Nurwijayadi, epsi.rns@gmail.com

var mooGooglePicasaWeb = new Class({
	Binds: ['getAlbumID', 'buildPhotoIDs'],
	Implements: [Options, Events],
		options: {
			user: null,
			album: null,
			onComplete: function(){}
		},
	initialize: function(options){
		this.setOptions(options);		
		this.url_base= 'http://picasaweb.google.com/data/feed/api/user/';
	},
	send: function() {	this.userRequest(); }, // nicer name shortcut
	userRequest: function() {
		var getAID =  this.getAlbumID;
		new Request.JSONP({
			url: this.url_base+this.options.user,
			data: { alt: 'json' },	// json-in-script
			onComplete: function(data){ getAID(data); }
		}).send();
	}.protect(),
	albumRequest: function() {
		var buildPIDs =  this.buildPhotoIDs;
		new Request.JSONP({
			url: this.url_base+this.options.user+'/albumid/'+this.albumID,
			data: { alt: 'json', thumbsize: '64u,288', imgmax: '800' },
			onComplete: function(data){ buildPIDs(data); }
		}).send();	
	}.protect(),
	getAlbumID: function(json){
		var albumIndex=-1;
		for ( i=0; i < json.feed.entry.length; i++ ) {
			if	(json.feed.entry[i].gphoto$name.$t==this.options.album) 
				{ albumIndex=i; break; }
		}
	
		if (albumIndex==-1) {json=null; return;} // silence
		else {
			this.albumID = json.feed.entry[albumIndex].gphoto$id.$t;
			json=null;
			this.albumRequest();
		}	
	},
	buildPhotoIDs: function(json){
		var images= [];
		for ( i=0; i < json.feed.entry.length; i++ ) {
			// ie6 reject shortcut: item = json.feed.entry[i].media$group;
			images[i] = {
				zoom: json.feed.entry[i].media$group.media$content[0].url,
				img: json.feed.entry[i].media$group.media$thumbnail[1].url,
				thumb: json.feed.entry[i].media$group.media$thumbnail[0].url
			}; 
		}
		json=null;
		
		this.fireEvent('onComplete', [images]);
	}	
});




