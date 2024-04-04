# DynHost scripts - Python

Simple Python scripts to:

- Request DynHost credentials
- Update a DynHost record (using the Python library for OVH API)
  with the current public IP address if required.

## Install Python 3 and pip

```shell
sudo apt-get install python3 python3-pip
```

## Install Python libraries

```shell
pip3 install requests
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
