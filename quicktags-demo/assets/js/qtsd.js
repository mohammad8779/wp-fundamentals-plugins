
QTags.addButton('qtsd-button-one','U','<ul>','</u>');
QTags.addButton('qtsd-button-two','JS',qtsd_button_two);
QTags.addButton('qtsd-button-two','FA',qtsd_fap_preview);

function qtsd_button_two(){

	var name = prompt("what is your name?"); 
	var text = "Hello "+name;
	QTags.insertContent(text);
}

function qtsd_fap_preview(){
	tb_show("Fontawesome",qtsd.preview);
}

function insertFA(icon){
  tb_remove();
  QTags.insertContent('<i class="fa '+icon+'"></i>');
}
