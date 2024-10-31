/*
Plugin Name: PushQuote Plugin
Author: Realtidbits
Author URI: http://realtidbits.com/
*/


jQuery(document).ready(function() {
  var login = "kga245",
  api_key = "R_156fc6d6bba784a8b3cab2e574fc61db",
  pathname = window.location.href,
  pagetitle = document.title,
  shorten_url = "";
  
  if (jQuery('.pullquote-source').length) {
    get_short_url(pathname, login, api_key, function(short_url) {
      shorten_url = short_url;  

      jQuery('.pullquote-source').each(function(i) {
        var direction = jQuery(this).attr('data-float');
        var pullquote = jQuery('<div />').html(jQuery(this).html());
        jQuery(pullquote).addClass('pulled-'+direction).addClass(direction);  

        var hide_original = jQuery(this).attr('data-hidden');
        if (hide_original === "true") {
          jQuery(this).hide();
        }
  
        // Social Buttons
        var $tw_btn = jQuery('<a />')
                  .addClass('pullquote__social--twitter')
                  .attr( { href: 'http://twitter.com/share?original_referer='+shorten_url+'&text='+encodeURIComponent((jQuery(this).html().length > 110 ? jQuery(this).html().substr(0, 110)+"... - " : jQuery(this).html())), title: 'Share in Twitter' } )
                  .click(function(event) {
                    var width  = 575,
                      height = 400,
                      left   = (jQuery(window).width()  - width)  / 2,
                      top    = (jQuery(window).height() - height) / 2,
                      url    = this.href,
                      opts   = 'status=1' +
                           ',width='  + width  +
                           ',height=' + height +
                           ',top='    + top    +
                           ',left='   + left;
                    
                    window.open(url, 'twitter', opts);
                   
                    return false;
                  }),
        $fb_btn = jQuery('<a />')
                .addClass('pullquote__social--facebook')
                .attr( { href: 'http://www.facebook.com/share.php?s=100&p[url]='+shorten_url+'&p[title]='+pagetitle+'&p[summary]='+encodeURIComponent(jQuery(this).html()), title: 'Share in Facebook' } )
                .click(function(event) {
                    var width  = 575,
                      height = 400,
                      left   = (jQuery(window).width()  - width)  / 2,
                      top    = (jQuery(window).height() - height) / 2,
                      url    = this.href,
                      opts   = 'status=1' +
                           ',width='  + width  +
                           ',height=' + height +
                           ',top='    + top    +
                           ',left='   + left;
                    
                    window.open(url, 'facebook', opts);
                   
                    return false;
                  });
        jQuery(pullquote)
          .append(
            jQuery('<div />')
              .addClass('pullquote__social')
              .append($tw_btn)
              .append($fb_btn)
          );
        
        jQuery(this).after(pullquote);
      });
    });
  }
});

function get_short_url(long_url, login, api_key, func)
{
    jQuery.getJSON(
        "http://api.bitly.com/v3/shorten?callback=?", 
        { 
            "format": "json",
            "apiKey": api_key,
            "login": login,
            "longUrl": long_url
        },
        function(response)
        {
            func(response.data.url);
        }
    );
}