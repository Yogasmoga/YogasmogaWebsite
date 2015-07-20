var j = jQuery.noConflict();
function initMenu() {		
  j('#menu ul.level0').hide();
  j('#menu ul.level0').children('.current').parent().show();
  //$('#menu ul:first').show();
  j('#menu li.level0 a').click(
    function() {
      var checkElement = j(this).next();
      if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
        return false;
        }
      if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
        j('#menu ul:visible').slideUp('normal');
        checkElement.slideDown('normal');
        return false;
        }
      }
    );
j('#menu ul.level1').hide();
  j('#menu ul.level1').children('.current').parent().show();
	j('#menu li.level1 a').click(
    function() {
      var checkElement1 = j(this).next();
      if((checkElement1.is('ul')) && (checkElement1.is(':visible'))) {
        return false;
        }
      if((checkElement1.is('ul')) && (!checkElement1.is(':visible'))) {
        j('#menu ul.level0:visible').slideUp('normal');
        checkElement1.slideDown('normal');
        return false;
        }
      }
    );
  }
j(document).ready(function() {initMenu();});