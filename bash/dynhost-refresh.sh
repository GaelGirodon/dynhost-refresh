#!/bin/bash

#
# dynhost-refresh.sh
#
# Update the DynHost record if the public IP address has changed.
#

# IP
IP_WEBSITE="https://api.ipify.org"
#IP_CACHE_FILE="/path/to/ip.txt"

# NIC UPDATE
#DYNHOST_USER=""
#DYNHOST_PASSWORD=""
#DYNHOST_HOSTNAME=""

echo "======= DynHost refresh $(date '+%Y-%m-%d %H:%M:%S') ======="

#
# Check the public IP
#

# Load cached IP
ip_cache=""
if [ -f "${IP_CACHE_FILE}" ]; then
    ip_cache=$(cat "${IP_CACHE_FILE}")
fi
echo "Cached public IP: '${ip_cache}'"

# Get current public IP
ip=$(curl -s "${IP_WEBSITE}")
status=$?
if [ $status -ne 0 ]; then
    echo "Failed to get public IP from '${IP_WEBSITE}'"
    exit 1
fi
echo "Current public IP: '${ip}'"

#
# Refresh DynHost record
#

# Compare current public IP with cache
if [ "${ip}" = "${ip_cache}" ]; then
    echo "Public IP has not changed, DynHost record is already up-to-date"
    exit 0
fi
echo "Public IP has changed, DynHost record must be updated"

# Update DynHost
system='dyndns'
hostname="${DYNHOST_HOSTNAME}"
user="${DYNHOST_USER}"
password="${DYNHOST_PASSWORD}"
url="https://www.ovh.com/nic/update?system=${system}&hostname=${hostname}&myip=${ip}"

response=$(curl -s -u "${user}:${password}" "${url}")
status=$?
if [ $status -ne 0 ]; then
    echo "Failed to update the DynHost record"
    exit 2
fi
echo "DynHost record successfully updated (${response})"

# Update IP cache
echo "${ip}" > "${IP_CACHE_FILE}"
echo "IP cache updated"
