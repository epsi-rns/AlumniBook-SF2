this.$defined = function(obj){
	return (obj != null);
};

/*
https://github.com/anutron/mootools-more/raw/shake/
 
Script: Fx.Tween.js
	Formerly Fx.Style, effect to transition any CSS property for an element.

License:
	MIT-style license.
*/

Fx.Shake = new Class({

	Extends: Fx.Tween,

	options: {
		times: 5
	},

	initialize: function(){
		this.parent.apply(this, arguments);
		if (this.options.property) {
			this.property = this.options.property;
			delete this.options.property;
		}
		this._start = this.start;
		this.start = this.shake;
		this.duration = this.options.duration;
		this.shakeChain = new Chain();
	},

	complete: function(){
		if (!this.shakeChain.$chain.length && this.stopTimer()) this.onComplete();
		else if (this.shakeChain.$chain.length) this.shakeChain.callChain();
		return this;
	},

	shake: function(property, distance, times){
		if (!this.check(arguments.callee, property, distance)) return this;
		var args = Array.link(arguments, {property: Type.isString, distance: $defined, times: $defined});
		property = this.property || args.property;
		times = args.times || this.options.times;
		// dbug.log(times);
		this.stepDur = this.duration / (times + 1);
		this._getTransition = this.getTransition;
		this.origin = this.element.getStyle(property).toInt()||0;
		this.shakeChain.chain(
			function(){
				this.shakeChain.chain(
					function() {
							this.stopTimer();
							this.getTransition = this._getTransition;
							this.options.duration = this.stepDur / 2;
							//stage three, return to origin
							this._start(property, this.origin);
					}.bind(this)
				);
				this.getTransition = function(){
					return function(p){
						return (1 + Math.sin( times*p*Math.PI - Math.PI/2 )) / 2;
					}.bind(this);
				}.bind(this);
				this.stopTimer();
				this.options.duration = this.stepDur * times;
				//stage 2: offset to the other side using the shake transition
				this._start(property, this.origin - args.distance);
			}.bind(this)
		);
		this.options.duration = this.stepDur / 2;
		//stage 1: offset to one side
		return this._start(property, this.origin + args.distance);
	},

	onCancel: function(){
		this.parent();
		this.shakeChain.clearChain();
		return this;
	}

});

Element.Properties.shake = {

	set: function(options){
		var shake = this.retrieve('shake');
		if (shake) shake.cancel();
		return this.eliminate('shake').store('shake:options', Object.append({link: 'cancel'}, options));
	},

	get: function(options){
		if (options || !this.retrieve('shake')){
			if (options || !this.retrieve('shake:options')) this.set('shake', options);
			this.store('shake', new Fx.Shake(this, this.retrieve('shake:options')));
		}
		return this.retrieve('shake');
	}

};

Element.implement({

	shake: function(property, distance, times, options){
		var args = Array.link(arguments, {property: Type.isString, distance: Type.isNumber, times: Type.isNumber, options: Type.isObject});
		if (args.options) this.set('shake', args.options);
		this.get('shake').start(args.property, args.distance, args.times);
		return this;
	}

})
