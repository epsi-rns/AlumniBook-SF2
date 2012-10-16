/*!
	reflection.js for mootools v1.42
	(c) 2006-2008 Christophe Beyls <http://www.digitalia.be>
	MIT-style license.
*/

Element.implement({
	reflect: function(options) {
		var img = this;
		if (img.get("tag") == "img") {
			options = Object.append({
				height: 0.33,
				opacity: 0.5
			}, options);

			img.unreflect();

			function doReflect() {
				var reflection, reflectionHeight = Math.floor(img.height * options.height), wrapper, context, gradient;

				if (Browser.ie) {
					reflection = new Element("img", {src: img.src, styles: {
						width: img.width,
						height: img.height,
						marginBottom: -img.height + reflectionHeight,
						filter: "flipv progid:DXImageTransform.Microsoft.Alpha(opacity=" + (options.opacity * 100) + ", style=1, finishOpacity=0, startx=0, starty=0, finishx=0, finishy=" + (options.height * 100) + ")"
					}});
				} else {
					reflection = new Element("canvas");
					if (!reflection.getContext) return;
					try {
						context = reflection.setProperties({width: img.width, height: reflectionHeight}).getContext("2d");
						context.save();
						context.translate(0, img.height-1);
						context.scale(1, -1);
						context.drawImage(img, 0, 0, img.width, img.height);
						context.restore();
						context.globalCompositeOperation = "destination-out";

						gradient = context.createLinearGradient(0, 0, 0, reflectionHeight);
						gradient.addColorStop(0, "rgba(255, 255, 255, " + (1 - options.opacity) + ")");
						gradient.addColorStop(1, "rgba(255, 255, 255, 1.0)");
						context.fillStyle = gradient;
						context.rect(0, 0, img.width, reflectionHeight);
						context.fill();
					} catch (e) {
						return;
					}
				}
				reflection.setStyles({display: "block", border: 0});

				wrapper = new Element(($(img.parentNode).get("tag") == "a") ? "span" : "div").inject(img, 'after').adopt(img, reflection);
				wrapper.className = img.className;
				img.store("reflected", wrapper.style.cssText = img.style.cssText);
				wrapper.setStyles({width: img.width, height: img.height + reflectionHeight, overflow: "hidden"});
				img.style.cssText = "display: block; border: 0px";
				img.className = "reflected";
			}

			if (img.complete) doReflect();
			else img.onload = doReflect;
		}

		return img;
	},

	unreflect: function() {
		var img = this, reflected = this.retrieve("reflected"), wrapper;
		img.onload = function(){};

		if (reflected !== null) {
			wrapper = img.parentNode;
			img.className = wrapper.className;
			img.style.cssText = reflected;
			img.store("reflected", null);
			wrapper.parentNode.replaceChild(img, wrapper);
		}

		return img;
	}
});
