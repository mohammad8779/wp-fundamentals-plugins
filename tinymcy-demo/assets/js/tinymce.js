;(function(){
  
  tinyMCE.PluginManager.add('tmcd_plugin',function( editor,url){
  	//alert(url);
  	editor.addButton('tmcd_form_one',{
       text:'Form',
        onclick:function(){
          editor.windowManager.open({
          	title:'User Input Form',
          	 body:[

          	     {
                    type:'textbox',
                    name:'userinput1',
                    label:'Some Text',
                    value:'hello'
          	     },

          	     {
                    type:'colorpicker',
                    name:'userinput2',
                    label:'Color',
                    value:'#222'
          	     },
               ],
               onsubmit:function(e){
                 console.log(e.data.userinput1);
                 console.log(e.data.userinput2);
                 editor.insertContent("Text = "+e.data.userinput1 +" Color = "+e.data.userinput2);
               }
          });
        }

     });
     editor.addButton('tmcd_button_one',{
       // text : 'B1',
        //icon : 'insertdatetime',
        image:url+"/../image/cart.png",
        onClick:function(){
        	editor.insertContent("[gmap]content[/gmap]");
        }
     });
      editor.addButton('tmcd_listbox_one',{
        type:'listbox',
        text:'Select Something',
        values:[
           
           {text:'Apple',value:'You hane selected <b>Apple</b>'},
           {text:'Orange',value:'You hane selected <em>Orange</em>'},
           {text:'Banana',value:'You hane selected <i>Banana</i>'},
           {text:'Lemon',value:'You hane selected <strong>Lemon</strong>'},
 
        ],
        onselect:function(){
           editor.insertContent(this.value())
        },
        onPostRender: function(){
        	this.value('You hane selected <em>Orange</em>');
        }

     });

      editor.addButton('tmcd_menu_one',{
        type:'menubutton',
        text:'Choices',
        menu:[
           {
             
               text:"Option A",
	           menu:[
                  
                  {
                  	text:"Option A -1",
                  	onclick:function(){
			           	 console.log("Option A -1")
			           }
                  },

                   {
                  	text:"Option A -2",
                  	onclick:function(){
			           	 console.log("Option A -2")
			           }
                  },
                   {
                  	text:"Option A -3",
                  	onclick:function(){
			           	 console.log("Option A -3")
			           }
                  },
	           ]
	       },
	       
	       {
             
               text:"Option B",
	           onclick:function(){
	           	 console.log("Option A")
	           }
	       },

	       {
             
               text:"Option C",
                 menu:[
                  
                  {
                  	text:"Option C -1",
                  	onclick:function(){
			           	 console.log("Option A -1")
			           }
                  },

                   {
                  	text:"Option C -2 ",
                  	onclick:function(){
			           	 console.log("Option A -2")
			           }
                  },
                   {
                  	text:"Option C -3 ",
                  	 menu:[
		                  
		                  {
		                  	text:"Option C -3 -1",
		                  	onclick:function(){
					           	 console.log("Option A -3 -1")
					           }
		                  },

		                   {
		                  	text:"Option C -3 -2 ",
		                  	onclick:function(){
					           	 console.log("Option A -3 -2")
					           }
		                  },
		                   {
		                  	text:"Option C -3 -3",
		                  	onclick:function(){
					           	 console.log("Option A -3 -3")
					           }
		                  },
			           ]
                  },
	           ]
	       }
        ],

        

     });
  });


})();
