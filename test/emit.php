<?php

include __DIR__ .'/../src/Emitter.php';

$emitter = new Emitter();

$emitter->in('chn1---------')->emit('newmsg', 'hello');
$emitter->emit('newmsg', 'aaaaaaaaa');
