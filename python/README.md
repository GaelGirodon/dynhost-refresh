# DynHOST setup - Python

## Install Python 3 and pip

```shell
sudo apt-get install python3 python3-pip
```

## Install Python library for OVH API

```shell
pip3 install ovh
```

## Scripts setup

Copy the scripts and customize the configuration.

## Add an entry to crontab

```shell
sudo crontab -e
```

```shell
17 */3 * * *    /usr/bin/python3 /path/to/update-dynhost.py >> /path/to/log.txt
```
