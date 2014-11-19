
/*
  Get risk level from span tag and set risk image source to match this risk.
  But how to execute on load? Ask Amit
*/
/*
function showRisk(){ 
  var riskLevel = document.getElementById('riskLevel').innerHTML;
  riskImage.src = "/survey-schema/pages/images/" + riskLevel + ".gif";
}
*/
/*
  Highlight clicked region of the brain image, hide current caption, and show clicked region caption
*/
function toggleBrain(region) {
  var image = document.getElementById('brain');
  if(image) {
    var source = image.src;
    if (source.indexOf('all') > 0) {
      source = source.replace('all', region);
    }
    else {
      source = "/survey-schema/pages/images/brain-" + region +".png";
    }
    var selectedEls = document.getElementsByClassName('caption');
    for(i=0; i<selectedEls.length; i++) {
      selectedEls[i].style.display = 'none';
    }
    if (region != 'all') {
      var caption = document.getElementById('caption-' + region);
      caption.style.display = 'block'; 
    }     
    image.src = source;
    return true;
    }
  return false;
}
/*
  Toggle selected element(s) visibility to be 'visible' or 'hidden'.
*/
window.elementsToggle = function(cName) {
  if (document.getElementsByClassName(cName)) {
    var selectedEls = document.getElementsByClassName(cName);
    for(i=0; i<selectedEls.length; i++) {
      if (selectedEls[i].className.indexOf('show') !== -1) {
        selectedEls[i].className = selectedEls[i].className.replace('show' , ' ').trim();
        selectedEls[i].style.visibility = 'hidden';
      }
      else {
        selectedEls[i].className += ' show';
        selectedEls[i].style.visibility = 'visible';
      }
    }
  }
  return false;
};
/*
  Toggle two images back and forth. Assumes two image id's end in _1 and _2
*/
window.toggleImage = function(id) {
  var image = document.getElementById(id);
  if(image) {
    var source = image.src;
    if (source.indexOf(id + '_1.') >= 0) {
      source = source.replace(id + '_1.', id + '_2.');
    }
    else if (source.indexOf(id + '_2.') >= 0) {
      source = source.replace(id+'_2.', id + '_1.');
    }
    else {
      return false;
    }
  image.src = source;
  return true;
  }
  return false;
};
