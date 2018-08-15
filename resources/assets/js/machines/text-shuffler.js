(function($){

    $.fn.shuffleLetters = function(prop){

        var options = $.extend({
            "step"      : 100,           // How many times should the letters be changed
            "fps"       : 50,           // Frames Per Second
            "text"      : "",           // Use this text instead of the contents
            "callback"  : function(){
                
            }  // Run once the animation is complete
        },prop)

        return this.each(function(){

            var el = $(this),
                str = "";
            // Preventing parallel animations using a flag;

            if(el.data('animated')){
                return true;
            }

            el.data('animated',true);


            if(options.text) {
                str = options.text.split('');
            }
            else {
                str = el.text().split('');
            }

            // The types array holds the type for each character;
            // Letters holds the positions of non-space characters;

            var types = [],
                letters = [];

            // Looping through all the chars of the string

            for(var i=0; i<str.length; i++){

                var ch = str[i];

                if(ch == " "){
                    //types[i] = "symbol";
                    types[i] = "";
                    continue;
                }
                else if(/[a-z]/.test(ch)){
                    types[i] = "lowerLetter";
                }
                else if(/[A-Z]/.test(ch)){
                    types[i] = "upperLetter";
                }
                else {
                    types[i] = "symbol";
                }

                letters.push(i);
            }

            el.html("");            

            // Self executing named function expression:

            (function shuffle(start){

                // This code is run options.fps times per second
                // and updates the contents of the page element

                var i,
                    len = letters.length, 
                    strCopy = str.slice(0); // Fresh copy of the string

                if(start>len){

                    // The animation is complete. Updating the
                    // flag and triggering the callback;

                    el.data('animated',false);
                    options.callback(el);
                    return;
                }

                // All the work gets done here
                for(i=Math.max(start,0); i < len; i++){

                    // The start argument and options.step limit
                    // the characters we will be working on at once

                    if( i < start+options.step){
                        // Generate a random character at this position
                        strCopy[letters[i]] = randomChar(types[letters[i]]);
                    }
                    else {
                        strCopy[letters[i]] = "";
                    }
                }

                el.text(strCopy.join(""));
                setTimeout(function() {
                    shuffle(start+1);
                }, 5000/options.fps);
            })(-options.step);
        });
    };
    function randomChar(type){
        //var pool = "eyJpdiIIitSQkVGNRbHJxSnRMRWRdUliRHcPSIsInZhbHVlIjoibXc"; 
        var pool = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
        var arr = pool.split('');
        return arr[Math.floor(Math.random() * arr.length)];
    }
    // container is the DOM element;
    var container = $(".slot-machine-holder div.slot-text h1");

    // Loop
    function loop() {
      h1.shuffleLetters({ callback:loop });
    }
    //loop();
    
    var strs = [
            'MEGASPORTSWORLD',
            'RESTY ALEJO'
        ];
    
    function changeText( i, interval ) {
        if( typeof interval == 'undefined' ) interval = 0;
        var next = i + 1;
        if( strs.length == next ) next = 0;
        
        setTimeout(function(){
            container.text(strs[i]).shuffleLetters({ 
                callback: changeText( next, 5000 ) 
            });
        }, interval);
    }    
    window.RandLetter = changeText( 0 );    
})(jQuery);

