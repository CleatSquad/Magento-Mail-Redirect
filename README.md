# Magento 2 Mail Redirect

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![GitHub stars](https://img.shields.io/github/stars/mimou78/magento-2-mail-redirect)](https://github.com/mimou78/magento-2-mail-redirect/stargazers)
[![Latest Stable Version](https://poser.pugx.org/mimou78/magento-2-mail-redirect/v)](//packagist.org/packages/mimou78/magento-2-mail-redirect)
[![Total Downloads](https://poser.pugx.org/mimou78/magento-2-mail-redirect/downloads)](//packagist.org/packages/mimou78/magento-2-mail-redirect)
[![Open Source Helpers](https://www.codetriage.com/mimou78/magento-2-mail-redirect/badges/users.svg)](https://www.codetriage.com/mimou78/magento-2-mail-redirect)

This module allows you to redirect all emails that leave Magento to a specific email. and this in order to prevent customers during the development period from receiving test emails.

## Introduction

The recommended method for testing emails leaving Magento 2 is to use a mailCatcher like:

  * [MailHog](https://github.com/mailhog/MailHog)
  * [MailDev](https://github.com/maildev/maildev)
  * [MailCatcher](https://mailcatcher.me/)


But this is not always easy to setup in all environments and configurations.
Hence the usefulness of this module because it is easy to set up and to use.

## Installation

```
$ composer require "mimou78/magento-2-mail-redirect"
$ php bin/magento setup:upgrade
```

## Usage

`Magento Admin > Stores > Configuration > Advanced > Developer > Redirect Emails`

![Redirect Emails Admin Configuration](docs/img/redirect_mail_admin.png)
