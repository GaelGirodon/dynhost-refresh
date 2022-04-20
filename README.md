# DynHost refresh scripts

Multiples scripts, using different programming languages,
to refresh a DynHost entry.

Each script checks your current public IP address and
if it has changed, the DynHost entry is updated.

## About OVH DynHost

DynHost allows you to point your domain or sub-domain to an IP of connection
and, if it changes, to update it in real time.

## Scripts

- [**Bash**](bash/) - A simple Bash script without dependencies to update
  a DynHost entry
- [**Python**](python/) - Python 3 scripts to request credentials and update
  a DynHost entry using the Python library for OVH API
- [**PHP**](php/) - PHP scripts to update a DynHost entry using Composer,
  Guzzle, PHP dotenv and PHP library for OVH API

## License

**DynHost refresh scripts** are licensed under the GNU General Public License.
