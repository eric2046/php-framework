<?php

namespace Core\Session\Handler;

/**
 * 基于Memcached的Session处理器
 *
 * 配置 ：
 *    $options = array(
 *        'servers' => array(
 *            array('mem1.domain.com', 11211, 33),
 *            array('mem2.domain.com', 11211, 67)
 *        ),
 *    );
 *
 * @author lisijie <lsj86@qq.com>
 * @package Core\Session
 */
class Memcached implements HandlerInterface
{

    private $handler;
    private $ttl;

    public function __construct(array $options)
    {
        if (empty($options['servers'])) {
            throw new \InvalidArgumentException('缺少Memcached服务器配置');
        }
        $this->handler = new \Memcached();
        $this->handler->addServers($options['servers']);
        $this->ttl = intval(ini_get('session.cookie_lifetime'));
        $this->handler->setOptions([
            \Memcached::OPT_DISTRIBUTION => \Memcached::DISTRIBUTION_CONSISTENT,
        ]);
    }

    public function open($save_path, $session_id)
    {

    }

    public function close()
    {

    }

    public function read($session_id)
    {
        return $this->handler->get($session_id);
    }

    public function write($session_id, $session_data)
    {
        return $this->handler->set($session_id, $session_data, 0, $this->ttl);
    }

    public function destroy($session_id)
    {
        return $this->handler->delete($session_id);
    }

    public function gc($maxlifetime)
    {

    }
}
