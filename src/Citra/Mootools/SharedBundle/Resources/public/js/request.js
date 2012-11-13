/**
 * Common AJAX request
 *
 * @package    common
 * @subpackage mootools
 * @author     E.R. Nurwijayadi
 * @version    1.0
 */

/* -- AJAX Handler -- */
// http://davidwalsh.name/dwrequest-mootools-12-ajax-listener-message

function show_note(state){
    var el = document.id('container-console');
    var id = ['request', 'success', 'failure', 'cancel'].indexOf(state);
    var a_msg   = ['Loading content...', 'Content loaded.',
        'Request Failed!', ' Request Cancelled!'];
    var a_bg    = ['#fffea1', '#90ee90', '#ff0000', '#fffea1'];

    el.setStyle('top', window.getScrollTop() + 13);
    el.set('text', a_msg[id]);
    el.setStyle('background-color', a_bg[id]);

    el.set('tween', {duration: 'long'});
    if (state == 'request') el.setStyle('opacity', 100);
    else el.tween('opacity', 0);
}

var myAjax = new Class({
    Extends: Request.HTML,
    initialize: function(options){
        this.parent(options);
        this.rqst = this.options.rqst;
        this.options.evalScripts= false;
        this.options.evalResponse= false;
        this.addEvent('cancel',  function() { show_note('cancel'); } );
        this.addEvent('request', function() { show_note('request'); });
        this.addEvent('failure', function(xhr) { show_note('failure'); } );
        this.addEvent('success', function(rTree, rEls, rHTML, rJS){
            this.rqst.set('html', rHTML);
            Browser.exec(rJS);
            show_note('success');
        });
    }
});

function bindInnerRequest(url, element, data){
  window.addEvent("domready",function(){
    var rqst    = (element == undefined) ?
        document.id('container-request') : document.id(element);
    var args    = (data == undefined) ? {} : data;

    new myAjax({
        rqst: rqst, url: url, method: 'get', data: args
    }).send();
  });
}

// naive approach for complicated submit situation
function bindFormRequest(url){
  window.addEvent("domready",function(){
    var form    = document.id('ajaxForm');
    if (form == null ) return;  // prevent called twice, dunno why.

    $$('.prevent').addEvent('click',$lambda(false));

    var rqst    = document.id('container-request');

    var submithandler = function(event) {
        new myAjax({
            rqst: rqst, url: url,
            method: 'post', data: this.toQueryString()
        }).send();
    };

    form.onsubmit = submithandler;
  });
}

// http://mootools.net/docs/core/Element/Element.Delegation
function ajaxified(element){
  window.addEvent('domready', function() {
    var rqst    = (element == undefined) ?
        document.id('container-request') : document.id(element);

    rqst.addEvent('click:relay(a.ajax)', function(event, target){
        event.preventDefault();
        new myAjax({
            rqst: rqst, url: target.get('href')
        }).send();
    });
  });
}
