/**
 * Internet Explorer 6 Must DIE! 1.1
 *
 * Copyright (c) 2009 Ioseb Dzmanashvili (http://www.code.ge)
 * Licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 */
 
(function() {
  
  var getInternetExplorerVersion = function ()
	 {
		  var rv = -1;
		  if (navigator.appName == 'Microsoft Internet Explorer')
		  {
			var ua = navigator.userAgent;
			var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
			if (re.exec(ua) != null)
			  rv = parseFloat( RegExp.$1 );
		  }
		  return rv;
	 };
  var ieVersion = getInternetExplorerVersion();   
  
  if ( ieVersion >= 6.0 && ieVersion < 9.0 ) {
  
    var getDocumentHeight = function() {
      var scrollHeight = Math.max(
        document.body.scrollHeight, 
        document.documentElement.scrollHeight
      );
      return Math.max(scrollHeight, getViewportHeight());
    };
    
    var getDocumentWidth = function() {
      var scrollWidth = Math.max(
        document.body.scrollWidth,
        document.documentElement.scrollWidth
      );
      return Math.max(scrollWidth, getViewportWidth());
    };
  
    var getViewportHeight = function() {
      return Math.max(
        document.documentElement.clientHeight, 
        document.body.clientHeight
      );
    };
    
    var getViewportWidth = function() {
      return Math.max(
        document.documentElement.clientWidth,
        document.body.clientWidth
      );
    };
    
    var scriptName = 'ie6mustdie.js',
        scripts = document.getElementsByTagName('script');
    
    for (var i = 0, script, src; (script = scripts[i++]);) {
      if ((src = script.src)) {
        if (src.indexOf(scriptName) > -1) {
          var path = src.split(scriptName).shift(),
              link = document.createElement('link');
          link.rel = 'stylesheet';
          link.type = 'text/css';
          link.href = path + 'ie6mustdie.css?' + (new Date()).getTime();
          document.getElementsByTagName('head')[0].appendChild(link);
          link = null;
        }
      }
    }
    
    script = scripts = null;
    
    var content = [];
	if ( ieVersion == 6.0 || ieVersion == 7.0 )
	{
		content.push('<div class="ie6mustdie-overlay"></div>');
		content.push('<div class="ie6mustdie-dialog">');
		/*content.push('<div class="ie6mustdie-header">');
		content.push('<h1>Internet Explorer Must DIE!</h1>');
		content.push('</div>');*/
		content.push('<div class="ie6mustdie-body">');
	/*	content.push('<p>');
		content.push('ძვირფასო მომხმარებელო, თქვენ იყენებთ მსოფლიოში ყველაზე მოძველებულ ბრაუზერს მაშინ როდესაც არსებობს');
		content.push(' რამდენიმე შესანიშნავი ალტერნატივა');
		content.push('(<strong>მათ შორის თქვენი მიმდინარე ბრაუზერის მწარმოებლისგან</strong>). '); 
		content.push('ამ საიტის სანახავად გირჩევთ გადმოწეროთ ქვემოთ მითითებულ ბრაუზერთაგან ერთერთი. '); 
		content.push('გისურვებთ წარმატებულ მუშაობას!');
		content.push('</p>');
		content.push('<h2>გადმოწერეთ ერთერთი ბრაუზერი</h2>');*/
		content = content.concat(theIncBrowserIE67Text);
		content.push('<div class="ie6mustdie-browsers clearfix">');
		content.push('<ul><li>');
		content.push('<div class="safari"></div>');
		content.push('<a href="http://www.apple.com/safari/download/">Safari 4</a>');
		content.push('</li><li><div class="ff"></div>');
		content.push('<a href="http://www.mozilla.org/en-US/firefox/new/">Firefox 3.5</a>');
		content.push('</li><li><div class="chrome"></div>');
		content.push('<a href="http://www.google.com/chrome">Chrome 3</a>');
		content.push('</li><li><div class="opera"></div>');
		content.push('<a href="http://www.opera.com/browser/download/">Opera 10</a>');
		content.push('</li><li><div class="ie"></div>');
		content.push('<a href="http://code.ge/ie6mdownload.php?browser=ie8">Explorer 8</a>');
		content.push('</li></ul></div></div></div>');
	}
	else if ( ieVersion == 8.0 )
	{
		var __  = function (text)
		{
			content.push(text);
		};
		__('<div class="ie6mustdie-overlay"></div>');
		__('<div class="ie6mustdie-dialog ie6mustdie-ie8">');
/*		__('<p>');
		__('ძვირფასო მომხმარებელო თქვენი ბრაუზერი არ <br/>');
		__('აკმაყოფილებს იმ მოთ		content = content.concat(theIncBrowserIEMore7Text);ხოვნებს რაც საჭიროა ამ საიტის <br/>');
		__('სანახავად გთხოვთ მოახდინოთ მისი განახლება ან გამოიყენო<br/>');
		__('სხვა თანამედროვე ბრაუზერი!');
		__('</p>');*/
		content = content.concat(theIncBrowserIEMore7Text);
		__('</div>');
		__('</div>');
		
	}
	
    var div = document.createElement('div');
    div.id = 'ie6mustdie';
    div.className = 'ie6mustdie';
    document.body.appendChild(div);
    div.innerHTML = content.join('');
    div = null;
    
    window.setTimeout(function() {
      var div = document.getElementById('ie6mustdie');
      div.style.height = getDocumentHeight() + 'px';
      div.style.width = getDocumentWidth() + 'px';
      div.style.display = 'block';
    }, 100);
    
    if ( ieVersion == 8.0 )
    {
		document.getElementById('ie6mustdie').addEventListener('click',function ()
			{
				this.parentNode.removeChild(this);	
			}
		);
    }
    
  }
  
})();
