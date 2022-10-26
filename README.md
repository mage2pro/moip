The module integrates a Magento 2 based webstore with the **[Moip](https://moip.com.br)** payment service (Brazil).  
The module is **free** and **open source**.

## Screenshots
### 1. Bank card payments
#### 1.1. The frontend payment form
##### 1.1.1. A payment with a Hipercard bank card
![](https://mage2.pro/uploads/default/original/2X/5/5be78d30227e81f24a104091b9d748d907c5ddb7.png)

##### 1.1.2. A payment with an «Itaucard 2.0 Nacional Hiper» bank card
![](https://mage2.pro/uploads/default/original/2X/b/b9db493e23218811c7cd0a0cd73abb3648b91926.png)

##### 1.1.3. A payment with an Elo bank card
![](https://mage2.pro/uploads/default/original/2X/4/491dab8b47db2e155545465c38f8f34d52a6daff.png)

#### 1.2. The «Payment Information» block
##### 1.2.1. Frontend (inside the customer's account)
![](https://mage2.pro/uploads/default/original/2X/e/e9d7ccd6a4d0c3fb0539758bc0965884fd0f2f02.png)

##### 1.2.2. Backend
![](https://mage2.pro/uploads/default/original/2X/e/ed09b7940ab88b987b0df92ee6ba3ebc7e82ac28.png)

### 2. Boleto bancário
#### 2.1. A printed boleto slip
![](https://mage2.pro/uploads/default/original/2X/c/c1b0a759eb9da5798598568c587d2bce143c7107.png)

#### 2.2. The «Payment Information» block
##### 2.2.1. Frontend, inside the customer's account
![](https://mage2.pro/uploads/default/original/2X/2/260d1ff675344eacb0f95b8963c7f413f2d71d8a.png)

##### 2.2.2. Frontend, the «checkout success» page
![](https://mage2.pro/uploads/default/original/2X/f/f9f9ccbadfcc6d5bd3e6575c64b7ffeddba2029d.png)

### 3. The backend orders grid
![](https://mage2.pro/uploads/default/original/2X/f/fe0fe964687d0e261334a06332ad57182671cff8.png)

## Settings
![](https://mage2.pro/uploads/default/original/2X/3/3d7c313f42937046772dee0d2d6a8ae6b0f9182b.png)

### Are you an international shop looking for a Latin American payment solution?
Please  read **[3 simple facts](https://mage2.pro/t/topic/4242)** about the Brazilian eCommerce market, and how my extension fit in it.

## How to install
[Hire me in Upwork](https://www.upwork.com/fl/mage2pro), and I will: 
- install and configure the module properly on your website
- answer your questions
- solve compatiblity problems with third-party checkout, shipping, marketing modules
- implement new features you need 

### 2. Self-installation
```
bin/magento maintenance:enable
rm -f composer.lock
composer clear-cache
composer require mage2pro/moip:* --ignore-platform-req=php
bin/magento setup:upgrade
bin/magento cache:enable
rm -rf var/di var/generation generated/code
bin/magento setup:di:compile
rm -rf pub/static/*
bin/magento setup:static-content:deploy -f pt_BR en_US <additional locales>
bin/magento maintenance:disable
```

## How to update
```
bin/magento maintenance:enable
composer remove mage2pro/moip
rm -f composer.lock
composer clear-cache
composer require mage2pro/moip:* --ignore-platform-req=php
bin/magento setup:upgrade
bin/magento cache:enable
rm -rf var/di var/generation generated/code
bin/magento setup:di:compile
rm -rf pub/static/*
bin/magento setup:static-content:deploy -f pt_BR en_US <additional locales>
bin/magento maintenance:disable
```