var tempArr = ['aa','bb'];

var tempArr2 = {
  'aa' : 0,
  'bb' : 0,
  'cc' : 0,
};



for(var i=0; i< tempArr.length; i++){
  
  tempArr2[tempArr[i]] = 1;
  
}

console.log(tempArr2);
