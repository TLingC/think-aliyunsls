# think-aliyunsls
[![](https://img.shields.io/packagist/v/tlingc/think-aliyunsls.svg)](https://packagist.org/packages/tlingc/think-aliyunsls)
[![](https://img.shields.io/packagist/dt/tlingc/think-aliyunsls.svg)](https://packagist.org/packages/tlingc/think-aliyunsls)
[![](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE.md)

ThinkPHP 6 阿里云日志服务日志驱动

## 安装
```
composer require tlingc/think-aliyunsls
```

## 配置
config/log.php
```php
// 默认日志记录通道
'default'      => 'aliyunsls',
// 日志通道列表
'channels'     => [
    'aliyunsls' => [
        // 日志记录方式
        'type' => 'Aliyunsls',
        // 阿里云 endpoint
        'endpoint' => 'http://cn-beijing.sls.aliyuncs.com/',
        // 阿里云 AccessKey ID
        'access_key_id' => '',
        // 阿里云 AccessKey Secret
        'access_key_secret' => '',
        // 项目名称
        'project' => '',
        // logstore 名称
        'logstore' => '',
        // source 标识
        'source' => '',
        // topic 标识
        'topic' => '',
        // 日志处理
        'processor' => null,
        // 关闭通道日志写入
        'close' => false,
        // 使用JSON格式记录
        'json' => true,
        // 是否实时写入
        'realtime_write' => false,
    ],
]
```

## 协议
MIT