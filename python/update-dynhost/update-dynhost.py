#!/usr/bin/python3

# -*- encoding: utf-8 -*-

import json
import ovh
import requests
import datetime
import configparser

print("\n########### " + str(datetime.datetime.utcnow()) + " UTC ###########")

config = configparser.ConfigParser()
config.read("../dynhost.conf")

ip_file_path = config['ip']['public_ip_cache_path']

###############################################################################

# Get public IP
try:
    current_ip = requests.get(config['ip']['public_ip_url']).text
    print("current_ip=" + current_ip)
except:
    print("Unable to get public IP")
    exit(1)

# Get old public IP (from last update)
try:
    with open(ip_file_path, 'r') as ip_file_r:
        old_ip = ip_file_r.read().replace('\n', '')
        print("old_ip=" + old_ip)
except:
    print("Unable to read old public IP from " + ip_file_path)
    old_ip = "" # Unknow => will force update

###############################################################################

# If IPs are the same, no need to update DynHost
if current_ip == old_ip:
    print("Public IP is already up-to-date")
    exit()

# else:
print("Public IP has changed")

# Save new IP
try:
    with open(ip_file_path, 'w') as ip_file_w:
        ip_file_w.write(current_ip)
    print("New public IP was saved to " + ip_file_path)
except:
    print("Unable to write new public ip to " + ip_file_path)

###############################################################################

# Initialize an OVH Client
client = ovh.Client()

zone_name = config['dynhost']['zone_name']
record_id = config['dynhost']['record_id']
sub_domain = config['dynhost']['sub_domain']

# Update the DynHost record
try:
    result = client.put('/domain/zone/' + zone_name + '/dynHost/record/' + record_id,
        ip = current_ip,            # IP address of the DynHost record (type: ip)
        subDomain = sub_domain,     # Subdomain of the DynHost record (type: string)
    )
    print("The OVH DynHost record was successfully updated")
except:
    print("Unable to update the DynHost record")
