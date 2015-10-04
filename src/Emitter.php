<?php
class Emitter
{
    protected $_rooms = array();
    protected $_flags = array();
    
    protected $_key = 'socket.io#emitter';
    
    protected $_client = null;
    
    public function __construct($ip = '127.0.0.1', $port = 2206)
    {
        $this->_client = stream_socket_client("tcp://$ip:$port", $errno, $errmsg, 4);
        if(!$this->_client)
        {
            throw new \Exception($errmsg);
        }
    }
    
    public function __get($name)
    {
        if($name === 'broadcast')
        {
            $this->_flags['broadcast'] = true;
            return $this;
        }
        return null;
    }
    
    public function to($name)
    {
        if(!isset($this->rooms[$name]))
        {
            $this->rooms[$name] = $name;
        }
        return $this;
    }
    
    public function in($name)
    {
        return $this->to($name);
    }
    
    public function emit($ev)
    {
        $args = func_get_args();
    
        $parserType = 2;// Parser::EVENT

        $packet = array('type'=> $parserType, 'data'=> $args, 'nsp'=>'/' );
        
        $buffer = serialize(array(
                'type' => 'publish', 
                'channels'=>array($this->_key), 
                'data' => array($packet, 
                        array(
                                'rooms' => $this->_rooms,
                                'flags' => $this->_flags
                                )
                        )
                )
        );

        $this->_rooms = array();
        $this->_flags = array();;
        return $this;
    }
}