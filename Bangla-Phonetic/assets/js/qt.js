QTags.addButton('bp-bangla','bangla',bp_bangla);
QTags.addButton('bp-english','english',bp_english);

var bp_initialized = false;
function bp_bangla(){

  if(!bp_initialized){
  	 $('.wp-editor-area').bnKb({
         'switchkey':'e',
         'driver'   : phonetic
  	 });
  	 bp_initialized =  true;
  }else{
      ('.wp-editor-area').bnKb.sw("b");
  }

}

function bp_english(){
  ('.wp-editor-area').bnKb.sw("e");
}