function setNextFocus(obj){
  if(obj.value.length >= obj.maxLength){
    var es = document.form.elements;
    for(var i=0;i<es.length;i++){
      if(es[i] == obj){
        es[i+1].focus();
        break;
      }
    }
  }
}
