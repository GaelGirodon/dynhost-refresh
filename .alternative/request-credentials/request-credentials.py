#!/usr/bin/python3

# -*- encoding: utf-8 -*-

import json
import ovh
import time
import configparser

# Read config
config = configparser.ConfigParser()
config.read("../dynhost.conf")

zone_name = config['dynhost']['zone_name']
record_id = config['dynhost']['record_id']

# Instanciate an OVH Client
client = ovh.Client()

# Request a consumer key (API access)
ck = client.new_consumer_key_request()
ck.add_rules(ovh.API_READ_WRITE_SAFE, '/domain/zone/' + zone_name + '/dynHost/record/' + record_id)

# Request token
validation = ck.request()

print("Please visit %s to authenticate" % validation['validationUrl'])
time.sleep(60)

# Print nice welcome message
print("Btw, your 'consumerKey' is '%s'" % validation['consumerKey'])
