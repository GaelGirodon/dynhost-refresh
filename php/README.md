# DynHost refresh script - PHP

A simple script to refresh a DynHost entry.

This script checks your current public IP address and
if it has changed, the DynHost entry is updated.

## Setup

### Requirements

- PHP >= 7.0
- Composer

### DynHost refresh setup

The script is provided in 2 versions:

- **refresh-dynhost-nic.php**: the update is done by sending a request to `nic/update`
- **refresh-dynhost-api.php**: the update is done using OVH API *[EXPERIMENTAL]*

Clone or download the repository.

Restore Composer packages:

```bash
composer install
```

Set the environment configuration (`.env` file):

```ini
# DynHost Refresh
# Configuration file

# IP
IP_WEBSITE="https://api.ipify.org"
IP_CACHE_FILE_PATH="/path/to/ip"

# NIC UPDATE
DYNHOST_USER="XXXXXXXXXXXXXXXXXXXXXXXXX"
DYNHOST_PASSWORD="XXXXXXXXXXXX"
DYNHOST_HOSTNAME="sub.domain.com"

# OVH API
APPLICATION_KEY="XXXXXXXXXXXXXXXX"
APPLICATION_SECRET="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"
API_ENDPOINT="ovh-eu"
CONSUMER_KEY="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"
API_PATH="/domain/zone/XXXXXXXXXXX.XX/dynHost/record/XXXXXXXXXX"
```

Choose to update the DynHost entry using classic **NIC update** or **OVH API**
by creating a symbolic link:

```bash
ln -s /path/to/refresh-dynhost-nic.php /path/to/refresh-dynhost.php
```

or

```bash
ln -s /path/to/refresh-dynhost-api.php /path/to/refresh-dynhost.php
```

### Add an entry to crontab

```bash
sudo crontab -e
```

```bash
*/10 * * * *    /usr/bin/php /path/to/refresh-dynhost.php >> /path/to/log 2>&1
```

In this example, the script will be called every 10 minutes.

## Resources

- <https://docs.ovh.com/fr/fr/web/domains/utilisation-dynhost/>
- <https://api.ovh.com>
- <http://docs.guzzlephp.org/en/stable/quickstart.html>
- <https://getgrav.org/blog/raspberrypi-nginx-php7-dev>
- <https://raspberrypi.stackexchange.com/questions/59435/how-to-use-stretch-testing-packages>
- <https://crontab.guru/>
- <https://github.com/github/gitignore/blob/master/Laravel.gitignore>
- <https://www.ipify.org/>
- <https://www.cyberciti.biz/faq/redirecting-stderr-to-stdout/>
- <https://github.com/yjajkiew/dynhost-ovh>
