# phpsocket.io-emitter

##　example
```php
$emitter = new Emitter();
$emitter->in('one room')->emit('newmsg', 'hello');
$emitter->emit('newmsg', array('type'=>'blog','content'=>'.....'));
```
