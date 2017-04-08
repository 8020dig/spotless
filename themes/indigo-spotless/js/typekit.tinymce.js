(function() {
  tinymce.create('tinymce.plugins.typekit', {
    init: function(ed, url) {
      ed.onPreInit.add(function(ed) {

        // Get the DOM document object for the IFRAME
        var doc = ed.getDoc();

        // Create the script we will add to the header asynchronously
        var jscript = "\n\
          (function(d) {\n\
            var config = {\n\
              kitId: window.top.aecom_typekit_id,\n\
              scriptTimeout: 3000,\n\
              events: false,\n\
              classes: false\n\
            },\n\
            h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,'')+' wf-inactive';},config.scriptTimeout),tk=d.createElement('script'),f=false,s=d.getElementsByTagName('script')[0],a;h.className+=' wf-loading';tk.src='//use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!='complete'&&a!='loaded')return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)\n\
          })(document);\n\
          ";

        // Create a script element and insert the TypeKit code into it
        var script = doc.createElement("script");
        script.type = "text/javascript";
        script.appendChild(doc.createTextNode(jscript));

        // Add the script to the header
        doc.getElementsByTagName('head')[0].appendChild(script);

      });

    },
    getInfo: function() {
      return {
        longname: 'TypeKit For TinyMCE',
        author: 'Tom J Nowell',
        authorurl: 'http://tomjn.com/',
        infourl: 'http://twitter.com/tarendai',
        version: "1.1"
      };
    }
  });
  tinymce.PluginManager.add('typekit', tinymce.plugins.typekit);
})();
