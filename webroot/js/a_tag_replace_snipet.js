<script>
var before='test<a class="a">atest</a>test test test test';
var after = before.replace(
/(置換したい単語)|(<(?:(?!\sclass="|>).)+\sclass="(?:(?:(?!a|")\w)+\s)*a(?:\s\w+)*"[^>]*>(?:(?!.*?|<).)*.*?[^<]*<\/[^>]+>)/g,
 function() {
  if (arguments[2]) {
   return arguments[2];
  } else if (arguments[1]) {
   return '<b>test</b>';
  }
 }
);
alert(after);
</script>