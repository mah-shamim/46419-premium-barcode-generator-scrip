
/**
 * @author MD ARIFUL HAQUE
 * @name: Rainbow PHP Framework
 * @copyright 2022 KOVATZ.COM
 *
 */


window.setTimeout(function() {
    $(".alert-dismissable").fadeTo(1000, 0).slideUp(1000, function(){
        $(this).remove(); 
    });
}, 3000);

var deleteLinks = document.querySelectorAll('.delete');

for (var i = 0; i < deleteLinks.length; i++) {
  deleteLinks[i].addEventListener('click', function(event) {
      event.preventDefault();

      var choice = confirm(this.getAttribute('data-confirm'));

      if (choice) {
        window.location.href = this.getAttribute('href');
      }
  });
}

String.prototype.replaceArray = function(find, replace) {
  var replaceString = this;
  var regex; 
  for (var i = 0; i < find.length; i++) {
    regex = new RegExp(find[i], "g");
    replaceString = replaceString.replace(regex, replace[i]);
  }
  return replaceString;
};

function uriFix(str){
    var find = ["<", ">", " ", "_", "#", "@", "{", "}"];
    var replaceString = str;
    var regex; 
    for (var i = 0; i < find.length; i++) {
        regex = new RegExp(find[i], "g");
        replaceString = replaceString.replace(regex, '-');
    }
    return replaceString.toLowerCase();
}