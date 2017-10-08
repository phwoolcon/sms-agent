# sms-agent

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

SMS Sending Agent

## 1. Install

Install as a `phwoolcon` package

```bash
git clone git@github.com:phwoolcon/bootstrap.git sms-agent
cd sms-agent
bin/import-package git@github.com:phwoolcon/sms-agent.git
```


## 2. Usage

### 2.1. Sending SMS

#### 2.1.1 Get Sender Account
Access the sender's website and create an account before use this software.

List of senders:
* sms-cn: [云信 sms.cn](http://www.sms.cn/)

#### 2.1.2. Configure

Create production config, choose the default sender(`sms-cn` by default), and fill up the sender account info:
```bash
cp app/config/sms-agent.php app/config/production/sms-agent.php
vim app/config/production/sms-agent.php
```

#### 2.1.3. Compose and Send
```php
use SmsAgent;

$mobile = '13579246801';
$content = 'Test message';

SmsAgent::send($mobile, $content)
```

### 2.2. Self Hosted Agent
You can build a self hosted agent to centralize SMS sending stubs for all your applications, with package `phwoolcon/sms-agent-admin`.

## 3. Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## 4. Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## 5. Security

If you discover any security related issues, please email fishdrowned@gmail.com instead of using the issue tracker.

## 6. Credits

- [Christopher CHEN][link-author]
- [All Contributors][link-contributors]

## 7. License

The Apache License, Version 2.0. Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/phwoolcon/sms-agent.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-Apache%202.0-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/phwoolcon/sms-agent/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/phwoolcon/sms-agent.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/phwoolcon/sms-agent.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phwoolcon/sms-agent.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/phwoolcon/sms-agent
[link-travis]: https://travis-ci.org/phwoolcon/sms-agent
[link-scrutinizer]: https://scrutinizer-ci.com/g/phwoolcon/sms-agent/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/phwoolcon/sms-agent
[link-downloads]: https://packagist.org/packages/phwoolcon/sms-agent
[link-author]: https://github.com/Fishdrowned
[link-contributors]: ../../contributors
