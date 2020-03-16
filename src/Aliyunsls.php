<?php
declare(strict_types = 1);

namespace think\log\driver;

use think\App;
use think\contract\LogHandlerInterface;

/**
 * 本地化调试输出到文件
 */
class Aliyunsls implements LogHandlerInterface
{
    /**
     * 配置参数
     * @var array
     */
    protected $config = [
        'endpoint'          => 'http://cn-beijing.sls.aliyuncs.com/',
        'access_key_id'     => '',
        'access_key_secret' => '',
        'project'           => '',
        'logstore'          => '',
        'source'            => '',
        'topic'             => 'default',
        'json'              => false,
        'json_options'      => JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES,
    ];

    // 实例化并传入参数
    public function __construct(App $app, $config = [])
    {
        if (is_array($config)) {
            $this->config = array_merge($this->config, $config);
        }
    }

    /**
     * 日志写入接口
     * @access public
     * @param array $log 日志信息
     * @return bool
     */
    public function save(array $log): bool
    {
        $info = [];

        // 日志信息封装
        $time = time();

        foreach ($log as $type => $val) {
            $message = [];
            foreach ($val as $msg) {
                if (!is_string($msg)) {
                    $msg = var_export($msg, true);
                }

                $logItem = new \Aliyun_Log_Models_LogItem();
                $logItem->setTime($time);

                $contents = $this->config['json'] ?
                ['content' => json_encode(['type' => $type, 'msg' => $msg], $this->config['json_options'])] :
                ['type' => $type, 'msg' => $msg];
                $logItem->setContents($contents);

                $message[] = $logItem;
            }
            $info = $message;
        }

        if ($info) {
            return $this->write($info);
        }

        return true;
    }

    /**
     * 日志写入
     * @access protected
     * @param array  $message     日志信息
     * @return bool
     */
    protected function write(array $message): bool
    {
        $client = new \Aliyun_Log_Client($this->config['endpoint'], $this->config['access_key_id'], $this->config['access_key_secret']);
        $req = new \Aliyun_Log_Models_PutLogsRequest($this->config['project'], $this->config['logstore'], $this->config['topic'], $this->config['source'], $message);
        $client->putLogs($req);

        return true;
    }
}
