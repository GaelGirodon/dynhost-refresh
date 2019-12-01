# DynHost refresh script - Bash

A simple Bash script without dependencies to update a DynHost entry.

Refresh the DynHost entry associated to the domain name.
Check the current public IP address and if it has changed,
the DynHost entry is updated.

## Setup

- Set variables values inside the script or using environment variables:
  - `IP_WEBSITE` (default: `https://api.ipify.org`)
  - `IP_CACHE_FILE`
  - `DYNHOST_USER`
  - `DYNHOST_PASSWORD`
  - `DYNHOST_HOSTNAME`
- Run the script (or add a crontab entry to run it periodically)

## Crontab example

```bash
@reboot /bin/bash '/path/to/dynhost-refresh.sh' >> /var/log/dynhost/dynhost-refresh.out.log 2>/var/log/dynhost/dynhost-refresh.err.log

*/30 * * * * /bin/bash '/path/to/dynhost-refresh.sh' >> /var/log/dynhost/dynhost-refresh.out.log 2>/var/log/dynhost/dynhost-refresh.err.log
```
